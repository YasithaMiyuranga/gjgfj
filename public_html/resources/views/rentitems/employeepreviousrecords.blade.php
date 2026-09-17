@extends('layouts.employee')
@section('page-title', ('Rent'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('employee.emp.assign.rent') }}">{{ __('Rent Details') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3 class="mb-1">Rent Details</h3>
                    <p class="mb-0">This page allows employees with the necessary permissions to manage rental items. They can update, delete, or add new items as needed, providing full control over the rent item records.</p>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between flex-row">
                        <a href="{{ route('employee.emp.rent.create') }}" class="btn btn-primary me-2 btn-sm">
                            <i class="ti ti-plus py-1" title="Add"></i> {{ ('Sent Item') }}
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
                                    <th>Rent Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rents as $rent)
                                    <tr>
                                        <td>{{ $rent->event_name ?? 'N/A' }}</td>
                                        <td>{{ $rent->customer_name ?? 'N/A' }}</td>
                                        <td>{{ $rent->created_at ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('employee.emp.assign.rent.view', $rent->rent_id) }}">
                                                <button class="btn btn-sm" style="background-color: #a3b8fa; color: #ffffff;"
                                                    data-title="{{ __('View') }}">
                                                    <i class="ti ti-eye py-1" title="View"></i>
                                                </button>
                                            </a>
                                           <button class="btn btn-sm btn-info"
                                                   onclick="downloadpdf('{{ $rent->rent_id }}')">
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
<script>
  function downloadpdf(rent_id) {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', '/employee/generate-pdf/' + rent_id, true);
      xhr.responseType = 'blob';

      xhr.onload = function() {
          var url = window.URL.createObjectURL(xhr.response);
          var a = document.createElement('a');
          a.href = url;
          // Check if $rents is not empty before trying to access $rent
          @if(count($rents) > 0)
              a.download = '{{ $rents[0]->created_at }}_Rentitem_Report.pdf';
          @else
              a.download = 'Rentitem_Report.pdf';
          @endif
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          window.location.href = "{{ route('employee.emp.assign.rent',['emp_id' => Auth::guard('employee')->user()->emp_id])  }}";
      };

      xhr.send();
  }
</script>
@endsection
