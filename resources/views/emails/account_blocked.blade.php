<div style="font-family: Arial, Helvetica, sans-serif; background-color:#f4f6f8; padding:30px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; border-radius:10px; padding:30px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

        <h2 style="text-align:center; margin-bottom:25px;">
            <span style="color:#2563eb; font-weight:bold;">Hotel</span><span style="color:#1e3a8a; font-weight:bold;">Go</span>
        </h2>

        <p style="font-size:16px; color:#333333;">
            Hello <strong>{{ $user->name }}</strong>,
        </p>

        <p style="font-size:15px; color:#555555; line-height:1.6;">
            We’re writing to inform you that your account has been <strong style="color:#dc2626;">temporarily blocked</strong>.
        </p>

        <p style="font-size:15px; color:#555555; line-height:1.6;">
            If you believe this is a mistake or need more information, please contact our support team.  
            We’re here to help.
        </p>

        <div style="margin-top:30px; text-align:center;">
            <a href="mailto:support@hotelgo.com"
               style="display:inline-block; background:#2563eb; color:#ffffff; padding:12px 24px;
                      text-decoration:none; border-radius:6px; font-size:14px;">
                Contact Support
            </a>
        </div>

        <p style="margin-top:30px; font-size:13px; color:#999999; text-align:center;">
            © {{ date('Y') }} HotelGo. All rights reserved.
        </p>
    </div>
</div>
