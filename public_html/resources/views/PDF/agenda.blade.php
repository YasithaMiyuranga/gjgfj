<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Agenda</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000; /* Black background */
            color: #fff; /* White text for contrast */
        }

        .header {
            text-align: center;
            padding: 20px;
            background: #222; /* Dark background for header */
        }

        .header h1 {
            font-size: 32px;
            margin: 0;
            color: #ff9f43; /* Accent color */
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #ccc; /* Subtle text color */
        }

        .agenda-container {
            padding: 20px;
        }

        .agenda-day {
            margin-bottom: 20px;
        }

        .agenda-day h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #ff9f43; /* Accent color for day titles */
            border-bottom: 2px solid #ff9f43;
            padding-bottom: 5px;
        }

        .agenda-item {
            display: flex;
            align-items: center;
            background: #1a1a1a; /* Dark background for items */
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .agenda-item .time {
            flex: 0 0 100px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            background: #ff9f43; /* Accent background for time */
            color: #000;
            padding: 10px;
            border-radius: 8px;
            margin-right: 15px;
        }

        .agenda-item .details {
            flex: 1;
        }

        .agenda-item .details strong {
            display: block;
            font-size: 18px;
            margin-bottom: 5px;
            color: #fff; /* Highlight title text */
        }

        .agenda-item .details p {
            margin: 0;
            color: #ccc; /* Subtle text for descriptions */
        }

        @media (max-width: 768px) {
            .agenda-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .agenda-item .time {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $event->event_name }}</h1>
        <p>{{ $event->start_datetime }} - {{ $event->end_datetime }}</p>
        <p>Location: {{ $event->location }}</p>
    </div>

    <div class="agenda-container">
        @foreach ($event->agendas as $agenda)
            <div class="agenda-day">
                <h2>{{ $agenda->date_name }}</h2>
                @foreach ($agenda->agendaDetails as $agendaDetail)
                    <div class="agenda-item">
                        <div class="time">
                            {{ date('h:i A', strtotime($agendaDetail->time)) }}
                        </div>
                        <div class="details">
                            <strong>{{ $agendaDetail->title }}</strong>
                            <p>{{ $agendaDetail->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</body>
</html>
