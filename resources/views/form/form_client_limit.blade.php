@extends('layouts.app')

@section('title')
    Form Client Limit
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Form Client Limit</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    {{ isset($isEdit) && $isEdit ? 'Update' : 'Insert' }} client limit
                </h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form action="{{ route('formclientlimit.store') }}" method="POST">
                    @csrf
                    @if(isset($isEdit) && $isEdit)
                        <input type="hidden" name="is_edit" value="1">
                    @endif
                    
                    <label class="form-label" for="client">Client</label>
                    <input class="form-control" type="text" name="client" id="client" 
                           value="{{ $clientData->Client ?? '' }}" 
                           {{ isset($isEdit) && $isEdit ? 'readonly' : 'required' }}>
                    <br>
                    <label class="form-label" for="credit">Credit Limit</label>
                    <input class="form-control" type="text" name="credit" id="credit" 
                           value="{{ isset($clientData) ? number_format($clientData->ClientLimit, 0, ',', '.') : '' }}" 
                           oninput="thousandSeparator(this)" required>
                    <br>
                    <button class="btn btn-primary d-flex" type="submit">
                        {{ isset($isEdit) && $isEdit ? 'Update' : 'Apply' }}
                    </button>
                </form>
            </div>
            <br>
        </div>
    </div>
    <script>

        function thousandSeparator(input) {
            value = input.value.replace(/[^\d\.]/g, '');
            value = parseInt(value).toLocaleString('en');
            input.value = value;
        }

        $(document).ready(function() {
            $('#client').autocomplete({
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
                    $('#client').val(ui.item.value);
                    $('#credit').val(parseInt(ui.item.credit).toLocaleString('en'))
                }
            })
        })
    </script>
@endsection
