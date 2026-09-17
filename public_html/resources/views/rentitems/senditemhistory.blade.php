@extends('layouts.app')
@section('page-title', ('Rent'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.rent.view') }}">{{('Receive Items') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>Send History</h3>
            </div>
            <hr>
                <div class="card-header pb-0 " style="display: flex">
                    <div class="d-flex justify-content-between flex-row">
                        <a href="{{ route('useradmin.send.form') }}" class="btn btn-primary me-2 btn-sm">
                            <i class="ti ti-plus py-1" title="Add"></i> {{ ('Send Item') }}
                        </a>
                    </div>
                    <div class="d-flex justify-content-between flex-row-reverse">
                        <a href="{{ route('useradmin.rent.update.view') }}" class="btn btn-warning me-2 btn-sm">
                            <i class="ti ti-eye py-1" title="View Update History"></i> {{ ('View Update History') }}
                        </a>
                    </div>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Customer Name</th>
                                    <th>Employee Name</th>
                                    <th>Rent Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rentdata as $rent)
                                    <tr>
                                        <td>{{ $rent->event_name ?? 'N/A' }}</td>
                                        <td>{{ $rent->customer_name ?? 'N/A' }}</td>
                                        <td>{{ $rent->employee_name ?? 'N/A' }}</td>
                                        <td>{{ $rent->rent_status ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('useradmin.send.edit', $rent->rent_id) }}">
                                                <button class="btn btn-sm btn-primary " data-title="{{ ('Item Receive') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </button>
                                            </a>
                                            <button class="btn btn-sm btn-info"
                                                onclick="downloadpdf('{{ $rent->rent_id }}', '{{ $rent->customer_name }}', '{{ substr($rent->created_at, 0, 10) }}')">
                                                <i class="ti ti-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function downloadpdf(rentId, customerName, rentDate) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', `/useradmin/generate-pdf/${rentId}`, true);
        xhr.responseType = 'blob';

        xhr.onload = function() {
            if (xhr.status === 200) {
                var url = window.URL.createObjectURL(xhr.response);
                var a = document.createElement('a');
                a.href = url;
                a.download = `${customerName}${rentDate}_Rentitem_Report.pdf`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.location.href = "{{ route('useradmin.send.history') }}";
            } else {
                showCustomAlert('Failed to generate PDF.');
            }
        };

        xhr.onerror = function() {
            showCustomAlert('An error occurred during the request.');
        };

        xhr.send();
    }
</script>
@endsection
