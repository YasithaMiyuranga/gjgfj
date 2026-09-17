@extends('layouts.app')
@section('page-title', ('Agreements'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.show_agreement_employee') }}">{{('Agreements') }}</a>
    </li>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5></h5>
                <h3>{{ ('Employee Agreement List') }}</h3>
            </div>
            <hr>
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between flex-row">
                        <a href="{{ route('useradmin.agreement.view') }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus py-1" title="Add"></i> {{ ('Create New Agreement') }}
                        </a>
                    </div>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>Agreement Id</th>
                                    <th>Employee Name</th>
                                    <th>Agreement Name</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agreements as $agreement)
                                    <tr>
                                        <td>{{ $agreement->id ?? 'N/A' }}</td>
                                        <td>{{ $agreement->employee_name ?? 'N/A' }}</td>
                                        <td>{{ $agreement->template->name ?? 'N/A' }}</td>
                                        <td>{{ $agreement->template->agreementCategory->name ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('useradmin.agreement.edit', $agreement->id) }}">
                                                <button class="btn btn-sm btn-primary" data-title="{{ ('Agreement Edit') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </button>
                                            </a>
                                             <button class="btn btn-sm btn-info"
                                                 onclick="downloadpdf('{{ $agreement->id }}, {{ $agreement->employee_name }}')">
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
    function downloadpdf( agreementId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', `/useradmin/agreements/generate/${agreementId}`, true);
        xhr.responseType = 'blob';

        xhr.onload = function() {
            if (xhr.status === 200) {
                var url = window.URL.createObjectURL(xhr.response);
                var a = document.createElement('a');
                a.href = url;
                a.download = `${agreementId}_Agreement_Report.pdf`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.location.href = "{{ route('useradmin.show_agreement_employee') }}";
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
