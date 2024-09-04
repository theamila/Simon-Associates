<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>


    <link href="{{ asset('sidebar/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="{{ asset('assets/js/html2pdf.bundle.min.js') }}"></script>

</head>
<style>
    .CompanyName{
    color: #7952b3;
}
i{
    margin-right: 10px;
}
        @media print {
            body {
                size: A4;
                margin: 0;
                padding: 0;
            }
            .btn{
                display: none;
            }


            @page {
                size: A4;
                margin: 0;
                padding: 0;
            }
        }

    </style>
<body>
<div class="container mt-3">

<a href="{{ Route('Approved-invoice') }}" class="btn btn-danger"><i class="fa-solid fa-angle-left"></i>Back</a>
<button id="printPdfBtn" class="btn btn-primary"><i class="fa-solid fa-print"></i>Print</button>
<button id="downloadPdfBtn" class="btn btn-success"><i class="fa-solid fa-download"></i>Download Again</button>

</div>
    <div class="container main">


        <div class="d-flex flex-column align-items-center mt-4">

            <h5 class="CompanyName text-center">SECRETARIUS (PRIVATE) LIMITED</h5>
            <h6 class="CompanyName text-center">
                Corporate Secretaries <br>
                PV 5958
            </h6>
        </div>


    <div class="col-12">
        <div class="row">
            <div class="col-12 text-end fw-bold">
                <span>
                    40,Gall Face Court2, <br>
                    Colombo 3,
                </span>
            </div>
            <div class="col-12 text-end mt-2 fw-bold">
                <span>
                    Telephone : +94 2333431/2543883 <br>
                    Fax : +94 2333431 <br>
                    Email : simonas@simonsec.net
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-start mt-3">
                <span class="fw-bold">
                    <!-- 13<sup>th</sup> March 2024 -->
                    {{ date('jS F Y', strtotime($date)) }}
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-end fw-bold">
                INVOICE NO : {{ $invoiceNumber }}
            </div>
        </div>
        <div class="row">
        <div class="col-12 text-start fw-bold mt-4">

    <p>To: {!! $company_data->to !!},</p>

    <p style="margin-left: 25px;margin-top:-15px;">
    {!! $company_data->companyName . ',' !!} <br>
    {!! str_replace(',', ',<br>', $company_data->address) !!} <br>
    {{ $company_data->email }}
    </p>
</div>


        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-1">
        <table class="table border-light">
            <thead>
                <tr class="text-center">
                    <th style="max-width: 200px;">Description</th>
                    <th class="text-end">{{ $dollarRate == 1 ? 'Rs.' : '$USD' }}</th>
                </tr>
            </thead>
            <tbody>
            @php
    $total = 0;
@endphp

@if($invoice_data->count() > 0)
    @foreach($invoice_data as $get)
        @if($get->Reimbursables == '0')
            <tr>
                @php

                    $total += $get->price;
                @endphp
                <td class="text-wrap text-break">
                    {{ $get->description }}
                </td>
                <td class="text-end">
                    {{ number_format($get->price, 2) }}
                </td>
            </tr>
        @endif
    @endforeach
@endif

<tr>
    <td class='fw-bold text-center'>
        Total
    </td>
    <td class="fw-bold text-end">
        {{ number_format($total, 2) }}
    </td>
</tr>

<tr>
    <th class="fw-bold text-start" colspan="3">Reimbursable Expenses</th>
</tr>


@if($invoice_data->count() > 0)
    @foreach($invoice_data as $get)
        @if($get->Reimbursables == '1')
            <tr>
                @php

                    $total += $get->price;
                @endphp
                <td class="text-wrap text-break">
                    {{ $get->description }}
                </td>
                <td class="text-end">
                    {{ number_format($get->price, 2) }}
                </td>
            </tr>
        @endif
    @endforeach
@endif

<tr>
    <td class="fw-bold text-center">
        Total value
    </td>
    <td class="fw-bold text-end">
        {{ number_format($total, 2) }}
    </td>
</tr>


            </tbody>
        </table>
        <div class="row">
            <div class="col-12 fw-bold">
                <p>
                    Payment to be made by Crossed Cheque in favour of "Secretarius (Pvt) Ltd" <br> Or <br>
                    Remittances to be made to the undernoted Account
                </p>
            </div>
            <div class="row d-flex align-items-center">
                <div class="col-12">
                    <table class="fs-6">
                        <tr>
                            <th class="text-start mr-4" style="width: 130px;">
                            A/C Name
                            </th>
                            <td class="">
                            - SECRETARIUS(pvt) ltd
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start mr-4" style="width: 130px;">
                            Account No
                            </th>
                            <td class="">
                            - 000910010182
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start mr-4" style="width: 130px;">
                            Bank name
                            </th>
                            <td class="">
                            - Sampath bank Plc-Nawam mawatha Branch
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start mr-4" style="width: 130px;">
                            Bank Address
                            </th>
                            <td class="">
                            - 46/38,nawam mawatha, Colombo 02,Sri lanka.
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start mr-4" style="width: 130px;">
                            Swift Code
                            </th>
                            <td class="">
                            - BSAMLKLX
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>

    <script>
        // Add click event listener to the download button
        document.getElementById("downloadPdfBtn").addEventListener("click", function() {
            // Select the container with class "container"
            var container = document.querySelector('.main');

            // Use html2pdf to generate PDF from the container
            html2pdf(container, {
                margin: 10,
                filename: 'Invoice.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { dpi: 192, letterRendering: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            });
        });

        document.getElementById("printPdfBtn").addEventListener("click", function(){
            window.print();
        });
    </script>

    <script>
        window.onload = function() {
            var container = document.querySelector('.main');

            // Use html2pdf to generate PDF from the container
            html2pdf(container, {
                margin: 10,
                filename: 'generated_pdf.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { dpi: 192, letterRendering: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
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
