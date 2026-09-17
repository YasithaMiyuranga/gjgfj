@extends('layouts.app')
@section('page-title', ('Event Base Salary'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.event.base.salaryview') }}">{{('Event Base Salary') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Event Base Salary</h3>
                </div>
                <hr>
                <div class="d-flex justify-content-start align-items-center gap-2 flex-column flex-md-row mt-3 px-3">
                    <div class="event-base-label">
                        <label class="form-label" for="event_id">{{ ('Event :') }}</label>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width: 230px">
                            <select class="form-control" name="event_id" id="event_id" required>
                                <option value="">Select Event</option>
                                @foreach ($events as $event)
                                    <option value="{{ $event->eid }}">{{ $event->eid }}-{{ $event->event_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2" style="align-content: flex-end;display: none;" id="downloadDiv">
                            <button id="download-btn" class="btn btn-sm btn-primary me-2">
                                <i class="fas fa-solid fa-download py-1" data-bs-toggle="tooltip" title="download"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive mt-4  ">
                        <table class="table data-table-event">
                            <thead>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Role</th>
                                <th>Base Salary</th>
                            </thead>
                            <tbody>
                               <!--Dynamic table rows will be added here-->

                            </tbody>
                        </table>
                        <!-- Total Row -->
                        <div class="total-summary mt-3 mb-3 ">
                            <div class="row ">
                                <div class="col-6 col-xl-11 text-end">
                                    <p class="font-weight-bold text-white">Total Salary:</p>
                                </div>
                                <div class="col-6 col-xl-1 text-start">
                                    <p class=" font-weight-bold text-white" id="total_salary"> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <!-- Choices.js -->
 <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

 <script>
    $(document).ready(function() {
        const eventIdChoice = new Choices('#event_id', {
            placeholder: true,
            searchEnabled: true,
        });
        // Event change listener for the event_id dropdown
        $('#event_id').on('change', function() {
            var eventId = $(this).val();

           $.ajax({
               url: '/useradmin/get-event-base-salary-data/' + eventId,
               method: 'GET',
               success: function(response) {
                  if (!response.data || response.data.length === 0) {
                      $('.data-table-event tbody').html('<tr><td colspan="4" style="text-align: center;">No data available.</td></tr>');
                      $('#total_salary').text('0.00').css('text-align', 'center');

                      // Hide the download button
                      document.getElementById('downloadDiv').style.display = 'none';
                  }else{
                        // Initialize total salary
                        var total_salary = 0;

                        // Clear the existing tbody data
                        $('.data-table-event tbody').empty();

                        // Append the new data to the tbody
                        $.each(response.data, function(index, value) {
                            var row = '<tr>' +
                                '<td>' + value.emp_id + '</td>' +
                                '<td>' + value.name + '</td>' +
                                '<td>' + value.emp_type + '</td>' +
                              '<td>' + value.total_job_amount.toFixed(2) + '</td>'
                                '</tr>';

                            total_salary += parseFloat(value.total_job_amount);
                            $('.data-table-event tbody').append(row);
                        });

                        // Update the total salary
                        $('#total_salary').text(total_salary.toFixed(2));

                        // Show the download button
                        document.getElementById('downloadDiv').style.display = 'block';
                   }

                },
                error: function(xhr, status, error) {
                    showCustomAlert('Error fetching data. Please try again.');
                    // Hide the download button
                    document.getElementById('downloadDiv').style.display = 'none';
                }
           });
        });
        // Add an event listener to the button in the script tag
        document.getElementById('download-btn').addEventListener('click', downloadpdf);
        // Function to download the PDF
        function downloadpdf() {
            var eventId = $('#event_id').val();
            var xhr = new XMLHttpRequest();
            xhr.open('GET', `/useradmin/generate/event-base-salary-pdf/${eventId}`, true);
            xhr.responseType = 'blob';

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var url = window.URL.createObjectURL(xhr.response);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = `${eventId}_Event_Base_Salary_Report.pdf`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.location.href = "{{ route('useradmin.event.base.salaryview') }}";
                } else {
                    showCustomAlert('Failed to generate PDF.');
                }
            };

            xhr.onerror = function() {
                showCustomAlert('An error occurred during the request.');
            };

            xhr.send();

        }
    });
 </script>
@endsection



