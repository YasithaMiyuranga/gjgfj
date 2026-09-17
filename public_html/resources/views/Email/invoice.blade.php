<!DOCTYPE html>
<html>

<head>
    <title>Your Invoice</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; color: #333333;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 6px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h1 style="color: #2c3e50; text-align: center;">Thank you for your purchase!</h1>
        <h2 style="color: #16a085;">Event: {{ $eventName }}</h2>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background-color: #ecf0f1;">
                    <th style="padding: 10px; border: 1px solid #ccc; text-align: left;">Category</th>
                    <th style="padding: 10px; border: 1px solid #ccc; text-align: center;">Quantity</th>
                    <th style="padding: 10px; border: 1px solid #ccc; text-align: right;">Price Per Ticket</th>
                    <th style="padding: 10px; border: 1px solid #ccc; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                <tr>
                    <td style="padding: 10px; border: 1px solid #eee;">{{ $ticket['category_name'] }}</td>
                    <td style="padding: 10px; border: 1px solid #eee; text-align: center;">{{ $ticket['quantity'] }}</td>
                    <td style="padding: 10px; border: 1px solid #eee; text-align: right;">{{ $ticket['price_per_ticket'] }}</td>
                    <td style="padding: 10px; border: 1px solid #eee; text-align: right;">{{ $ticket['total'] }}</td>
                </tr>
                @endforeach
                <tr style="font-weight: bold;">
                    <td colspan="3" style="padding: 10px; text-align: right; border-top: 2px solid #ccc;">Total</td>
                    <td style="padding: 10px; text-align: right; border-top: 2px solid #ccc;">{{ $total }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="padding: 10px; text-align: right;">Discount</td>
                    <td style="padding: 10px; text-align: right;">{{ $discount }}</td>
                </tr>
                <tr style="font-weight: bold; background-color: #ecf0f1;">
                    <td colspan="3" style="padding: 10px; text-align: right;">Grand Total</td>
                    <td style="padding: 10px; text-align: right;">{{ $total - $discount }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>

