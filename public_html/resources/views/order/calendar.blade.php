@extends('layouts.app')
@section('page-title', __('Calendar'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.order.calendar') }}">{{ __('Calendar') }}</a>
    </li>
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
                 <h2>Orders</h2>
                 <div class="scrollable">
                    <table class="table dataTable">
                    <thead>
                        <tr>
                        <th>Order ID</th>
                        <th>Phone Number</th>
                        <th>Order Type</th>
                        <th>Amount</th>
                        <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.orders.map(order => `
                        <tr>
                            <td>${order.id}</td>
                            <td>${order.customer_phone}</td>
                            <td>${order.order_type.toUpperCase()}</td>
                            <td>${ (order.additional_price) != 0 ? order.additional_price : order.grand_total }</td>
                            <td>
                                 <div class="dropdown quick-add-btn">
                                        <a class="btn btn-primary btn-q-add dropdown-toggle" data-bs-toggle="dropdown"
                                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <i class="ti ti-plus drp-icon"></i>
                                            <span class="ms-2 me-2">{{ ('Actions') }}</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a href="/useradmin/orderitems/view/edit/${order.id}"
                                                data-title="{{('Order Edit') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Order Edit') }}</span>
                                            </a>
                                            <a href="javascript:void(0)"
                                                data-size="md"
                                                data-url="/useradmin/order/expenses/create/${order.id}"
                                                data-ajax-popup="true"
                                                data-title="{{('Add expenses') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('Add expenses') }}</span>
                                            </a>
                                            <a href="/useradmin/order/cashflow/${order.id}"
                                                data-title="{{('View Cash Flow') }}"
                                                class="dropdown-item"
                                                data-bs-placement="top">
                                                <span>{{('View Cash Flow') }}</span>
                                            </a>
                                            ${order.order_status === 'credit order' ? `
                                                <a href="javascript:void(0)"
                                                    data-size="lg"
                                                    data-url="/useradmin/order/creditorder/${order.id}"
                                                    data-ajax-popup="true"
                                                    data-title="{{('Credit Order Payment') }}"
                                                    class="dropdown-item"
                                                    data-bs-placement="top">
                                                    <span>{{('Credit Order Payment') }}</span>
                                                </a>
                                            ` : ''}
                                              ${order.order_status === 'booking' ? `
                                                <a href="javascript:void(0)"
                                                    data-size="lg"
                                                    data-url="/useradmin/order/bookingorder/${order.id}"
                                                    data-ajax-popup="true"
                                                    data-title="{{('Booking Order Payment') }}"
                                                    class="dropdown-item"
                                                    data-bs-placement="top">
                                                    <span>{{('Booking Order Payment') }}</span>
                                                </a>
                                            ` : ''}
                                        </div>
                                    </div>
                            </td>
                        </tr>
                        `).join('')}
                    </tbody>
                    </table>
                  </div>
                    <a href="/useradmin/employee/jobamount/create/${data.event_details.id}">
                        <button class="btn btn-sm btn-info mt-2" data-title="{{ ('Add Job Amount') }}" >
                            <i class="ti ti-plus"></i> Add Job Amount
                        </button>
                    </a>
                    <a href="/useradmin/event_rent_packages/add/${data.event_details.id}">
                        <button class="btn btn-sm btn-info mt-2" data-title="{{ ('Rent Package') }}" >
                            <i class="ti ti-plus"></i> Rent Package
                        </button>
                    </a>
                    <a href="/useradmin/events/cashflow/${data.event_details.id}">
                        <button class="btn btn-sm btn-info mt-2" data-title="{{ ('View Cash Flow') }}" > Cash Flow
                        </button>
                    </a>
                    ${data.event_details.status != 'completed' ? `
                    <a href="/useradmin/order/create/${data.event_details.id}">
                        <button class="btn btn-sm btn-info mt-2" data-title="Order Create" > Order Create
                        </button>
                    </a> ` : ''}
                    <a href="/useradmin/agreements/generate/event/${data.event_details.id}">
                        <button class="btn btn-sm btn-info mt-2" data-title="{{ ('Agreement Create') }}" > Agreement Create
                        </button>
                    </a>
                    <a href="javascript:void(0)"
                      <button class="btn btn-sm btn-info mt-2"
                        data-size="md"
                        data-url="/useradmin/event/status/update/${data.event_details.id}"
                        data-ajax-popup="true"
                        data-title="{{(' Update Event Status') }}"
                        class="dropdown-item"
                        data-bs-placement="top">
                        <span>{{(' Update Event Status') }}</span>
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
