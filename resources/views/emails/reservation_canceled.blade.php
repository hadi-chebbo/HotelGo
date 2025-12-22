<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Cancelled</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: Arial, sans-serif; color: #1f2937;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); overflow: hidden;">

        <!-- Header -->
        <div style="background-color: #1e40af; padding: 20px; display: flex; align-items: center; justify-content: space-between; color: #ffffff;">
            <h1 style="font-size: 20px; margin: 0; font-weight: bold;">Reservation Cancelled</h1>
        </div>

        <!-- Body -->
        <div style="padding: 24px;">
            <p style="margin-bottom: 16px;">
                Dear <span style="font-weight: bold;">{{ $reservation->hotel->name ?? 'Hotel Manager' }}</span>,
            </p>

            <p style="margin-bottom: 16px;">
                We would like to inform you that the reservation made by 
                <span style="font-weight: bold;">{{ $reservation->user->name ?? 'A user' }}</span> 
                for <span style="font-weight: bold;">{{ $reservation->hotel->name ?? 'your hotel' }}</span> 
                has been <span style="font-weight: bold; color: #dc2626;">cancelled</span>.
            </p>

            <div style="margin-bottom: 24px;">
                <p style="font-weight: bold; margin-bottom: 8px;">Reservation Details:</p>
                <ul style="list-style-type: disc; padding-left: 20px; color: #374151; margin: 0;">
                    <li>Reservation Number: {{ $reservation->room->room_number ?? '-' }}</li>
                    <li>Check-in: {{ $reservation->check_in_date ?? '-' }}</li>
                    <li>Check-out: {{ $reservation->check_out_date ?? '-' }}</li>
                </ul>
            </div>

            <p style="margin-bottom: 24px;">
                Thank you for managing your bookings with <span style="font-weight: bold;">HotelGo</span>.
            </p>

            <div style="font-size: 12px; color: #6b7280; text-align: center;">
                &copy; {{ date('Y') }} HotelGo. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
