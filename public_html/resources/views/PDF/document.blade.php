@extends('layouts.app')
{{-- @section('page-title', __('Rent Item Report')) --}}
@section('content')
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form id="sendForm">
                        @csrf
                        <div class="card-header">
                            <h2>Rent Item Report</h2>
                        </div>
                        <div class="card-body">
                            @if ($downloadable == true)
                                <div class="row">
                                    <div class="col-md-3" style="align-content: flex-end">
                                        <button type="submit" class="btn btn-primary">Download PDF</button>
                                    </div>
                                </div>
                            @endif
                            <br>
                            <br>
                            <div>
                                <div class="col-md-12">
                                    <h3>{{ Str::title(str_replace('-', ' ', config('app.name')))}}</h3>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Employee Name: </b>{{ $rent->employee_name }}
                                </div>
                                <div class="col-md-4">
                                    <b>Customer Name : </b>{{ $rent->customer_name }}
                                </div>
                                <div class="col-md-4">
                                    <b>Issued At : </b>{{ $rent->created_at }}
                                </div>
                            </div>
                            <hr>
                            <table class="table dataTable mt-2">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Supplier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rentitems as $rentitem)
                                        <tr>
                                            <td>{{ $rentitem->item_name }}</td>
                                            <td>{{ $rentitem->quantity }}</td>
                                            <td>
                                                @if ($rentitem->suppliers->count() > 0)
                                                    @foreach ($rentitem->suppliers as $supplier)
                                                        {{ $supplier->supplier_name }} - ({{ $supplier->rent_quantity }}) <br>
                                                    @endforeach
                                                @else
                                                     -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function downloadpdf() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/useradmin/generate-pdf/{{ $rent->rent_id }}', true);
            xhr.responseType = 'blob';

            xhr.onload = function() {
                var url = window.URL.createObjectURL(xhr.response);
                var a = document.createElement('a');
                a.href = url;
                a.download = '{{ $rent->customer_name }}__{{ $rent->created_at }}_Rentitem_Report.pdf';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.location.href = "{{ route('useradmin.send.form') }}";
            };

            xhr.send();
        }

        document.getElementById('sendForm').addEventListener('submit', function(e) {
            e.preventDefault();
            downloadpdf();
        });
    </script>
@endsection
