@extends('layouts.app')

@section('title')
Window Order
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Window Order</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage Client Orders</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="mb-2 text-end">
                <a href="#" class="btn btn-primary btn-sm">Add New Order</a>
            </div>

            <form action="#" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="pencarian" id="searchInput" placeholder="Keyword" value="{{ request()->input('pencarian') }}">
                            <button class="input-group-text btn btn-primary">Search</button>
                        </div>
                    </div>

                    <!-- <div class="col-md-3">
                        <div class="input-group mb-3">
                            <label for="datepicker">Date:</label>
                            <input type="text" class="form-control" id="daterange" placeholder="Pilih rentang tanggal">
                        </div>
                    </div> -->
                </div>                
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" width="3%">No</th>
                            <th scope="col" >Trx Date</th>
                            <th scope="col" >Settle Date</th>
                            <th scope="col" width="5%">B / S</th>
                            <th scope="col" >Client</th>                        
                            <th scope="col" >Obligasi</th>
                            <th scope="col" >Nominal</th>
                            <th scope="col" >Harga</th>
                            <th scope="col" >Amount</th>
                            <th scope="col" >Status</th>
                            <th scope="col" width="10%" colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($windowOrders as $order)
                        <tr>
                            <td>{{ $order->Id }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->TrxDate)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->SettleDate)->format('d/m/Y') }}</td>
                            <td>{{ $order->BorS }}</td>
                            <td>{{ $order->Client }}</td>
                            <td>{{ $order->Obligasi }}</td>
                            <td class="text-end">{{ number_format($order->Nominal, 0) }}</td>
                            <td class="text-end">{{ number_format($order->Harga, 2) }}</td>
                            <td class="text-end">{{ number_format($order->Amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->Status == 'Approved' ? 'success' : ($order->Status == 'Pending' ? 'warning' : 'danger') }}">
                                    {{ $order->Status }}
                                </span>
                            </td>
                            <td>{{ $order->ApprovedBy }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="#" class="btn btn-info btn-sm" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="#" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection