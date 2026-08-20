const AWS = require('aws-sdk');

function publishLowStockAlert(message) {
  const topicArn = process.env.SNS_STOCK_TOPIC_ARN;
  if (!topicArn) {
    throw new Error('SNS_STOCK_TOPIC_ARN is not configured.');
  }

  const sns = new AWS.SNS({
    region: process.env.AWS_DEFAULT_REGION || 'us-east-1'
  });

  return sns.publish({
    TopicArn: topicArn,
    Subject: 'Low new device stock alert',
    Message: message
  }).promise();
}

module.exports = { publishLowStockAlert };
