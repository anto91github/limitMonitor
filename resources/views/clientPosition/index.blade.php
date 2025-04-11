@extends('layouts.app')

@section('title')
Client Position
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Client Position</h5>
            <h6 class="card-subtitle mb-2 text-muted">Track Limit Client</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <form action="{{ route('client-position.index') }}" method="GET">
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
                            <th>Client</th>
                            <th>Credit Limit</th>
                            <th>Used Limit</th>
                            <th>Available Limit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientLimits as $limit)
                        <tr>
                            <td>{{ $limit['nama_client'] }}</td>
                            <td>{{ number_format($limit['credit_limit'], 2) }}</td>
                            <td>{{ number_format($limit['used_limit'], 2) }}</td>
                            <td>{{ number_format($limit['available_limit'], 2) }}</td>
                            <td class="{{ $limit['status'] == 'Limit Exceeded' ? 'text-danger' : '' }}">
                                {{ $limit['status'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $clientLimits->links() }}
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