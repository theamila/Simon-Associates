<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
    * {
        font-family: "Poppins", sans-serif;
    }

    table {
        width: 100%;

    }

    thead {
        background: rgb(56, 55, 55);
        color: #fff;
    }

    thead tr th {
        padding: 10px;
    }

    tbody tr td {
        padding: 10px;
    }

    .balance {
    display: flex;
    flex-direction: column;
}

.row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px; /* Adjust as needed */
}

.text {
    width: 100px; /* Adjust as needed */
    padding: 5px;
}

.price {
    width: 150px; /* Adjust as needed */
    padding: 5px;
}

    .text-end {
    text-align: end;
}
    .text-center {
    text-align: center;
}
.text-left {
    text-align: left;
}
.text-right {
    text-align: right;
}
    </style>

    <title>Receipt</title>
</head>

<body>
    <h2>
        RECEIPT
    </h2>
    Date - {{ now()->format('d/m/Y') }}
    <br>
    Receipt No - {{ 'R ' . substr($formattedNumber, 1) }}

    <br>
    Bill To - {{ $Invoice->to }}, {{ $Invoice->companyName }}

    <br>
    <br>

    <div class="table">
        <table>
            <thead>
                <tr>
                    <th style="width: 150px;">
                        Invoice No
                    </th>
                    <th style="">Description</th>
                    <th style="width: 110px;">Method</th>
                    <th style="width: 180px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total = 0;
                @endphp

                @if($invoice_data->count() > 0)
                @foreach($invoice_data as $get)
                @if($get->Reimbursables == "0")

                <tr>
                    <td class="text-center">
                        {{ $get->invoiceNumber }}
                    </td>

                    <td class="text-start">
                        {{ $get->description }}
                    </td>

                    <td class="text-center">
                        {{ ($method == "online Transfer" ? 'TRF' : ($method == "Cheque" ? 'Chq' : $method)) }}
                    </td>

                    <td class="text-end" style="text-align: end;">
                        @if($get->currancy == 1)
                        @php
                        $convertedPrice = $get->price * $get->dollerRate;
                        $total += $convertedPrice;
                        @endphp
                        {{ number_format($convertedPrice, 2) }}
                        @else
                        @php
                        $total += $get->price;
                        @endphp
                        {{ number_format($get->price, 2) }}
                        @endif
                    </td>
                </tr>

                @endif
                @endforeach
                @endif

                @if($invoice_data->count() > 0)
                @foreach($invoice_data as $get)
                @if($get->Reimbursables == "1")

                <tr>
                    <td class="text-center">
                        {{ $get->invoiceNumber }}
                    </td>

                    <td class="text-start">
                        {{ $get->description }}
                    </td>

                    <td class="text-center">
                        {{ ($method == "online Transfer" ? 'TRF' : ($method == "Cheque" ? 'Chq' : $method)) }}
                    </td>



                    <td class="text-end" style="text-align: end;">
                        @if($get->currancy == 1)

                        @php
                        $convertedPrice = $get->price * $get->dollerRate;
                        $total += $convertedPrice;
                        @endphp
                        {{ number_format($convertedPrice, 2) }}
                        @else
                        @php
                        $total += $get->price;
                        @endphp
                        {{ number_format($get->price, 2) }}
                        @endif
                    </td>
                </tr>

                @endif
                @endforeach
                <tr>
                    <td colspan="3" class="text-center">Total</td>
                    <td class="text-end" style="text-align: end;">{{ number_format($total, 2) }}</td>
                </tr>

                @endif
            </tbody>
        </table>
    </div>

    <div class="in-words">
        <p> Rupees ten million, four hundred thirty-three thousand, six hundred forty-seven and zero cents only</p>
    </div>
    <div class="balance">
    <div class="row">
        <div class="text">Total</div>
        <div class="price">{{ number_format($total, 2) }}</div>
    </div>
    <div class="row">
        <div class="text">Payment</div>
        <div class="price">{{ number_format($payment, 2) }}</div>
    </div>
    <div class="row">
        <div class="text">Balance</div>
        <div class="price">
            @php
            $balance = ($payment - $total);
            @endphp
            {{ number_format($balance, 2) }}
        </div>
    </div>
</div>



</body>

</html>
