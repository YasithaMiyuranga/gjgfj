@extends('layouts.app')
@section('page-title', __('Rent'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.rent.missing') }}">{{__('Missing Items') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>
                    <h3>Missing Items</h3>
                </div>
                <hr>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Employee Name</th>
                                        <th>Rent Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($missingdata as $missing)
                                        <tr>
                                            <td>{{ $missing->customer_name ?? 'N/A' }}</td>
                                            <td>{{ $missing->employee_name ?? 'N/A' }}</td>
                                            <td>{{ $missing->sent_date ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('useradmin.missing.edit', $missing->rent_id) }}">
                                                    <button class="btn btn-sm btn-primary "
                                                    data-title="{{ __('View / Update') }}">
                                                    <i class="ti ti-pencil"></i>
                                                    </button>
                                                </a>
                                                <button class="btn btn-sm btn-info"
                                                    onclick="downloadpdf('{{ $missing->rent_id }}', '{{ $missing->customer_name }}', '{{ substr($missing->sent_date, 0, 10) }}')">
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
        xhr.open('GET', `/useradmin/allmissingitems/pdf/${rentId}`, true);
        xhr.responseType = 'blob';

        xhr.onload = function () {
            if (xhr.status === 200) {
                var url = window.URL.createObjectURL(xhr.response);
                var a = document.createElement('a');
                a.href = url;
                a.download = `${customerName}__${rentDate}_Missingitem_Report.pdf`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);

                // Redirect to the specified route after download
                window.location.href = "{{ route('useradmin.rent.missing') }}";
            } else {
                showCustomAlert('Failed to generate PDF.');
            }
        };

        xhr.onerror = function () {
            showCustomAlert('An error occurred during the request.');
        };

        xhr.send();
    }
</script>
@endsection



