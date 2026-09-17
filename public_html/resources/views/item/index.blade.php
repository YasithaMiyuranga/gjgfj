@extends('layouts.app')
@section('page-title', __('Items'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.stockitem.view') }}">{{__('Item') }}</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Item List</h3>
                </div>
                <hr>
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between flex-row-reverse">
                        <a href="{{ route('useradmin.updatehistory.view') }}" class="btn btn-warning me-2 btn-sm">
                            <i class="ti ti-eye py-1" title="View Update History"></i> {{ __('View Update History') }}
                        </a>
                        <button class="btn btn-primary btn-sm" data-url="{{ route('useradmin.stockitem.addform') }}" data-size="md"
                            data-ajax-popup="true" data-title="{{ __('Add Item') }}">
                          <i class="ti ti-plus py-1" title="Add"></i> {{ __('Add Item') }}
                        </button>
                    </div>
                </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table descending-order">
                                <thead>
                                    <tr>
                                        <th>Item Id</th>
                                        <th>Item Name</th>
                                        <th>Total Stock</th>
                                        <th>In Stock</th>
                                        <th>Out Stock</th>
                                        <th>Rent Price</th>
                                        <th>Product Price</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Visible to Customer</th>
                                        <th>Item Type</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $stockItem)
                                        <tr>
                                            <td>{{ $stockItem->item_id }}</td>
                                            <td>{{ $stockItem->item_name }}</td>
                                            <td>{{ $stockItem->total_stock ?? 0 }}</td>
                                            <td>{{ $stockItem->in_stock ?? 0 }}</td>
                                            <td>{{ $stockItem->out_stock ?? 0 }}</td>
                                            <td>{{ $stockItem->rent_price ?? 'N/A' }}</td>
                                            <td>{{ $stockItem->product_amount ?? 'N/A' }}</td>
                                            <td>{{ $stockItem->category ?? 'None' }}</td>
                                            <td>{{ $stockItem->status ?? 'Unavailable' }}</td>
                                            <td>{{$stockItem->visible_to_customer??'No'}}</td>
                                            <td>{{ $stockItem->item_type ?? 'N/A' }}</td>
                                            @if ($stockItem->image == null)
                                                <td>No Image</td>
                                            @else
                                            <td>
                                                <img src="{{ asset($stockItem->image) }}" width='50' height='50' class="img img-responsive" />
                                            </td>
                                            @endif
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    data-url="{{ route('useradmin.stockitem.edit', $stockItem->item_id) }}"
                                                    data-size="md" data-ajax-popup="true" data-title="{{ __('Item Edit') }}">
                                                    <i class="ti ti-pencil py-1" data-bs-toggle="tooltip" title="edit"></i>
                                                </button>

                                                <form action="{{ route('useradmin.stockitem.delete', $stockItem->item_id) }}"
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
@endsection
