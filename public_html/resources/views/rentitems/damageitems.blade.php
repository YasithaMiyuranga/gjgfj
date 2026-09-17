@extends('layouts.app')
@section('page-title', ('Rent'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.rent.damage') }}">{{__('Damage Items') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Damage Items</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table descending-order">
                            <thead>
                                <tr>
                                    <th>Rent Id</th>
                                    <th>Item Name</th>
                                    <th>quantity</th>
                                    <th>Status</th>
                                    <th>Damage Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($damageItems as $damageItem)
                                    <tr>
                                        <td>{{ $damageItem->rent_id }}</td>
                                        <td>{{ $damageItem->item_name }}</td>
                                        <td> {{ $damageItem->quantity }}</td>
                                        <td>{{ $damageItem->status }}</td>
                                        <td>{{ $damageItem->damage }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary "
                                                data-url="{{ route('useradmin.rent.damage.view', $damageItem->id) }}"
                                                data-size="md" data-ajax-popup="true" data-title="{{ __('Damage Item View') }}">
                                                <i class="ti ti-pencil"></i>
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
