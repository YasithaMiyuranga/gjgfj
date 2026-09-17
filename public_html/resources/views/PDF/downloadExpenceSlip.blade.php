<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <title>Additional Expence Tranfer Successful</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 300px;
            margin-bottom: auto;
            width: 400px;
            height: 500px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .success-icon {
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }
        .amount {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
            color: #000;
        }
        .recipient {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            color: #555;
        }
        .bank-details {
            font-size: 16px;
            color: #777;
            margin-top: 5px;
        }
        .transaction-info {
            font-size: 14px;
            color: #888;
            margin-top: 15px;
        }
        .button {
            margin-top: 30px;
            padding: 12px 24px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
        }
        .button:hover {
            background: #45a049;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <path d="M9.707 14.293L12 17.586l2.293-2.293" />
            </svg>
        </div>
        <div class="title">Payment Successful!</div>
        <div class="amount">LKR {{ $expence->amount }}</div>
        <div class="recipient">To</div>
        <div>{{ $expence->expense_name }}</div>
        <div class="transaction-info">Expense Date: {{ $expence->expense_date }}</div>
        <div>
        <button class="button">Done</button>
        <div class="footer">Thank you.</div>
    </div>
</body>
</html>

