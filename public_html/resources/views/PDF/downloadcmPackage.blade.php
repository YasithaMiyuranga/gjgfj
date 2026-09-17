<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Quotation</title>
    <style>
        body {
            margin: 5px;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;

        }

        .quotation {
            width: 100%;
            background-color: #faf9f9;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 3px;

        }

        .quotation-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .quotation-heading h1 {
            font-size: 28px;
            margin: 0;
        }

        .quotation-heading h3 {
            font-size: 20px;
            margin: 0;
            color: #555;
        }

        .quotation-address {
            text-align: right;
        }

        .quotation-address h4 {
            font-size: 16px;
            margin: 0;
        }

        .quotation-address address {
            font-style: normal;
            font-size: 14px;
            color: #555;
            margin-top: 5px;
        }

        .quotation-details {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }

        .quotation-details h4 {
            font-size: 16px;
            margin: 0;
            color: #000;
        }

        .quotation-details strong {

            font-size: 14px;
            margin-bottom: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table thead th {
            background-color: #000;
            color: #fff;
            text-align: left;
            padding: 10px;
        }

        .table tbody td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
        }

        .table tbody td span {
            text-transform: none;
        }

        .quotation-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }

        .footer-bottom {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #0a0a0a;
        }
    </style>
</head>

<body>
    <div class="quotation">
        <div class="quotation-heading">
            <div>
                <h1>QUOTATION</h1>
                <h3>Lion Events</h3>
            </div>
            <div class="quotation-address">
                <h4>4A Holding Pvt (Ltd)</h4>
                <address>
                    No 169, Mahapala waththa,<br>
                    Hakmana Road, Thudava, Matara<br>
                    Tel - 0777 83 6963
                </address>
            </div>
        </div>
        <div class="quotation-details">
            <div>
                <strong>QUOTATION TO:</strong>
                <h4>{{ $customer_package->customer_name }}</h4>
                <p>Tel No: {{ $customer_package->mobile_no }}</p>
            </div>
            <div>
                <strong>TOTAL DUE:</strong>
                <h4>{{ number_format($customer_package->price, 2) }}</h4>
                <p>Date: {{ date('d/m/Y') }}</p>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 70%;">PRODUCTS</th>
                    <th style="text-align: center;">QTY</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($customer_package_items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="quotation-details">
            <h4>Payment Method :</h4>
            Bank Name :Seylan Bank  Matara<br>
            Branch Name :Bazzar Account Nb<br>
            Bank Account : 1650-13578990-001 <br>
            Account Name :4A Holdings PVT LTD
        </div>

        <div class="quotation-details">
            <h4>Grand Total:</h4>
            <h4>{{ number_format($customer_package->price, 2) }}</h4>
        </div>

        <div class="quotation-footer">
            <p>For any enquiries, call us on +94 77 783 6963</p>
            <div class="footer-bottom">
                Thank you for your business!
            </div>
        </div>
    </div>
</body>

</html>
