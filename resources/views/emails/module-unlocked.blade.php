<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module Unlocked - {{ $module->module_name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #64748b;
            margin: 10px 0 0 0;
            font-size: 16px;
        }
        .success-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .module-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin: 25px 0;
            text-align: center;
        }
        .module-card h2 {
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .module-card p {
            margin: 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .details {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #475569;
        }
        .detail-value {
            color: #1e293b;
        }
        .code-highlight {
            background: #1e293b;
            color: #f1f5f9;
            padding: 8px 12px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 14px;
        }
        .warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .warning-icon {
            font-size: 20px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">🎓</div>
            <h1>Module Unlocked Successfully!</h1>
            <p>Congratulations! You've successfully unlocked a new learning module.</p>
        </div>

        <div class="module-card">
            <h2>{{ $module->module_name }}</h2>
            <p>{{ $module->description }}</p>
        </div>

        <div class="details">
            <h3 style="margin-top: 0; color: #1e293b;">📋 Unlock Details</h3>
            
            <div class="detail-row">
                <span class="detail-label">👤 Student Name:</span>
                <span class="detail-value">{{ $user->name }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">📧 Email:</span>
                <span class="detail-value">{{ $user->email }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">🔑 Activation Code:</span>
                <span class="detail-value">
                    <span class="code-highlight">{{ $kitCode->code }}</span>
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">🎯 Focus Area:</span>
                <span class="detail-value">{{ $module->focus_area }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">👥 Age Group:</span>
                <span class="detail-value">{{ $module->suggested_age_group }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">⏱️ Duration:</span>
                <span class="detail-value">{{ $module->duration }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">📅 Unlocked On:</span>
                <span class="detail-value">{{ now()->format('F j, Y \a\t g:i A') }}</span>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ config('app.url') }}/modules/{{ $module->slug }}" class="cta-button">
                🚀 Start Learning Now
            </a>
        </div>

        <div class="warning">
            <span class="warning-icon">⚠️</span>
            <strong>Important:</strong> This activation code has been used and cannot be used again. Keep this email for your records.
        </div>

        <div class="footer">
            <p>Happy Learning! 🎉</p>
            <p>This is an automated message from your Learning Management System.</p>
            <p>If you have any questions, please contact your instructor.</p>
        </div>
    </div>
</body>
</html>
