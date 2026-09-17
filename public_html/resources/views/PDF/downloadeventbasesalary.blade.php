<!DOCTYPE html>
<html>
<head>
    <title>Event Base Salary Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }
        .table-wrap {
            margin-top: 20px;
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table tbody tr:last-child td {
            border-bottom: none;
            font-weight: bold;
            background-color: #e9ecef;
        }
        .table tbody tr:last-child td:last-child {
            color: #007bff;
        }
    </style>
</head>
<body>
    <h1>Event Base Salary Report</h1>
    <p>Event Name: {{ $event->event_name }}</p>
    <p>Event ID: {{ $event->eid }}</p>
    <p>Event Start Date: {{ $event->start_datetime }}</p>
    <p>Event End Date: {{ $event->end_datetime }}</p>
    <p>Event Location: {{ $event->location }}</p>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Role</th>
                    <th>Base Salary</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($event_base_salary as $employee)
                    <tr>
                        <td>{{ $employee->emp_id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->emp_type }}</td>
                       <td>{{ number_format($employee->total_job_amount, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Total Salary:</td>
                   <td>{{ number_format($event_base_salary->sum('total_job_amount'), 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
