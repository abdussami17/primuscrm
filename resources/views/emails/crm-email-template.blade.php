<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .wrapper { max-width: 640px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        .header { background-color: rgb(0, 33, 64); padding: 20px 30px; }
        .header img { max-height: 40px; }
        .body { padding: 28px 30px; color: #333333; line-height: 1.7; font-size: 15px; }
        .body p { margin: 0 0 12px 0; }
        .footer { padding: 16px 30px; background: #f0f0f0; font-size: 12px; color: #888; border-top: 1px solid #e0e0e0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <span style="color:#fff; font-size:18px; font-weight:bold;">Primus CRM</span>
        </div>
        <div class="body">
            {!! strip_tags($emailBody) !== $emailBody ? $emailBody : nl2br(e($emailBody)) !!}
        </div>
        <div class="footer">
            This message was sent via Primus CRM. Please reply directly to this email to continue the conversation.
        </div>
    </div>
</body>
</html>
