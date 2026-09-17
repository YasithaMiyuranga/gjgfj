@extends('layouts.app')
@section('page-title', __('Cash Flows'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.cashflow.view') }}">{{__('Cash Flow View') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Cash Flow View</h3>
                </div>
                <hr>
                    <div class="card-body table-border-style">
                        <div class="d-flex">
                            <div>
                                <button class="btn btn-sm btn-primary me-2 mb-2" data-url="{{ route('useradmin.cashflow.search') }}"
                                data-size="md" data-ajax-popup="true" data-title="{{ __('Search Cash Flow') }}">
                                <i class="fas fa-solid fa-filter py-1" data-bs-toggle="tooltip" title="serch cash flow"></i>
                                </button>
                                <a href="{{ route('useradmin.cashflow.view') }}" class="btn btn-sm btn-primary me-2 mb-2">
                                    <span class="dash-mtext">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                        d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                        <path
                                        d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                        </svg>
                                    </span>
                                </a>
                                @if(isset($startDate) || isset($endDate) || isset($amount) || isset($withDeleted))
                                    <button id="download-btn" class="btn btn-sm btn-primary me-2 mb-2">
                                        <i class="fas fa-solid fa-download py-1" data-bs-toggle="tooltip" title="serch cash flow"></i>
                                    </button>
                                @endif
                            </div>
                            <div class="ms-auto">
                                <p>
                                    <span class="fw-bold">Start Date:</span> {{ isset($startDate) && $startDate ? $startDate : 'All' }} -
                                    <span class="fw-bold">End Date:</span> {{ isset($endDate) && $endDate ? $endDate : 'All' }} <span class="text-primary">|</span>
                                    <span class="fw-bold">Amount:</span> {{ isset($amount) && $amount ? $amount : 'All' }} <span class="text-primary">|</span>
                                    <span class="fw-bold">With Deleted:</span> {{ isset($withDeleted) && $withDeleted ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        <div class="table-responsive mt-4 cash-flows-table ">
                            <table class="table data-table-cash-flow">
                                <thead>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th class="text-end">Income</th>
                                    <th class="text-end">Expence</th>

                                </thead>
                                <tbody>
                                    @foreach ($cashFlows as $row)
                                        <tr>
                                            <td>{{ $row->date }}</td>
                                            <td>
                                                @if ($row->deleted_at == null)
                                                    <p>{{ $row->name }}</p>
                                                @else
                                                    <p class="text-danger">{{ $row->name }} <span class="badge bg-danger text-white">Deleted</span></p>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if ($row->is_income == 1)
                                                    {{ $row->amount }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if ($row->is_expense == 1)
                                                    {{ $row->amount }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Total Row -->
                            <div class="total-summary">
                                <div class="row mt-3">
                                    <div class="col-6 col-xl-11 text-end">
                                        <p class="font-weight-bold text-white">Total Income:</p>
                                    </div>
                                    <div class="col-6 col-xl-1 text-start">
                                        <p class=" font-weight-bold text-white"> {{ $totalIncome }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-xl-11 text-end">
                                        <p class="font-weight-bold text-white">Total Expense: </p>
                                    </div>

                                    <div class="col-6 col-xl-1 text-start">
                                        <p class="font-weight-bold text-white"> {{ $totalExpense }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Pagination links -->
                            <div class="cash-flow-pagination">
                                {{ $cashFlows->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Enter Password <span class="text-danger">*</span> </h5>
                <button type="button" class="btn-close closePasswordModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="password" id="downloadPassword" class="form-control" placeholder="Enter password" required>
                    <span class="text-danger" id="passwordError" class="invalid-feedback"></span>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary closePasswordModal" data-bs-dismiss="modal" >Close</button>
                <button type="button" id="confirmPassword" class="btn btn-primary">Download</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        /**
         * When the user clicks on the download button, show the password modal
         * and hide the download button
        **/
        $('#download-btn').on('click', function() {
            $('#passwordModal').modal('show');
        });

        /**
         * When the user clicks on the close button in the password modal, empty the password input field
         * and hide the password modal
        **/
        $('.closePasswordModal').on('click', function() {
            $('#downloadPassword').val('');
            $('#passwordError').text('');
        })

        /**
         * When the user clicks on the download button in the password modal, send an AJAX request to download the file
         * and show an error message if the password is incorrect
         * @data
         *      {string} password - The password entered by the user
         *      {string} startDate - The start date of the period
         *      {string} endDate - The end date of the period
         *      {string} amount - The amount of the period
         *      {boolean} withDeleted - Whether to include deleted records
         *  @headers
         *      {string} X-CSRF-TOKEN - The CSRF token
         *
        **/
        $('#confirmPassword').on('click', function() {

            // Set the password variable
            var password = $('#downloadPassword').val();

            if (password === null || password === "") {
                // If the password input field is empty, show an error message
                $('#passwordError').text('Password is required to download the file.');
                return;
            }

            // Set the values for startDate, endDate, amount, and withDeleted
            var startDate = "{{ isset($startDate) ? $startDate : 'All' }}";
            var endDate = "{{ isset($endDate) ? $endDate : 'All' }}";
            var amount = "{{ isset ($amount) ? $amount : 0 }}";
            var withDeleted = "{{ isset($withDeleted) && ($withDeleted == 'yes') ? true : false }}";

            // Send an AJAX request to download the file
            $.ajax({
                url: "{{ route('useradmin.cashflow.download') }}",
                method: "POST",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    amount: amount,
                    withDeleted: withDeleted,
                    password: password
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    if (response.success) {
                        // Empty the password input field, clear the error message and hide the modal
                        $('#downloadPassword').val('');
                        $('#passwordError').text('');
                        $('#passwordModal').modal('hide');

                        // Trigger the file download
                        window.open(response.url, '_blank');

                    } else {
                        // Empty the password input field and show the error message
                        $('#downloadPassword').val('');
                        $('#passwordError').text(response.responseJSON.message);
                    }

                },
                error: function(response) {
                    // Empty the password input field and show the error message
                    $('#downloadPassword').val('');
                    $('#passwordError').text(response.responseJSON.message);
                }

            });
        });

    </script>
@endsection
