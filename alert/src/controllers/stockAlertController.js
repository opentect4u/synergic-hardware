const db = require('../db');
const snsService = require('../services/snsService');

function formatDate(date) {
  const value = date || new Date().toISOString().slice(0, 10);
  if (!/^\d{4}-\d{2}-\d{2}$/.test(value)) {
    throw new Error('The stock date must be in YYYY-MM-DD format.');
  }
  return value;
}

function financialStartDate(asOfDate) {
  const date = new Date(`${asOfDate}T00:00:00Z`);
  const year = date.getUTCMonth() >= 3 ? date.getUTCFullYear() : date.getUTCFullYear() - 1;
  return `${year}-04-01`;
}

async function getLowStockItems(asOfDate) {
  const startDate = financialStartDate(asOfDate);
  const [machines] = await db.query(
    'SELECT mc_id, mc_type FROM md_mc_type ORDER BY mc_type ASC'
  );
  const [centres] = await db.query(
    'SELECT sl_no, center_name FROM md_service_centre ORDER BY sl_no ASC'
  );
  const [thresholds] = await db.query(
    'SELECT mc_id, stk_val FROM td_stock_threshold'
  );
  const thresholdByMachine = new Map(thresholds.map((row) => [Number(row.mc_id), Number(row.stk_val)]));
  const lowStock = [];

  for (const machine of machines) {
    let total = 0;
    const centreStock = {};

    for (const centre of centres) {
      const [openingRows] = await db.query(
        'SELECT total_qty FROM td_opening WHERE mc_type = ? AND serv_ctr = ? AND date = ? LIMIT 1',
        [machine.mc_id, centre.sl_no, startDate]
      );
      const [transactionRows] = await db.query(
        `SELECT COALESCE(SUM(mc_qty), 0) AS quantity
           FROM td_device_trans
          WHERE mc_type = ?
            AND serv_ctr = ?
            AND approval_status = 'U'
            AND arrival_dt >= ?
            AND arrival_dt <= ?`,
        [machine.mc_id, centre.sl_no, startDate, asOfDate]
      );

      const stock = Number((openingRows[0] && openingRows[0].total_qty) || 0)
        + Number(transactionRows[0].quantity || 0);
      centreStock[centre.center_name] = stock;
      total += stock;
    }

    if (thresholdByMachine.has(Number(machine.mc_id))
      && total < thresholdByMachine.get(Number(machine.mc_id))) {
      lowStock.push({
        machineId: machine.mc_id,
        machineType: machine.mc_type,
        finalStock: total,
        threshold: thresholdByMachine.get(Number(machine.mc_id)),
        centreStock
      });
    }
  }

  return lowStock;
}

function formatMessage(asOfDate, items) {
  const lines = [
    `Stock Alert - ${asOfDate}`,
    '',
    'Sl. No. | Item Name | Final Stock',
    '-----------------------------------'
  ];

  items.forEach((item, index) => {
    lines.push(`${index + 1}. ${item.machineType} | ${item.finalStock}`);
  });

  return lines.join('\n');
}

async function run(options) {
  const asOfDate = formatDate(options && options.asOfDate);
  const items = await getLowStockItems(asOfDate);
  const message = items.length ? formatMessage(asOfDate, items) : null;
  const dryRun = Boolean(options && options.dryRun);
  const result = {
    asOfDate,
    lowStock: items,
    published: false,
    dryRun,
    message
  };

  if (items.length && !dryRun) {
    await snsService.publishLowStockAlert(message);
    result.published = true;
  }

  return result;
}

module.exports = { run, getLowStockItems };
