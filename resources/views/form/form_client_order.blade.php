@extends('layouts.app')

@section('title')
    Form Client Order
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Form Client Order</h5>
                
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form action="{{ route('formclientorder.store') }}" method="POST">
                    @csrf
                    <label class="form-label" for="client">Buy Or Sell</label>
                    <select class="form-control" name="bors" id="bors" required>
                        <option value="">Pilih salah satu</option>
                        <option value="B">Buy</option>
                        <option value="S">Sell</option>
                    </select>
                    <br>
                    <label class="form-label" for="client">Client</label>
                    <input class="form-control" type="text" name="client" id="client" required>
                    <br>
                    <label class="form-label" for="obligasi">Obligasi</label>
                    <input class="form-control" type="text" name="obligasi" id="obligasi" required>
                    <br>
                    <label class="form-label" for="nominal">Nominal</label>
                    <input class="form-control" type="text" name="nominal" id="nominal"
                        oninput="thousandSeparator(this)" required>
                    <br>
                    <label class="form-label" for="harga">Harga</label> &nbsp; <small>(in percentage (%), separator using
                        period (.))</small>
                    <input class="form-control" type="text" name="harga" id="harga" oninput="harga_filt(this)"
                        required>
                    <br>
                    <label class="form-label" for="amount">Amount</label>
                    <input class="form-control" type="text" name="amount" id="amount" required readonly>
                    <br>
                    <label class="form-label" for="sett">Settle Date</label>
                    <div class="row">
                        <div class="col-4">
                            <select class="form-control" name="sett" id="sett" required>
                                <option value="">Pilih salah satu</option>
                                <option value="1">T+1</option>
                                <option value="2">T+2</option>
                            </select>
                        </div>
                        <div class="col-8">
                            <input class="form-control" type="text" name="sett_date" id="sett_date" required readonly>
                        </div>

                    </div>


                    <br>
                    <button class="btn btn-primary d-flex" type="submit">Apply</button>
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

            calculate_amount()
        }

        function harga_filt(input) {
            value = input.value.replace(/[^0-9.]/g, '');
            input.value = value;

            calculate_amount()
        }

        function calculate_amount() {
            nominal = parseInt(document.getElementById('nominal').value.replace(/[^\d\.]/g, ''));
            harga_cal = parseFloat(document.getElementById('harga').value);

            amount = nominal * (harga_cal / 100);

            document.getElementById('amount').value = parseInt(amount).toLocaleString('en');
        }


        $(document).ready(function() {
            $('#sett').on('change', function() {
                var selected = $(this).val();

                $.ajax({
                    url: "{{ route('formclientorder.getsett') }}",
                    type: 'GET',
                    data: {
                        query: selected
                    },
                    success: function(data) {
                        $('#sett_date').val(data)
                    }
                })
            })
        })


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
                }
            })
        })
    </script>
@endsection
