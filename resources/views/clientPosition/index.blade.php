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
                            <th>Client</th>
                            <th>Credit Limit</th>
                            <th>Used</th>
                            <th>Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientLimits as $limit)
                        @php
                            $isOverLimit = $limit->usedLimit > $limit->clientLimit;
                        @endphp
                        <tr>
                            <td>{{ $limit->client }}</td>
                            <td class="text-right">{{ number_format($limit->clientLimit, 2) }}</td>
                            <td class="text-right {{ $isOverLimit ? 'text-danger font-weight-bold' : ($limit->usedLimit > 0 ? 'text-warning' : '') }}">
                                {{ number_format($limit->usedLimit, 2) }}
                                @if($isOverLimit)
                                    <span class="badge badge-danger">OVER LIMIT</span>
                                @endif
                            </td>
                            <td class="text-right {{ $isOverLimit ? 'text-danger' : ($limit->remainingLimit < ($limit->clientLimit * 0.1) ? 'text-warning' : 'text-success') }}">
                                {{ number_format($limit->remainingLimit, 2) }}
                                @if($isOverLimit)
                                    <span class="badge badge-danger">EXCEEDED</span>
                                @elseif($limit->remainingLimit < ($limit->clientLimit * 0.1))
                                    <span class="badge badge-warning">LOW</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No client data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $clientLimits->links() }}
            </div>
        </div>
    </div>
    @endsection