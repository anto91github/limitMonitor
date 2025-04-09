@extends('layouts.app')

@section('title')
    Form Client Limit
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Form Client Limit</h5>
                <h6 class="card-subtitle mb-2 text-muted">Insert or update client limit</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form action="{{ route('formclientlimit.store') }}" method="POST">
                    @csrf
                    <label class="form-label" for="client">Client</label>
                    <input class="form-control" type="text" name="client" id="client" required>
                    <br>
                    <label class="form-label" for="credit">Credit Limit</label>
                    <input class="form-control" type="number" name="credit" id="credit" required>
                    <br>
                    <button class="btn btn-primary d-flex" type="submit">Apply</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#client').autocomplete({
                source: function(request, response) {
                    console.log(request);
                    $.ajax({
                        url: "{{ route('formclientlimit.autocomplete') }}",
                        data: {
                            query: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    client: item.Client,
                                    credit: item.ClientLimit
                                }
                            }))
                        }
                    })
                },
                select: function(event, ui) {
                    console.log(ui);
                    $('#client').val(ui.item.client);
                    $('$credit').val(ui.item.credit)
                }
            })

        })
    </script>
@endsection
