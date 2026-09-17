@extends('layouts.app')
@section('page-title', __('Equipment Wastage Management'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.equipment.wastage') }}">{{__('Equipment Wastage Management') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Wastage List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <button class="btn btn-sm btn-primary me-2"
                        data-url="{{ route('useradmin.equipment.wastage.create') }}"
                        data-size="md" data-ajax-popup="true"
                        data-title="{{ __('Add Wastage') }}">
                        <i class="ti ti-plus py-1" title="Add Wastage"></i> {{ __('Add Wastage') }}
                    </button>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Equipment</th>
                                        <th>Quantity</th>
                                        <th>Reason</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wastages as $wastage)
                                            <tr>
                                                <td>{{ $wastage->item->item_name }}</td>
                                                <td>{{ $wastage->quantity }}</td>
                                                <td class="text-wrap">{{ $wastage->reason }}</td>
                                                <td>{{ $wastage->wasted_on }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary"
                                                        data-url="{{ route('useradmin.equipment.wastage.edit', $wastage->id) }}"
                                                        data-size="md" data-ajax-popup="true"
                                                        data-title="{{ __('Edit Wastage') }}">
                                                        <i class="ti ti-pencil py-1" title="Edit Wastage"></i>
                                                    </button>
                                                    <form action="{{ route('useradmin.equipment.wastage.delete', $wastage->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-danger show_confirm">
                                                            <i class="fas fa-trash-alt" data-bs-toggle="tooltip" title="delete"></i>
                                                        </button>
                                                    </form>
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
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endsection
