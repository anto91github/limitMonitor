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
                    {{-- @foreach($pepList as $data)
                    <tr>
                        <td>{{ $pepList->firstItem() + $loop->index }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->nik }}</td>
                        <td>{{ $data->jabatan }}</td>
                        <td>{{ $data->instansi }}</td>
                        <td>{{ $data-> created_at}}</td>
                        <td><a href="pepCheck/detail/{{$data->id}}" class="btn btn-info btn-sm">Detail</a></td>
                        <td>
                            <!-- <a href="pepCheck/delete/{{$data->id}}" class="btn btn-danger btn-sm">Delete</a> -->
                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $data->id }}">Delete</a>

                        </td>

                    </tr>
                    @endforeach --}}
            </table>
            <div class='my-3 float-end'>
                {{-- {{$pepList->withQueryString()->links()}} --}}
            </div>
        </div>
    </div>
</div>


@endsection