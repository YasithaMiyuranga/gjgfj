@extends('layouts.events')

@section('page-title', __('Events Calender'))

@section('action-button')
@endsection
@section('content')
  <!DOCTYPE html>
  <html lang='en'>
    <head>
      <meta charset='utf-8' />
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
      {{-- <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.14/index.global.min.js'></script> --}}

      <style>
        #calendar-container {
          position: relative;
          height: 100vh; /* Full viewport height */
          overflow-y: auto;
        }
        #calendar {
          height: 100px; /* Full height of the container */
        }
        /* Popup and legend styling */
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
        .edit-btn {
          background-color: #4CAF50;
          color: white;
          border: none;
          padding: 10px 20px;
          cursor: pointer;
          border-radius: 4px;
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
        /* For Mobile screens */
        @media only screen and (max-width: 768px) {
            #order-details {
                width: 80%;
                padding: 10px;
            }
        }
        @media only screen and (max-width: 768px) {
            .scrollable {
                overflow-x: auto;
            }
            .dataTable {
                min-width: 768px;
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
                width: 750px;
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
        $eventDates = []; // Array to store booking  dates and times
        $completedDates = []; // Array to store completed dates and times
      @endphp

      @foreach($events as $order)
          @php
          $color = '';
          // Status is booking
          if( $order->status == 'booking'){
              $color = '#51459';
          }
          // Status is credit
          if( $order->status == "credit"){
            $color = '#4599e7';
          }
          if( $order->status == "pending"){
            $color = '#379777';
          }
          if( $order->status == "completed"){
            $color = '#B8860B';
          }
          $startDate = date('Y-m-d H:i', strtotime($order->start_datetime));
          $endDate = date('Y-m-d H:i', strtotime($order->end_datetime));
          $eventDates[] = [
              'id' => $order->eid,   // Assuming booking order id
              'event_name' => $order->event_name, // Assuming booking event name
              'start' => $startDate, // Assuming booking start date and time
              'end' => $endDate, // Assuming booking end date and time
              'color' => $color
          ];
          @endphp
      @endforeach

      @foreach($completedData as $order)
          @php
            $color = '';
            if( $order->status == "completed"){
            $color = '#B8860B';
          }
          $startDate = date('Y-m-d H:i', strtotime($order->start_datetime));
          $endDate = date('Y-m-d H:i', strtotime($order->end_datetime));
          $completedDates[] = [
              'id' => $order->eid,   // Assuming booking order id
              'event_name' => $order->event_name, // Assuming booking event name
              'start' => $startDate, // Assuming booking start date and time
              'end' => $endDate, // Assuming booking end date and time
              'color' => $color
          ];
          @endphp
      @endforeach

      <div id="legend" class="col mt-3">
        <div class="row">
          <div class="col-6 d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: #836FFF; border-radius: 4px;"></div>
            <span>Booking Events</span>
          </div>
          <div class="col-6 d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: #379777; border-radius: 4px;"></div>
            <span>Pending Events</span>
          </div>
          <div class="col-6 d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: #4599e7; border-radius: 4px;"></div>
            <span>Credit Events</span>
          </div>
          <div class="col-6 d-flex align-items-center">
            <div style="width: 20px; height: 20px; background-color: #B8860B; border-radius: 4px;"></div>
            <span>Completed Events</span>
            <input class="ms-1 checkbox form-check-input" type="checkbox" id="showCompletedOrders" checked>
          </div>
        </div>
      </div>

      <div id="calendar-container">
        <div id="calendar"></div>
      </div>
      <div id="order-details"></div>

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
            initialView: 'dayGridMonth',
            height: 'auto',
            contentHeight: 'auto',
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
              var orderId = info.event.id;
              fetchOrderDetails(orderId);
            }
          });

          function addEventsToCalendar() {

            calendar.getEvents().forEach(event => event.remove()); // Remove all existing events first


            if (showCompletedCheckbox.checked) {

              completedDates.forEach(date => {
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

            eventDates.forEach(date => {
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

          showCompletedCheckbox.addEventListener('change', addEventsToCalendar);

          calendar.render();
          addEventsToCalendar(); // Initial load of events

          function fetchOrderDetails(orderId) {
            fetch(`/useradmin/order-details/${orderId}`)
              .then(response => response.json())
              .then(data => {
                var orderDetailsContainer = document.getElementById('order-details');
                orderDetailsContainer.style.display = 'block';
                orderDetailsContainer.innerHTML = `
                  <button style="float: right;" class="close-btn " onclick="closeOrderDetails()">X</button>
                  <h1>EVENT DETAILS</h1><br>
                  <h5>Event ID: ${data.event_details.id}</h5>
                  <h5>Event Name: ${data.event_details.event_name}</h5>
                  <h5>Location: ${data.event_details.location}</h5>
                  <h5>Customer Name:${data.event_details.customer_name}</h5>
                  <h5>Phone Number: ${data.event_details.customer_phone}</h5>
                  <h5>Event Date: ${data.event_details.start_datetime}</h5>
                  <h5>Event End Date: ${data.event_details.end_datetime}</h5>
                 <h2 class = "mt-3">Agent List</h2>
                 <div class="scrollable">
                    <table class="table dataTable">
                    <thead>
                        <tr>
                        <th>Agent ID</th>
                        <th>Agent Name</th>
                        <th>Agent Phone</th>
                        <th>Type
                        <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.agentList.map(agent => `
                        <tr>
                            <td>${agent.id}</td>
                            <td>${agent.name}</td>
                            <td>${agent.phone}</td>
                            <td>${agent.type}</td>
                            <td>${agent.status}</td>
                        </tr>
                        `).join('')}
                    </tbody>
                    </table>
                  </div>
                  <h2>Sponsor List</h2>
                  <div class="scrollable">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                <th>Sponsor ID</th>
                                <th>Sponsor Name</th>
                                <th>Sponsor Phone</th>
                                <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.sponsors.map(sponsor => `
                                <tr>
                                    <td>${sponsor.id}</td>
                                    <td>${sponsor.name}</td>
                                    <td>${sponsor.phone}</td>
                                    <td>${sponsor.status}</td>
                                </tr>
                                `).join('')}
                            </tbody>
                        </table>
                  </div>

                   <a href="javascript:void(0)">
                       <button class="btn btn-sm btn-info"
                               data-size="md"
                               data-url="/useradmin/event_sponsors/assign/${data.event_details.id}"
                               data-ajax-popup="true"
                               data-title="{{ __('Add Sponsor') }}"
                               class="dropdown-item"
                               data-bs-placement="top">
                           Add Sponsors
                       </button>
                   </a>
                `;
              });
          }
          window.closeOrderDetails = function() {
            var orderDetailsContainer = document.getElementById('order-details');
            orderDetailsContainer.style.display = 'none';
          }
        });
      </script>
      <script>
        const eventDates = @json($eventDates);
        const completedDates = @json($completedDates);
      </script>
    </body>
  </html>
@endsection
