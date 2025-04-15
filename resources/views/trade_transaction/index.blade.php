@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Trade History Transaction</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('trade.transactions') }}" method="GET" id="searchForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group position-relative">
                            <label for="client_name">Nama Client</label>
                            <input type="text" name="client_name" id="client_name" class="form-control" 
                                   value="{{ request('client_name') }}" required>
                            @if(request('client_name'))
                                <span class="clear-input" onclick="clearInput('client_name')">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                            @error('client_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="from_date">Dari Tanggal</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" 
                                   value="{{ request('from_date') }}" max="{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="to_date">Sampai Tanggal</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" 
                                   value="{{ request('to_date') }}" max="{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" name="search" class="btn btn-primary mr-2">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    @if($transactions->count() > 0)
        <div class="card">
            <div class="card-header">
                <h4>
                    @if(request()->has('search'))
                        Hasil Pencarian
                    @else
                        Transaksi Hari Ini
                    @endif
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Client</th>
                                <th>Settlement Date</th>
                                <th>B / S</th>
                                <th>Obligasi</th>
                                <th>Nominal</th>
                                <th>Harga</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Approved Date</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $index + $transactions->firstItem() }}</td>
                                    <td>{{ $transaction->TrxDate }}</td>
                                    <td>{{ $transaction->Client }}</td>
                                    <td>{{ $transaction->SettleDate }}</td>
                                    <td>{{ $transaction->BorS }}</td>
                                    <td>{{ $transaction->Obligasi }}</td>
                                    <td>{{ number_format($transaction->Nominal, 0, ',', '.') }}</td>
                                    <td>{{ number_format($transaction->Harga, 4, ',', '.') }}</td>
                                    <td>{{ number_format($transaction->Amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($transaction->Status == 'P')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($transaction->Status == 'M')
                                            <span class="badge bg-success text-white">Completed</span>
                                        @elseif($transaction->Status == 'R')
                                            <span class="badge bg-danger text-white">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary text-white">{{ $transaction->Status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->ApprovedBy }}</td>
                                    <td>{{ $transaction->ApprovedDate }}</td>
                                    <td>{{ $transaction->Note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $transactions->appends([
                        'client_name' => request('client_name'),
                        'from_date' => request('from_date'),
                        'to_date' => request('to_date'),
                        'search' => request('search')
                    ])->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            @if(request()->has('search'))
                Tidak ditemukan transaksi untuk kriteria pencarian ini.
            @else
                Cari transaksi untuk melihat riwayat.
            @endif
        </div>
    @endif
</div>

<style>
  .clear-input {
        position: absolute;
        right: 10px;
        top: 30px;
        cursor: pointer;
        color: #999;
    }
    .clear-input:hover {
        color: #333;
    }
    .position-relative {
        position: relative;
    }
</style>

<script>
    function clearInput(fieldId) {
        document.getElementById(fieldId).value = '';
        document.getElementById('searchForm').submit();
    }
    $(document).ready(function() {
           $('#client_name').autocomplete({
               source: function(request, response) {

                   $.ajax({
                       url: "{{ route('formclientlimit.autocomplete') }}",
                       data: {
                           query: request.term
                       },
                       success: function(data) {
                           response($.map(data, function(item) {
                               return {
                                   label: item.Client,
                                   value: item.Client,
                                   credit: item.ClientLimit
                               }
                           }))
                       }
                   })
               },
               select: function(event, ui) {
                   $('#client_name').val(ui.item.value);
               }
           })
       })
</script>
@endsection