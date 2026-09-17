@extends('layouts.manager')
@section('page-title', __('Jobs Calender'))

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('manager.man.viewcalendar') }}">{{ __('Calender') }}</a>
    </li>
@endsection
@section('content')
<!DOCTYPE html>
<html lang='en'>
    <head>
      <meta charset='utf-8' />
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <style>
        #calendar-container {
          position: relative;
          height: 100vh; /* Adjust the height as needed */
          overflow-y: auto;

        }
        .container {
          height: 1000px;
        }
        #order-details {
          display: none; /* Initially hidden */
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          padding: 20px;
          background: #292a33;
          z-index: 1000;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
          border-radius: 8px;
          width: 500px;
          border: 2px solid rgb(252, 249, 249);
        }
        .close-btn {
          background-color: #292a33;
          border: 1px solid rgb(252, 249, 249);
          color: white;
          border: none;
          /* padding: 10px 20px; */
          cursor: pointer;
          border-radius: 4px;
        }
        h1{
          text-align: center;
        }
        #legend {
          background: #f8f9fa;
          color: black;
          padding: 5px;
          border: 1px solid #ddd;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #legend div {
          display: flex;
          align-items: center;
        }
        #legend div:last-child {
          margin-bottom: 0;
        }
        #legend span {
          margin-left: 5px;
        }
        /* Mobile Styles */
        @media screen and (max-width: 768px) {
            #order-details {
                width: 80%;
                padding: 10px;
            }
            .close-btn {
                font-size: 14px;
                padding: 8px 16px;
                top: 5px;
                right: 5px;
            }

            h1 {
                font-size: 18px; /* Adjust heading size */
            }

            h5 {
                font-size: 14px; /* Adjust subheading size */
            }
        }
         /* For medium screens  */
         @media only screen and (max-width: 992px) and (min-width: 769px) {
            #order-details {
                width: 60%;
                padding: 15px;
            }
        }
          /* For large screens  */
        @media only screen and (min-width: 993px) {
            #order-details {
                width: 500px;
                padding: 20px;
            }
        }
        @media (min-width: 992px) {
          #legend .row {
            flex-wrap: nowrap;
          }
          #legend .col-md-6 {
            flex: 1;
          }
        @media (max-width: 991px) {
          #legend .col-6 {
            width: 50%;
          }
        }

        @media (min-width: 992px) {
          #legend .row {
            display: flex;
            flex-wrap: nowrap;
            gap: 10px;
            justify-content: space-between;
          }
          #legend .col-6 {
            width: auto;
            flex: 1;
          }
        }
      }

  </style>
    </head>
    <body>
    @php
        $bookingCreditDataDetails = []; // Array to store assigned booking and credit events details
        $completedData = []; // Array to store completed events details
        $allBookingEvents = []; // Array to store all booking events
    @endphp

    @foreach($managerEvents as $events)
        @php
        $color = '#B3E5FC';
        if( $events->status == "Ongoing"){
        $color = '#379777';
        }else if($events->status=="Completed"){
          $color = '#B8860B';
        }else if($events->status=="pending"){
          $color = '#4599e7';
        }
        $startDate = date('Y-m-d H:i', strtotime($events->start_datetime));
        $endDate = date('Y-m-d H:i', strtotime($events->end_datetime));
        $allBookingEvents[] = [
            'id' => $events->eid,   // Assuming booking order id
            'event_name' => $events->event_name, // Assuming booking event name
            'start' => $startDate, // Assuming booking start date and time
            'end' => $endDate, // Assuming booking end date and time
            'color' => $color
        ];
        @endphp
    @endforeach
      <h1 style="text-align:center">Events Calender</h1>
      <div id="legend" class="col">
        <div class="row">
          {{-- <div class="col-6 d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: #836FFF; border-radius: 4px;"></div>
            <span>Assigned Booking Events</span>
          </div> --}}
          <div class="col-6 d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: #379777; border-radius: 4px;"></div>
            <span>Ongoing Events</span>
          </div>
          <div class="col-6 d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: #4599e7; border-radius: 4px;"></div>
            <span>Pending Events</span>
          </div>
          <div class="col-6 d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: #B8860B; border-radius: 4px;"></div>
            <span>Completed Events</span>
            <input class="ms-1 checkbox" type="checkbox" id="showCompletedOrders" checked>
          </div>
        </div>
      </div>
      <div id="calendar-container">
        <div id="calendar"></div>

      </div>
      <div id="order-details">

      </div>
      <script>
       
        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var showCompletedCheckbox = document.getElementById('showCompletedOrders');

          var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
              start: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
              center: 'title',
              end: 'prev,today,next'
            },
            navLinks: true,
            buttonText: {
              dayGridMonth: 'Month',
              timeGridWeek: 'Week',
              timeGridDay: 'Day',
              listWeek: 'List week'
            },
            height: 'auto',
            contentHeight: 'auto',
            initialView: 'dayGridMonth',
            dayHeaders: true,
            timeZone: 'UTC',
            eventTimeFormat: {
              hour: '2-digit',
              minute: '2-digit',
              hour24: true
            },
            eventDidMount: function(info) {
              if (info.event.extendedProps.color) {
                info.el.style.backgroundColor = info.event.extendedProps.color;
                info.el.style.borderColor = info.event.extendedProps.color;
              }
            },
            events: [], // Placeholder for dynamic events
            eventClick: function(info) {
              var eventId = info.event.id; // Get the order ID from the event
              fetchOrderDetails(eventId);
            }
          });
        function addEventsToCalendar() {
            calendar.getEvents().forEach(event => event.remove()); // Remove all existing events first
                allBookingEvents.forEach(date => {
                calendar.addEvent({
                  title: date.event_name,
                  start: date.start,
                  end: date.end,
                  id: date.id,
                  color: date.color,
                  extendedProps: { color: date.color }
                });
              });
          

            if (showCompletedCheckbox.checked) {
                completedData.forEach(date => {
                calendar.addEvent({
                  title: date.event_name,
                  start: date.start,
                  end: date.end,
                  id: date.id,
                  color: date.color,
                  extendedProps: { color: date.color }
                });
              });
            }


          }
          showCompletedCheckbox.addEventListener('change', addEventsToCalendar);

          calendar.render();
          addEventsToCalendar(); // Initial load of events
          

          window.closeOrderDetails = function() {
            var orderDetailsContainer = document.getElementById('order-details');
            orderDetailsContainer.style.display = 'none';
          }
        });

        const bookingCreditDataDetails = @json($bookingCreditDataDetails);
        const completedData = @json($completedData);
        const allBookingEvents = @json($allBookingEvents);
      </script>
  </html>
@endsection
