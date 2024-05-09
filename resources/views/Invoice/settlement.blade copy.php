@extends('sidebar.sub1')

@section('title', 'Generate Receipt')

@section('pageTitle', 'Generate Receipt')
@section('content')

    @include('sweetalert::alert')
    <form action="{{ Route('receipt.settlement') }}" method="post">

    @section('thead')
        <div class="row">
            <div class="col">
                <span class="text-danger fw-bold mb-2">
                    payment = <span id="allPayment">{{ number_format($payment, 2) }}</span>
                </span>
            </div>

            <div class="col">
                <button type="submit" class="btn btn-primary float-end" id="submitBtn">Receipt</button>

            </div>
        </div>
        <th class="text-center">No</th>
        <th></th>
        <th class="text-center">Invoice Number</th>
        <th class="text-center">Price(Rs.)</th>
        <th class="text-center">Balance</th>
        <th class="text-center">Description</th>
    @endsection

    @php
        $no = 0;
    @endphp

    @section('tbody')
        @if ($invoice_data->count() > 0)
            @foreach ($invoice_data as $get)
                @php
                    $no += 1;
                @endphp
                <tr class="fw-bold t-4">
                    <td class="fw-bold text-center" style="width: 80px;">{{ $no }}</td>
                    <td style="max-width: 80px; width:80px;" class="text-center">
                        <button class="btn btn-sm btn-success clickbtn" id="{{ 'click' . $get->id }}"
                            onclick="handleClick('{{ $get->id }}')">
                            Click
                        </button>
                    </td>
                    <td class="fw-bold text-center" style="width: 80px;">{{ $get->invoiceNumber }}</td>
                    <td style="max-width: 250px; width:200px;" class="text-end" id="{{ $get->id }}">
                        @php
                            if ($get->currancy == 1) {
                                $price = $get->price * $get->dollerRate;
                            } else {
                                $price = $get->price;
                            }
                        @endphp
                        {{ number_format($price, 2) }}

                    </td>
                    <td class="fw-bold text-center" style="width: 80px;" id="{{ 'b' . $get->id }}">

                    </td>

                    <td class="fw-bold text-start">{{ $get->description }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center fw-bold">
                    No Records Found...
                </td>
            </tr>
        @endif

        <script>
            var payment = parseFloat('{{ str_replace(',', '', number_format($payment, 2)) }}');
            const submitBtn = document.getElementById('submitBtn');
            // const lastRow = document.getElementById('lastRow');
            submitBtn.disabled = true;
        </script>

        <script>
            function handleClick(id) {

                document.getElementById('lastRow').value = id;

                var allPayment = document.getElementById('allPayment');
                console.log(id);
                var price = parseFloat(document.getElementById(id).textContent.replace(/,/g, '')); // Extract numerical value
                var btnId = 'click' + id;
                var priceElement = document.getElementById(btnId);

                var balance = payment - price;
                console.log(balance + " balance");
                if (balance < 0) {
                    var debtor = balance;

                    // var balance2 = price - balance;
                    // console.log(balance2 + ' balance 2');
                    balance2 = price - payment;
                    console.log(debtor + ' debtor');
                    console.log(balance2 + ' balance2');

                    var buttons = document.getElementsByClassName('clickbtn');
                    for (var i = 0; i < buttons.length; i++) {
                        buttons[i].disabled = true;
                    }

                    submitBtn.disabled = false;

                    document.getElementById('balanceForm').value = debtor;

                } else {
                    payment = payment - price;

                    document.getElementById('balanceForm').value = payment;

                    if (priceElement) {
                        priceElement.disabled = true;
                    }
                }
            }
        </script>

        {{-- <script>
        function handleClick(id) {
            if (payment <= 0) {
                var buttons = document.getElementsByClassName('clickbtn');
                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].disabled = true;
                }
            }

            var priceText = document.getElementById(id).textContent;
            var btnId = 'click' + id;
            var priceElement = document.getElementById(btnId);

            var price = parseFloat(priceText.replace(/,/g, '')); // Remove commas from the price text and parse as float
            var balanceElementId = 'b' + id; // Construct the id of the balance element
            var balanceElement = document.getElementById(balanceElementId);

            if (!isNaN(price) && balanceElement) {
                var balance = payment - price;

                if (balance >= 0) {
                    balanceElement.textContent = 0.00;
                    balance = price - balance;

                } else {
                    balanceElement.textContent = payment - balance;

                    var buttons = document.getElementsByClassName('clickbtn');
                    for (var i = 0; i < buttons.length; i++) {
                        buttons[i].disabled = true;
                    }
                    payment = payment - price;

                    var allPayment = document.getElementById('allPayment');
                    allPayment.textContent = payment.toFixed(2);
                    if (priceElement) {
                        priceElement.disabled = true;
                    }
                }
            }
        }
    </script> --}}
        <input type="hidden" name="invoiceNumber" value="{{ $get->invoiceNumber }}">
        <input type="hidden" name="balance" id="balanceForm" value="">
        <input type="hidden" name="invoice_data" id="invoiceData" value="{{ $invoice_data }}">
        <input type="hidden" name="lastRow" id="lastRow" value="">

    </form>


@endsection

@endsection
