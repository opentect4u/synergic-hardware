# Stock Alert Service

This Node.js service uses the Laravel application's root `.env` and MySQL database settings. It calculates new-device stock using the same rule as the Laravel stock report:

- opening quantity from `td_opening` for the current financial year
- plus `td_device_trans.mc_qty` through the selected date
- only transactions with `approval_status = 'U'`
- grouped by machine type and service centre
- compared with `td_stock_threshold`

## Install

From `C:\inetpub\wwwroot\service\alert`:

```powershell
npm install
```

Add `SNS_STOCK_TOPIC_ARN` to the Laravel root `.env`. AWS credentials and region are read from the same root `.env` (`AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, and `AWS_DEFAULT_REGION`).

## Test without publishing

```powershell
npm run dry-run
```

This calculates and prints the alert but intentionally does not send email. Use `npm run alert` to publish the alert through SNS.

## Run once and publish

```powershell
npm run alert
```

For Windows Task Scheduler, use `node.exe` as the program, `server.js --run-once` as arguments, and `C:\inetpub\wwwroot\service\alert` as the working directory.

## Run as an HTTP service

```powershell
npm start
```

- `GET /health`
- `POST /alerts/low-stock` with optional JSON `{ "date": "YYYY-MM-DD", "dryRun": true }`
