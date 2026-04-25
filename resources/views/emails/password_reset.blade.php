<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background: #f5f5f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <div style="max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, var(--ud-orange-dark), #f97316); padding: 32px; text-align: center;">
            <h1 style="margin: 0; color: #fff; font-size: 24px;">🐾 Pet Markt-PH</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 8px 0 0; font-size: 14px;">Password Reset Request</p>
        </div>

        <!-- Body -->
        <div style="padding: 32px;">
            <p style="color: #333; font-size: 16px; margin-bottom: 8px;">
                Hi <strong>{{ $user->first_name ?? $user->name ?? 'there' }}</strong>,
            </p>
            <p style="color: #666; font-size: 14px; line-height: 1.6;">
                We received a request to reset your password. Click the button below to set a new password.
                This link will expire in <strong>60 minutes</strong>.
            </p>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 32px 0;">
                <a href="{{ $resetUrl }}" style="display: inline-block; background: var(--ud-orange-dark); color: #fff; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 15px;">
                    Reset My Password
                </a>
            </div>

            <p style="color: #999; font-size: 13px; line-height: 1.5;">
                If you didn't request this password reset, you can safely ignore this email. Your password will remain unchanged.
            </p>

            <hr style="border: none; border-top: 1px solid #eee; margin: 24px 0;">

            <p style="color: #bbb; font-size: 12px;">
                If the button doesn't work, copy and paste this link into your browser:<br>
                <a href="{{ $resetUrl }}" style="color: var(--ud-orange-dark); word-break: break-all;">{{ $resetUrl }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #fafafa; padding: 20px; text-align: center; border-top: 1px solid #eee;">
            <p style="margin: 0; color: #999; font-size: 12px;">
                &copy; {{ date('Y') }} Pet Markt-PH. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
