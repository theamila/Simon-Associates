<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('sidebar/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sidebar/css/receipt.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Madimi+One&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {
            color: #00008B;
            font-size: 10pt;
        }

        i {
            color: white;
        }

        @page {
            size: A4;
        }

        i {
            margin-right: 10px;
        }

        th,
        td {
            padding: 5px;
            border: none;
            word-wrap: break-word;
        }

        .payment {
            padding: 10px;
            background: rgba(0, 0, 0, 0.05);
            margin-top: 10px;
            border-radius: 10px;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
        }

        .bank-topic {
            font-size: 15pt;
            /* margin-bottom: 10px; */
        }

        .bank-details {
            display: flex;
            justify-content: space-between;
            font-size: 10pt;
            background: rgba(255, 255, 255, 0.5);
            padding-left: 10px;
            /* margin-top: 10px; */
        }

        .bank-intern-box {
            padding-left: 5px;
        }

        .gray,
        .bank-details {
            font-size: 11pt;
            margin-left: 10px;
        }

        .bank-box {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
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
                margin: 1cm;
            }
        }
    </style>
</head>

<body>

    <div class="container mt-2 mb-2">
        <a href="{{ Route('Outstanding-invoice') }}" class="btn btn-danger"><i
                class="fa-solid fa-angle-left"></i>Back</a>
        <button id="printPdfBtn" class="btn btn-primary"><i class="fa-solid fa-print"></i>Print</button>
        <button id="downloadPdfBtn" class="btn btn-success"><i class="fa-solid fa-download"></i>Download</button>
    </div>

    <div class="container main">
        <div class="header mt-2">
            <div class="row header-row">
                <div class="col-3">
                    <h2 class="text-start">
                        INVOICE
                    </h2>
                    <div class="row">
                        <div class="col-7 r-No">
                            Date
                        </div>
                        <div class="col-5 r-No">
                            {{ $date ? \Carbon\Carbon::parse($date)->format('d/m/Y') : '' }}

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7 r-No">
                            Invoice No
                        </div>
                        <div class="col-5 r-No">
                            {{ $invoiceNumber }}
                        </div>
                    </div>

                </div>
                <div class="col-9">
                    <h3 class="text-end justify-content-end">
                        SECRETARIUS(PVT) LTD
                    </h3>
                    <div class="row justify-content-end">

                        <div class="col-12 sender-address justify-content-end">
                            <span class="text-end d-flex justify-content-end">

                                #40 Galle Face Court 02, Colombo 03, <br>
                                (Reg. No: PV 5958) <br>
                                Tele: +94(011) 2399 090/2390 356 Fax: +94(011)2381 907
                                <br>Email: simonsec@simonas.net Web: www.simonas.net <br>

                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="bill-to" style="
        position: relative;
        top: -20px;
        ">
            <div class="row mt-2">
                <div class="b-topic fw-bold">
                    <h4>TO</h4>
                </div>
                <div class="b-address">
                    <span class="text-start">
                        {!! $company_data->to !!} <br>
                        {!! $company_data->companyName . ',' !!} <br>
                        {!! str_replace(',', ',<br>', $company_data->address) !!}<br>
                        {{ $company_data->email }}
                    </span>
                </div>
            </div>
        </div>

        <div class="table-area">
            <table>
                <thead>
                    <tr style="background: #00008B">
                        <th class="text-center text-light" style="width: 70px;">
                            No
                        </th>
                        <th class="text-center text-light">
                            Description
                        </th>
                        <th class="text-center text-light" style="width: 150px;">
                            {{ $dollarRate == 1 ? 'Rs.' : '$USD' }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $total = 0;
                        $no = 0;
                        $ft = 1;
                    @endphp
                    @if ($invoice_data->count() > 0)
                        @foreach ($invoice_data as $get)
                            @if ($get->Reimbursables == '0')
                                <tr>
                                    @php
                                        $ft = 2;
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

                    @if ($ft == 2)
                        <tr>
                            <td colspan="2" class='fw-bold text-center'>
                                Total
                            </td>
                            <td class="fw-bold text-end">
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                    @endif


                    @php
                        $r = 1;
                        $t = 1;
                    @endphp
                    @if ($invoice_data->count() > 0)
                        @foreach ($invoice_data as $get)
                            @if ($get->Reimbursables == '1')
                                @if ($r == 1)
                                    @php $t = 2; @endphp
                                    <tr>
                                        <td class="fw-bold text-start" colspan="3">Reimbursable Expenses</th>
                                    </tr>
                                @endif
                                <tr>
                                    @php
                                        $r = 2;
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

                    @if ($t == 2)
                        <tr>
                            <td colspan="2" class='fw-bold text-center'>
                                Total
                            </td>
                            <td class="fw-bold text-end">
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>

        <div class="payment">
            <div class="row payment-row">
                <div class="col-12 bank-payment">

                    <div class="gray">
                        Payment to be made by Crossed Cheque in favour of"Secretarius(Pvt)Ltd" Or Remittances to be made
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
            </div>
        </div>
        <div class="row text-dark">
            <span class="text-center">
                This is a computer-generated Invoice.
            </span>
        </div>
    </div>

    <input type="hidden" name="price" id="price" Value="{{ $total }}">

    <script src="{{ asset('sidebar/css/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/numberToWords.min.js') }}"></script>
    <script src="{{ asset('assets/js/html2pdf.bundle.min.js') }}"></script>


    <script>
        // Add click event listener to the download button
        document.getElementById("downloadPdfBtn").addEventListener("click", function() {
            // Select the container with class "container"
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
