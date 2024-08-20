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
                margin: 1cm;
            }
        }
    </style>
<body>
<div class="container mt-2 mb-2">
<a href="{{ Route('Outstanding-invoice') }}" class="btn btn-danger"><i class="fa-solid fa-angle-left"></i>Back</a>
<button id="printPdfBtn" class="btn btn-primary"><i class="fa-solid fa-print"></i>Print</button>
<button id="downloadPdfBtn" class="btn btn-success"><i class="fa-solid fa-download"></i>Download Again</button>
</div>

<div class="container main">

        <div class="d-flex flex-column align-items-center mt-4 mb-2" >

            <h5 class="CompanyName text-center">SECRETARIUS (PRIVATE) LIMITED</h5>
            <h6 class="CompanyName text-center">
                (Reg No: PV 5958) <br>
                #40, Galle Face Court2,Colombo 03. <br>
                Tele: +94(011) 233090/2390356 Fax: +94(011)2381907 <br>
                Email: simonas@simonas.net Web: www.simonas.net
            </h6>
            <hr class="w-100 bg-dark" style="height: 3px; background-color: #000;">

            <h2>
                RECEIPT
            </h2>

        </div>

        <div class="row">
            <div class="col-6 border-dark p-3 pb-0" style="border-left: 1px solid #000; border-top: 1px solid #000; border-bottom: 1px solid #000;">
                To: <span class="text-justify" style="display: block; margin-left: 25px; transform: translateY(-22px);">

                {{ $Invoice->to }} <br>
                @if ($Invoice->companyName)
                <p>
                {!! str_replace(',', ',<br>', $Invoice->companyName	) !!}
                </p>
                @endif
                </span>
            </div>
            <div class="col-6 border border-dark p-3 pb-0">
                Date: {{ now()->format('d/m/Y') }} <br>
                Receipt No: R6388
            </div>
        </div>

        <div class="row mt-4">
        <table class="table">
            <thead class="border border-dark">
            <tr>
                <th style="width: 35px; max-width: 35px;" class="border-end border-dark"></th>
                <th style="width: 350px; max-width: 350px;" class="border-end border-dark"></th>
                <th style="width: 50px;" class="border-dark"></th>
                <th style="width: 150px;" class="text-center border border-dark">Cash/Chq TRF</th>
                <th style="width: 150px; max-width: 150px;" class="border-end border-dark">Rs.</th>
            </tr>
            </thead>
            <tbody class="border border-dark">
            @php
                $total = 0;
            @endphp

            @if($invoice_data->count() > 0)
                @foreach($invoice_data as $get)
                    @if($get->Reimbursables == "0")
                    <tr>
                    <td class="text-center border-end border-dark" style="border-bottom: none;">
                            {{ $get->invoiceNumber }}
                        </td>
                        <td class="text-wrap text-break border-end border-dark" style="border-bottom: none;">
                            {{ $get->description }}
                        </td>
                        <td class="border-end border-dark" style="border-bottom: none;"></td>
                        <td class="border-end border-dark text-center" style="border: none;">
                            {{ $method }}
                        </td>
                        <td class='text-end border-end border-dark' style="border: none;">


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
                        <td class="text-center border-end border-dark" style="border-bottom: none;">
                            {{ $get->invoiceNumber }}
                        </td>
                        <td class="text-wrap text-break border-end border-dark" style="border-bottom: none;">
                            {{ $get->description }}
                        </td>

                        <td class="border-end border-dark" style="border-bottom: none;"></td>
                        <td class="border-end border-dark text-center" style="border: none;">
                        {{ $method }}
                        </td>
                        <td class='text-end border-end border-dark' style="border: none;">

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

            <tr>

                    <td colspan="4" class="fw-bold text-center border border-dark">
                        Total
                    </td>

                    <td class="fw-bold text-end border border-dark">
                    {{ number_format($total, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center bordered" colspan="4">
                        Payment
                    </td>
                    <td class="text-end bordered">
                        {{ $payment }}
                    </td>
                </tr>
                <tr>
                <td colspan="4" class="fw-bold text-center border border-dark">
                    Balance
                </td>
                    @php
                    if($payment > $total)
                        $balance = $payment - $total;
                    else
                        $balance = $total - $payment;
                    @endphp
                <td class="text-end">
                    {{ $balance }}
                </td>
            </tr>

            </tbody>
            <input type="hidden" name="price" id="price" Value="{{ $total }}">
        </table>
        </div>

        <div class="row">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Rupee :</span>
            <input type="text" id="totalInWords" class="form-control" aria-label="" aria-describedby="basic-addon1" readonly>
            </div>
        </div>

        <div class="row mt-5 align-items-end">
            <div class="col-12 text-end d-flex flex-column" style="margin-right: 20px;">

                <span class="text-center fw-bold mb-5`">
                .................................................................... <br>
                Authorized Signatory
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <p>
                    Notes:
                </p>
                <ul>
                    <li>This is an official receipt subject to realization of Cheques.</li>
                    <li>All Returned Cheques will be subject to a levy of Rs 1,500.00</li>
                    <li>Stamp Duty of this Receipt will be remitted in terms of section 7 of the Stamp Duty (Specioal Provisions) Act No of 2006.</li>
                </ul>
            </div>
        </div>
</div>




<script src="{{ asset('assets/js/numberToWords.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var totalPrice = parseFloat(document.getElementById('price').value);

        var dollars = Math.floor(totalPrice);
        var cents = Math.round((totalPrice - dollars) * 100);

        var dollarsInWords = numberToWords.toWords(dollars);
        var centsInWords = numberToWords.toWords(cents);

        document.getElementById('totalInWords').value ="Rupees " + dollarsInWords + ' and ' + centsInWords + ' cents';
    });
</script>

<script>
        document.getElementById("downloadPdfBtn").addEventListener("click", function() {
            var container = document.querySelector('.main');

            html2pdf(container, {
                margin: 10,
                filename: 'Receipt.pdf',
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

            html2pdf(container, {
                margin: 10,
                filename: 'Receipt.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { dpi: 192, letterRendering: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            });
        }
    </script>
</body>
</html>
