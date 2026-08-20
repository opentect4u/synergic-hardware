require('dotenv').config({ path: require('path').resolve(__dirname, '../.env') });

const express = require('express');
const stockAlertController = require('./src/controllers/stockAlertController');

const app = express();
const port = Number(process.env.ALERT_PORT || 3020);

app.use(express.json());

app.get('/health', (req, res) => {
  res.json({ status: 'ok' });
});

app.post('/alerts/low-stock', async (req, res) => {
  try {
    const result = await stockAlertController.run({
      asOfDate: req.body && req.body.date,
      dryRun: Boolean(req.body && req.body.dryRun)
    });

    res.json(result);
  } catch (error) {
    console.error(error.message);
    res.status(500).json({ error: error.message });
  }
});

async function runOnce() {
  const dryRun = process.argv.includes('--dry-run');
  const result = await stockAlertController.run({ dryRun });
  console.log(JSON.stringify(result, null, 2));
}

if (process.argv.includes('--run-once')) {
  runOnce()
    .then(() => process.exit(0))
    .catch((error) => {
      console.error(error.stack || error.message);
      process.exit(1);
    });
} else {
  app.listen(port, () => {
    console.log(`Stock alert service listening on port ${port}`);
  });
}

module.exports = app;
