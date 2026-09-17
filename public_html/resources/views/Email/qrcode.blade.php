<!DOCTYPE html>
<html>
<head>
    <title>Your QR Codes</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4;">
    <div style="max-width:600px; margin:0 auto; background-color:#ffffff; border-radius:8px; font-family:Arial, sans-serif; color:#333333; padding:30px;">
        <div style="text-align:center;">
            <h1 style="margin-bottom:10px; color:#2c3e50;">Thank You for Your Purchase!</h1>
            <h2 style="margin-top:0; color:#2980b9;">Event: {{ $eventName }}</h2>
        </div>

        @foreach ($qrCodeDetails as $detail)
            <div style="margin-top:30px; padding-top:20px; border-top:1px solid #dddddd;">
                <h3 style="color:#34495e; margin-bottom:10px;">Category: {{ $detail['category_name'] }}</h3>
                <p style="font-size:14px; margin-top:0;"><strong>Quantity:</strong> {{ $detail['quantity'] }}</p>

                @foreach ($detail['qr_codes'] as $qr)
                    <div style="margin-bottom:30px; padding:15px; background-color:#f9f9f9; border:1px solid #e0e0e0; border-radius:6px;">
                        <p style="margin:0 0 10px;"><strong>Ticket ID : </strong> {{ $qr['ticket_id'] }}</p>
                        <p style="margin:0 0 10px;"><strong>Seat : </strong> {{ $detail['category_name'] }} {{$qr['seat']}}</p>

                        <div style="margin-bottom:10px;">
                            <strong>QR Code:</strong><br>
                            <img src="cid:{{ $qr['qr_code_cid'] }}" alt="QR Code" style="width:150px; margin-top:5px; display:block;">
                        </div>

                        <div>
                            <strong>Barcode:</strong><br>
                            <img src="cid:{{ $qr['bar_code_cid'] }}" alt="Barcode" style="width:200px; margin-top:5px; display:block;">
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        {{-- <div style="text-align:center; font-size:12px; color:#888888; margin-top:30px;">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div> --}}
    </div>
</body>
</html>
