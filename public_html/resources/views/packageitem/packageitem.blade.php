@extends('layouts.app')

@section('page-title', __('Dashboard'))

@section('action-button')
@endsection

@section('breadcrumb')
@endsection

@section('content')
<button class="btn btn-sm btn-primary me-2"  data-url="{{ route('packageitem.add') }}"
        data-size="md" data-ajax-popup="true" data-title="{{ __('Add Product Type') }}">
        <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="Add"></i>
    </button>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">

                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>


                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('qty') }}</th>

                                    <th>{{ __('status') }}</th>
                                    <th>{{ __('image') }}</th>

                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>

                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->qty }}</td>

                                    <td>{{ $category->status }}</td>
                                    <td>
                                        <img src="{{ asset('uploads/' . $category->image) }}" width='50' height='50' class="img img-responsive" />
                                    </td>
                                    {{-- <td>
                                        <img src="{{ asset('uploads/' . $category->image) }}" width='50' height='50' class="img img-responsive" />
                                    </td> --}}

                                    <td class="text-end">

                                        <a    href="{{ route('packageitem.delete', $category->id) }}"class="btn btn-sm btn-danger me-2"
                                            onclick="return confirm('Are you sure you want to delete this record?')">
                                            <i class="fas fa-trash-alt" title="delete"></i>
                                         </a>

                                         <button class="btn btn-sm btn-primary me-2"
                                         data-url="{{ route('packageitem.edit', $category->id) }}"
                                         data-size="md" data-ajax-popup="true" data-title="{{ __('Edit Customer') }}">
                                         <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                         </button>

                                        <button class="btn btn-sm btn-secondary me-2" data-url="{{-- {{ route('admin.storepassword.reset', \Crypt::encrypt($user->id)) }} --}}"
                                            data-size="md" data-ajax-popup="true"
                                            data-title="{{ __('Reset Password') }}">
                                            <i class="ti ti-key py-1" data-bs-toggle="tooltip"
                                                title="reset password"></i>
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
@endsection
