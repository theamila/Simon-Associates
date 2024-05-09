<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('sidebar/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sidebar/css/invoice.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="{{ asset('assets/js/html2pdf.bundle.min.js') }}"></script>

    <style>
        @page {
            size: A4;
            margin: 0;
            padding: 0;
        }

        .CompanyName {
            color: #7952b3;
        }

        i {
            margin-right: 10px;
        }

        @media print {
            body {
                size: A4;
                margin: 0;
                padding: 0;
            }

            .btn {
                display: none;
            }


            @page {
                size: A4;
                margin: 0;
                padding: 0;
            }
        }

        .bg-purple {
            background-color: #733cd9;
        }
    </style>

</head>

<body>

    <div class="container mt-3 mb-3">

        <a href="{{ Route('Approved-invoice') }}" class="btn btn-danger"><i class="fa-solid fa-angle-left"></i>Back</a>
        <button id="printPdfBtn" class="btn btn-primary"><i class="fa-solid fa-print"></i>Print</button>
        <button id="downloadPdfBtn" class="btn btn-success"><i class="fa-solid fa-download"></i>Download Again</button>

    </div>
    <div class="container main">
        <div class="header">
            <div class="row">
                <span class="text-purple fw-bold fs-2 invoice">
                    Invoice
                </span>
            </div>
            <div class="row">
                <div class="header-box">
                    <div class="box-1">
                        <div class="text-purple line">Invoice No</div>
                        <div class="text-purple line">Invoice Date</div>
                    </div>
                    <div class="box-2">
                        <div class="line">{{ $invoiceNumber }}</div>
                        <div class="line">{{ date('jS F Y', strtotime($date)) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="address mb-3">
            <div class="row mt-2">
                <div class="col address-col">
                    <div class="topic text-purple fw-bold">Invoice From</div>
                    <div class="address-body">
                        <span class="fw-bold">
                            SECRETARIUS (PRIVATE) LIMITED
                        </span> <br>
                        Corporate Secretarics PV 5958, <br>
                        40, Galle Face Court 2, <br>
                        Colombo 3,
                    </div>
                </div>
                <div class="col address-col">
                    <div class="topic text-purple fw-bold">Invoice To</div>
                    <div class="address-body">
                        <span class="fw-bold">
                            {!! $company_data->to !!} <br>


                        </span>{!! $company_data->companyName . ',' !!} <br>
                        {!! str_replace(',', ',<br>', $company_data->address) !!}<br>
                        {{ $company_data->email }}
                    </div>
                </div>
            </div>
        </div>
        @php

            $no = 0;
        @endphp
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
                            {{ $dollarRate == 1 ? 'Rs.' : '$USD' }}
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
                                        {{ number_format($get->price / $dollarRate, 2) }}
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
        <div class="payment">
            <div class="row payment-row">
                <div class="col-9 bank-payment">
                    <div class="bank-topic text-purple fw-bold">
                        Bank & payment Details
                    </div>
                    <div class="gray">
                        Payment to be made by Crossed Cheque in favour of"Secretarics(PVT)LTD" Or Remittances to be made
                        to the undernoted Account.
                    </div>
                    <div class="bank-details">
                        <div class="bank-box">
                            <div class="box-1">
                                <div class="text-purple line">A/C Name</div>
                                <div class="text-purple line">Account No</div>
                                <div class="text-purple line">Bank Name</div>
                                <div class="text-purple line">Bank Address</div>
                                <div class="text-purple line">Swift Code</div>
                            </div>
                            <div class="box-2 bank-intern-box">
                                <div class="line">: {{ $bank->acName }}</div>
                                <div class="line">: {{ $bank->accountNo }}</div>
                                <div class="line">: {{ $bank->bankName }}</div>
                                <div class="line">: {{ $bank->bankAddress }}</div>
                                <div class="line">: {{ $bank->swiftCode }}</div>
                            </div>
                        </div>

                    </div>
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
                    <div class="row qr-row">
                        <div class="qr-code">
                            {!! $qr !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-purple">
            <span class="text-center">
                This is a computer-generated Invoice.
            </span>
        </div>
    </div>
    <script src="{{ asset('sidebar/css/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Add click event listener to the download button
        document.getElementById("downloadPdfBtn").addEventListener("click", function() {
            // Select the container with class "container"
            var container = document.querySelector('.main');

            // Use html2pdf to generate PDF from the container
            html2pdf(container, {
                margin: 10,
                filename: 'Invoice.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    dpi: 192,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            });
        });

        document.getElementById("printPdfBtn").addEventListener("click", function() {
            window.print();
        });
    </script>

    <script>
        window.onload = function() {
            var container = document.querySelector('.main');

            // Use html2pdf to generate PDF from the container
            html2pdf(container, {
                margin: 10,
                filename: "{{ $invoiceNumber }}",
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    dpi: 192,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            });
        }
    </script>

    <script>
        var shouldBlockRefresh = true;

        window.onbeforeunload = function() {
            if (shouldBlockRefresh) {
                return "Are you sure you want to leave this page?";
            }
        };

        // Example function to enable or disable blocking
        function toggleRefreshBlocking() {
            shouldBlockRefresh = !shouldBlockRefresh;
        }
    </script>

</body>

</html>
