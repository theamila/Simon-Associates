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
        Invoice
    </h2>
    Invoice No = {{ $invoiceNumber }} <br>
    Invoice Date = {{ date('jS F Y', strtotime($date)) }} <br> <br>


    <div class="row">
        Invoice To = {!! $company_data->to !!} <br>{!! $company_data->companyName . ',' !!} <br>
        {!! str_replace(',', ',<br>', $company_data->address) !!}<br>
        {{ $company_data->email }}
    </div>
    @php

        $no = 0;
    @endphp
    <br>
    <div class="table-body">
        <table class="">
            <thead>
                <tr>
                    <th class="text-center" style="width: 70px;">
                        No
                    </th>
                    <th class="text-center">
                        Description
                    </th>
                    <th class="text-center" style="width: 180px;">
                        {{ $dollarRate == 1.0 ? 'Rs.' : '$USD' }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $no += 0;
                @endphp
                @if ($invoice_data->count() > 0)
                    @foreach ($invoice_data as $get)
                        @if ($get->Reimbursables == '0')
                            <tr>
                                @php
                                    $total += $get->price / $dollarRate;
                                    $no += 1;
                                @endphp
                                <td class="text-center">
                                    {{ $no }}
                                </td>
                                <td class="text-wrap text-break">
                                    {{ $get->description }}
                                </td>
                                <td class="text-end">
                                    {{ number_format(($get->price / $dollarRate), 2) }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif

                <tr>
                    <td colspan="2" class='fw-bold text-center'>
                        Total
                    </td>
                    <td class="fw-bold text-end">
                        {{ number_format($total, 2) }}
                    </td>
                </tr>

                <tr>
                    <td class="fw-bold text-start" colspan="3">Reimbursable Expenses</th>
                </tr>


                @if ($invoice_data->count() > 0)
                    @foreach ($invoice_data as $get)
                        @if ($get->Reimbursables == '1')
                            <tr>
                                @php

                                    $total += $get->price / $dollarRate;
                                    $no += 1;
                                @endphp
                                <td class="text-center">{{ $no }}</td>
                                <td class="text-wrap text-break">
                                    {{ $get->description }}
                                </td>
                                <td class="text-end">
                                    {{ number_format($get->price / $dollarRate, 2) }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif


            </tbody>
        </table>
    </div>

    <div class="col-3 price-box">
        <div class="row total-row">
            <div class="text text-center fw-bold">
                {{ number_format($total, 2) }} <br>
                <span class="text-purple t-value">
                    Total Value
                </span>
            </div>
        </div>
    </div>

    <div class="bank-row">
        <div class="bank-details">
            <div class="bank-box">
                <div class="box-1">
                    <div class="text-purple line">A/C Name : {{ $bank->acName }}</div>
                    <div class="text-purple line">Account : {{ $bank->accountNo }}No</div>
                    <div class="text-purple line">Bank Name: {{ $bank->bankName }}</div>
                    <div class="text-purple line">Bank Address: {{ $bank->bankAddress }}</div>
                    <div class="text-purple line">Swift Code: {{ $bank->swiftCode }}</div>
                </div>


            </div>
        </div>
</body>

</html>
