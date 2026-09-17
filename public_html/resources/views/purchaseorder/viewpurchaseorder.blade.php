@extends('layouts.app')
@section('page-title', __('Purchase Orders'))
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.purchaseorder.view') }}">{{__('Purchase Orders') }}</a>
        <li class="breadcrumb-item active">{{ __('View Purchase Orders') }}</li>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>
                    <h3>View Purchase Order</h3>
                </div>
                <hr>
                <div class="card-body table-border-style">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purchase_id">Purchase Order ID :</label>
                                <input type="text" class="form-control" id="purchase_id"
                                    name="purchase_id" value="{{$purchaseorder->id}}" readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purchase_date">Purchase Date:</label>
                                <input type="text" class="form-control" id="purchase_date"
                                    name="purchase_date" value="{{$purchaseorder->purchase_date}}" readonly disabled>
                            </div>
                        </div>
                    </div>
                    <div>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier_name">Supplier Name :</label>
                                <input type="text" class="form-control" id="supplier_name"
                                    name="supplier_name" value="{{$purchaseorder->supplierName}}" readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="invoice_number">Invoice Number :</label>
                                <input type="text" class="form-control" id="invoice_number"
                                    name="invoice_number" value="{{$purchaseorder->invoice_number}}" readonly disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pay_type">Pay Type :</label>
                                <input type="text" class="form-control" id="pay_type"
                                    name="pay_type" value="{{$purchaseorder->pay_type}}" readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pay_amount">Pay Amount :</label>
                                <input type="text" class="form-control" id="pay_amount"
                                    name="pay_amount" value="LKR.  {{$purchaseorder->payment_amount}}" readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="balance">Balance :</label>
                                <input type="text" class="form-control" id="balance"
                                    name="balance" value="LKR.  {{$purchaseorder->balance}}" readonly disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_price">Total Price :</label>
                                <input type="text" class="form-control" id="total_price"
                                    name="total_price" value="LKR. {{$purchaseorder->total_price}}" readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_percentage">Discount Percentage (%) :</label>
                                <input type="text" class="form-control" id="discount_percentage"
                                    name="discount_percentage" value=" {{$purchaseorder->discount_percentage}} %" readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_amount">Discount Amount :</label>
                                <input type="text" class="form-control" id="discount_amount"
                                    name="discount_amount" value="LKR. {{$purchaseorder->discount_amount}} " readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="grand_total">Grand Total (With Credit Balance) :</label>
                                <input type="text" class="form-control" id="grand_total"
                                    name="grand_total" value="LKR. {{$purchaseorder->grand_total}} " readonly disabled>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-2">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Purchased Quantity</th>
                                    <th>Purchased Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($purchaseorder_items) == 0)
                                    <tr>
                                        <td colspan="10" class="text-center">No Purchase Order Items Found</td>
                                    </tr>
                                @endif
                                @foreach ($purchaseorder_items as $purchasitem)
                                    <tr>
                                        <td>{{ $purchasitem->itemName ?? 'N/A' }}</td>
                                        <td>{{ $purchasitem->quantity ?? 0 }}</td>
                                        <td>{{ $purchasitem->purchased_price ?? 0.00 }}</td>
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
