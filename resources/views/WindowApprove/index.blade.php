@extends('layouts.app')

@section('title')
Window Approval
@endsection

@section('content')


<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Window Approval</h5>
            <h6 class="card-subtitle mb-2 text-muted"> List</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <form action="{{ route('window-approve.index') }}" method="GET">
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
                        <th scope="col" width="15%" colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>
                        <td>{{ $data->firstItem() + $loop->index }}</td>
                        <td>{{ $d->TrxDate }}</td>
                        <td>{{ $d->SettleDate }}</td>
                        <td>{{ $d->BorS }}</td>
                        <td>{{ $d->Client }}</td>
                        <td>{{ $d->Obligasi}}</td>
                        <td>{{ $d->Nominal}}</td>
                        <td>{{ $d->Harga}}</td>
                        <td>{{ $d->Amount}}</td>
                        <td>
                            @if($d->Status == 'P')
                                Pending
                            @elseif($d->Status == 'M')
                                Approve
                            @else
                                Reject
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeStatusModal" data-id="{{ $d->Id }}">
                                Update Status
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="changeStatusModal{{ $d->id }}" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="changeStatusModalLabel">Update Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="inputForm" action="window-approve/update/{{ $d->Id }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            {{-- <input type="text" name="orderId" id="orderId"> --}}
                                            <div class="form-group">
                                                <label for="status">Status :</label>
                                                <select name="newStatus" id="newStatus" class="form-select">
                                                    <option value="M">Approve</option>
                                                    <option value="R">Reject</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="approveNote">Note :</label>
                                                
                                                <textarea class="form-control" id="approveNote" rows="4" name="approveNote"></textarea>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            
                                        </form>
                                    </div>
                                    
                                </div>
                                </div>
                            </div>

                            

                        </td>

                    </tr>
                    @endforeach
            </table>
            <div class='my-3 float-end'>
                {{$data->withQueryString()->links()}}
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