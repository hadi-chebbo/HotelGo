<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px;
        }
        .info-box {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #1e3a8a;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }
        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
        .checklist {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .checklist ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .checklist li {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏨 Your Stay is Tomorrow!</h1>
        </div>
        
        <div class="content">
            <p>Hello <strong>{{ $reservation->user->name }}</strong>,</p>
            
            <p>This is a friendly reminder that your reservation at <strong>{{ $reservation->hotel->name }}</strong> is just one day away!</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #1e3a8a;">Reservation Details</h3>
                <div class="info-row">
                    <span class="label">Hotel:</span>
                    <span>{{ $reservation->hotel->name }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Room Type:</span>
                    <span>{{ $reservation->room->roomType->type }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Room Number:</span>
                    <span>{{ $reservation->room->room_number }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Check-in:</span>
                    <span>{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('l, F j, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Check-out:</span>
                    <span>{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('l, F j, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Check-in Time:</span>
                    <span>After 2:00 PM</span>
                </div>
            </div>

            @php
                $paidAmount = $reservation->payments->sum('amount');
                $remaining = $reservation->total_price - $paidAmount;
            @endphp

            @if($remaining > 0)
            <div class="info-box" style="background: #fee2e2; border-left-color: #ef4444;">
                <h3 style="margin-top: 0; color: #991b1b;">⚠️ Payment Reminder</h3>
                <p style="margin: 0;">You have a remaining balance of <strong>${{ number_format($remaining, 2) }}</strong> to be paid upon check-in.</p>
            </div>
            @else
            <div class="info-box" style="background: #d1fae5; border-left-color: #10b981;">
                <p style="margin: 0; color: #065f46;">✅ Your reservation is fully paid!</p>
            </div>
            @endif

            <div class="checklist">
                <h3 style="margin-top: 0; color: #92400e;">📋 Things to Remember:</h3>
                <ul>
                    <li>Bring a valid ID for check-in</li>
                    <li>Arrive after 2:00 PM for check-in</li>
                    @if($remaining > 0)
                    <li>Payment of ${{ number_format($remaining, 2) }} will be collected at check-in</li>
                    @endif
                    <li>Contact the hotel if you need to modify your reservation</li>
                </ul>
            </div>

            <p><strong>Hotel Address:</strong><br>
            {{ $reservation->hotel->location }}</p>

            @if($reservation->hotel->phone)
            <p><strong>Hotel Contact:</strong><br>
            {{ $reservation->hotel->phone }}</p>
            @endif

            <center>
                <a href="{{ url('/reservations') }}" class="button">View My Reservations</a>
            </center>

            <p style="margin-top: 30px;">We look forward to welcoming you!</p>
            
            <p>Best regards,<br>
            <strong>The HotelGo Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an automated reminder email from HotelGo.</p>
            <p>If you have any questions, please contact {{ $reservation->hotel->name }} directly.</p>
        </div>
    </div>
</body>
</html>