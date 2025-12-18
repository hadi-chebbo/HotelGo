<div style="font-family: Arial, Helvetica, sans-serif; background-color:#f4f6f8; padding:30px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; border-radius:10px; padding:30px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

        <h2 style="text-align:center; margin-bottom:25px;">
            <span style="color:#2563eb; font-weight:bold;">Hotel</span><span style="color:#1e3a8a; font-weight:bold;">Go</span>
        </h2>

        <p style="font-size:16px; color:#333333;">
            Hello <strong>{{ $user->name }}</strong>,
        </p>

        <p style="font-size:15px; color:#555555; line-height:1.6;">
            Good news! 🎉 Your account has been
            <strong style="color:#16a34a;">successfully reactivated</strong>.
        </p>

        <p style="font-size:15px; color:#555555; line-height:1.6;">
            You now have full access to the system and can continue using all
            our services without any restrictions.
        </p>

        <div style="margin-top:30px; text-align:center;">
            <a href="{{ url('/login') }}"
               style="display:inline-block; background:#16a34a; color:#ffffff; padding:12px 24px;
                      text-decoration:none; border-radius:6px; font-size:14px;">
                Login to Your Account
            </a>
        </div>

        <p style="margin-top:30px; font-size:13px; color:#999999; text-align:center;">
            © {{ date('Y') }} HotelGo. All rights reserved.
        </p>
    </div>
</div>
