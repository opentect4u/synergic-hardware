const { PublishCommand, SNSClient } = require('@aws-sdk/client-sns');

function publishLowStockAlert(message) {
  const topicArn = process.env.SNS_STOCK_TOPIC_ARN;
  if (!topicArn) {
    throw new Error('SNS_STOCK_TOPIC_ARN is not configured.');
  }

  const sns = new SNSClient({
    region: process.env.AWS_DEFAULT_REGION || 'us-east-1'
  });

  return sns.send(new PublishCommand({
    TopicArn: topicArn,
    Subject: 'Low new device stock alert',
    Message: message
  }));
}

module.exports = { publishLowStockAlert };
