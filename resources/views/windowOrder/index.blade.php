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

                <form action="{{ route('window.index') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="pencarian" id="searchInput"
                                    placeholder="Keyword" value="{{ request()->input('pencarian') }}">
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
                                <th scope="col">Trx Date</th>
                                <th scope="col">Settle Date</th>
                                <th scope="col" width="5%">B / S</th>
                                <th scope="col">Client</th>
                                <th scope="col">Obligasi</th>
                                <th scope="col">Nominal</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Approved By</th>
                                <th scope="col">Approved Date</th>
                                <th scope="col">Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $data->firstItem() + $loop->index }}</td>
                                    <td>{{ $d->TrxDate }}</td>
                                    <td>{{ $d->SettleDate }}</td>
                                    <td>{{ $d->BorS }}</td>
                                    <td>{{ $d->Client }}</td>
                                    <td>{{ $d->Obligasi }}</td>
                                    <td>{{ number_format($d->Nominal, 0, ',', '.') }}</td>
                                    <td>{{ number_format($d->Harga, 4, ',', '.') }}</td>
                                    <td>{{ number_format($d->Amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($d->Status == 'P')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($d->Status == 'M')
                                            <span class="badge bg-success text-white">Completed</span>
                                        @elseif($d->Status == 'R')
                                            <span class="badge bg-danger text-white">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary text-white">{{ $d->Status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $d->ApprovedBy }}</td>
                                    <td>{{ $d->ApprovedDate }}</td>
                                    <td>{{ $d->Note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class='my-3 float-end'>
                        {{ $data->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
         $(document).ready(function() {
            $('#searchInput').autocomplete({
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
                    $('#searchInput').val(ui.item.value);
                }
            })
        })
    </script>
@endsection
