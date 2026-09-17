<!DOCTYPE html>
<html>
<head>
    <title>Booking Unsuccessful – Seat(s) Unavailable</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif; color:#333333;">
    <div style="max-width:600px; margin:0 auto; background-color:#ffffff; border-radius:8px; padding:30px;">
        
        <div style="text-align:center;">
            <h2 style="margin:0; color:#2980b9;">Event: {{ $event->event_name }}</h2>
            <h3 style="margin-top:10px; color:#e74c3c;">Your Booking Couldn’t Be Completed</h3>
            <p style="font-size:14px; color:#555555; margin: 10px 0 0 0;">
                Unfortunately, the seat(s) you selected have already been booked by another customer.
            </p>
        </div>

        <div style="margin-top:30px; font-size:14px; color:#333;">
            <p>
                We have processed a <strong>full refund</strong> for your booking. If you do not receive the refund within 3–5 business days, please contact our customer care team at <a href="mailto:support@example.com" style="color:#2980b9;">support@example.com</a>.
            </p>
        </div>

        <div style="margin-top:30px;">
            <h3 style="color:#2980b9; margin-bottom:10px;">Available Seats</h3>

            <!-- Seat Color Key -->
            <div style="margin-bottom:15px;">
                <span style="display:inline-block; width:15px; height:15px; background-color:#dc3545; border:1px solid #ccc; margin-right:5px;"></span>
                <span style="font-size:13px; margin-right:20px;">Unavailable</span>
                <span style="display:inline-block; width:15px; height:15px; background-color:#ffffff; border:1px solid #ccc; margin-right:5px;"></span>
                <span style="font-size:13px;">Available</span>
            </div>

            @foreach ($tickets as $ticket)
                <div style="margin-bottom:30px;">
                    <h4 style="margin:0 0 10px 0; color:#333;">
                        {{ $ticket->tickets_category }} – {{ $ticket->price }} {{ $ticket->currency }}
                    </h4>

                    <div style="padding:10px; background-color:#f9f9f9; border-radius:8px; text-align:center;">
                        @for ($i = 0; $i < $ticket->initial_tickets_count; $i++)
                            @php
                                $seatNumber = $i + 1;
                                $isSoldOut = in_array($seatNumber, $ticket->sold_out_seats ?? []);
                                $bgColor = $isSoldOut ? '#dc3545' : '#ffffff';
                                $textColor = $isSoldOut ? '#ffffff' : '#000000';
                            @endphp
                            <span style="
                                display: inline-block;
                                width: 30px;
                                height: 30px;
                                line-height: 30px;
                                font-size: 12px;
                                margin: 4px;
                                text-align: center;
                                border-radius: 4px;
                                background-color: {{ $bgColor }};
                                color: {{ $textColor }};
                                border: 1px solid #ccc;">
                                {{ $seatNumber }}
                            </span>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top:40px; font-size:13px; color:#888888; text-align:center;">
            <p>If you have any questions or concerns, please don't hesitate to contact us.</p>
            <p>Thank you for your understanding.</p>
        </div>
    </div>
</body>
</html>
