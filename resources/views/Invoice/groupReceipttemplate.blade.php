<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="{{ asset('sidebar/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sidebar/css/receipt.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- <link
        href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('css/css2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {
            color: #00008B;
            font-size: 10pt;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-size: 12px;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @page {
            size: A4;
        }

        i {
            margin-right: 10px;
            color: white;
        }

        th {
            color: white;
            background: #00008B;
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

            .notes {
                margin-top: auto;
                width: 100%;
                margin-bottom: 40px;
                /* Adjust as needed */
            }

            @page {
                size: A4;
                margin: 1cm;
            }
        }

        .header-row {
            margin-bottom: 20px;
        }

        .header-row h2 {
            margin-bottom: 10px;
        }

        .header-row .text-end {
            text-align: end;
        }

        .header-row .company-name {
            margin: 0;
            padding: 0;
            font-size: 1em;
            /* Adjust font size as needed */
            font-weight: bold;
            /* Make it bold if desired */
        }

        .header-row .sender-address {
            text-align: end;
        }

        .header-row .r-No {
            padding: 4px 0;
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')
    <div class="container mt-2 mb-2">
        @if ($isSubmit)
            <a href="/group/session/forgot" class="btn btn-danger"><i class="fa-solid fa-angle-left"></i>Back</a>
            <button id="printPdfBtn" class="btn btn-primary"><i
                    class="fa-solid fa-print"></i>Print</button>

                    <button id="downloadPdfBtn" class="btn btn-success"><i class="fa-solid fa-download"></i>Download</button>

        @else
            <form action="{{ Route('payment.submit') }}" method="post">
                @csrf
                <div class="row my-4">
                    <div class="col-3">
                        <input type="number" name="payment" placeholder="Enter Payment Amount.." class="form-control">

                        <input type="text" name="billNo" placeholder="Enter bill No.." class="form-control">

                        <input type="hidden" name="companyID" value="{{ $Invoice->id }}">

                    </div>
                    <div class="col">
                        <input type="submit" value="submit" class="btn btn-success">

                    </div>
                </div>
            </form>
        @endif
    </div>

    <div class="container main">
        <div class="header mt-2">
            <div class="row header-row">
                <div class="col-3">
                    <h2 class="text-start">RECEIPT</h2>
                    <div class="row ">
                        <div class="col-6 r-No">Date</div>
                        <div class="col-6 r-No" contenteditable="true">
                            {{ now()->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-7 r-No">Receipt No</label>
                        <div class="col-5 r-No" contenteditable="true">
                            {{session('receiptNumber')}}
                        </div>
                    </div>
                    {{-- {{ 'R ' . $formattedNumber }} --}}
                </div>
                <div class="col-9 text-end">
                    <h3 class="company-name">SECRETARIUS (PVT) LTD</h3>
                    <div class="sender-address">
                        <span>
                            #40, Galle Face Court 02, Colombo 03, <br>
                            (Reg. No: PV 5958) <br>
                            Tele: +94(011) 2399 090/2390 356 Fax: +94(011)2381 907 <br>
                            Email: simonsec@simonas.net Web: www.simonas.net <br>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bill-to">
            <div class="row">
                <div class="b-topic fw-bold">
                    <h2>TO</h2>
                </div>
                <div class="b-address">
                    <span class="text-start" contenteditable="true">
                        {{ $Invoice->to }} <br>
                        {{ $Invoice->companyName }}
                    </span>
                </div>
            </div>
        </div>

        <div class="table-area">
            <table>
                <thead>
                    <tr>
                        <th style="width: 150px;">
                            Invoice No
                        </th>
                        <th style="">Description</th>
                        <th style="width: 110px;">Method</th>
                        <th style="width: 180px;" contenteditable="true">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    @php
                    $invoice = App\Models\Invoice::find($item);

                    @endphp
                    <tr>
                        <td class="text-center" contenteditable="true" style="color: #00008B">{{ $invoice->invoiceNumber }}</td>
                        <td class="text-start" contenteditable="true" style="color: #00008B"></td>
                        <td class="text-center" contenteditable="true" style="color: #00008B"></td>
                        <td class="text-end" contenteditable="true" style="color: #00008B"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="form-group mb-3">
                <!-- <input type="text" id="totalInWords" class="form-control" readonly> -->
                <textarea name="totalInWords" class="form-control" id="totalInWords" cols="30" rows="2"
                    placeholder="Total in words.."></textarea>
            </div>
        </div>

        <div class="total-row fw-bold">
            <div class="row">
                <div class="col-8"></div>
                <div class="col-2">
                    Total
                </div>
                <div class="col-2 text-end" contenteditable="true" style="color: #00008B">0.00</div>
            </div>
            <div class="row">
                <div class="col-8"></div>
                <div class="col-2">
                    Payment
                </div>
                <div class="col-2 text-end" contenteditable="true" style="color: #00008B">0.00</div>
            </div>
            <div class="row">
                <div class="col-8 d-flex justify-content-center">
                    <span class="text-center fw-bold mb-5`">

                    </span>
                </div>

                <div class="col-2">
                    Balance
                </div>
                <div class="col-2 text-end" contenteditable="true" style="color: #00008B">0.00</div>
            </div>
        </div>
        <div class="notes">
            <div class="row p-2">
                <div class="note-topic">
                    Notes
                </div>
                <div class="col-12">
                    <li>This is an official receipt subject to realization of Cheques.</li>
                    <li>All Returned Cheques will be subject to a levy of Rs 1,500.00</li>
                    <li>Stamp Duty of this Receipt will be remitted in terms of section 7 of the Stamp Duty (Special
                        Provisions) Act No of 2006.</li>
                </div>
            </div>
        </div>
        <div class="row text-dark">
            <span class="text-center">
                This is a computer-generated receipt.
            </span>
        </div>
    </div>

    <script src="{{ asset('sidebar/css/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/html2pdf.bundle.min.js') }}"></script>

    @php
        $formattedNumber = session('receiptNumber');
    @endphp

{{--

<script>
    document.getElementById("downloadPdfBtn").addEventListener("click", function() {


        // ===============================


        function uploadPDF(pdfBlob, invoiceNumber) {
            var formData = new FormData();
            formData.append('pdf', pdfBlob, invoiceNumber + '.pdf');
            formData.append('invoiceNumber', invoiceNumber);

            fetch('{{ route('upload-pdf') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('PDF uploaded successfully!');
                        // Optionally, you can show a success message here.
                    } else {
                        console.warn('Failed to upload PDF, retrying...');
                        uploadPDF(pdfBlob, invoiceNumber); // Retry the upload
                    }
                })
                .catch(error => {
                    console.error('Error uploading PDF:', error);
                    // Retry the upload in case of an error
                    uploadPDF(pdfBlob, invoiceNumber);
                });
        }

        var container = document.querySelector('.main');
        var filename = '{{ session('receiptNumber') }}';

        html2pdf().from(container).set({
            margin: 10,
            filename: filename + '.pdf',
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
        }).outputPdf('blob').then(function(pdfBlob) {
            uploadPDF(pdfBlob, invoiceNumber); // Start the upload process
        });





        // ====================================
        var container = document.querySelector('.main');
        var filename = '{{ session('receiptNumber') }}';

        html2pdf(container, {
            margin: 10,
            filename: filename,
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
</script> --}}


{{--

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var totalPrice = parseFloat(document.getElementById('price').value);

        var dollars = Math.floor(totalPrice);
        var cents = Math.round((totalPrice - dollars) * 100);

        var dollarsInWords = numberToWords.toWords(dollars);
        var centsInWords = numberToWords.toWords(cents);

        document.getElementById('totalInWords').value = "Rupees " + dollarsInWords + ' and ' + centsInWords +
            ' cents';
    });
</script>

<script>
    document.getElementById("downloadPdfBtn").addEventListener("click", function() {


        // ===============================


        function uploadPDF(pdfBlob, invoiceNumber) {
            var formData = new FormData();
            formData.append('pdf', pdfBlob, invoiceNumber + '.pdf');
            formData.append('invoiceNumber', invoiceNumber);

            fetch('{{ route('upload-pdf') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('PDF uploaded successfully!');
                        // Optionally, you can show a success message here.
                    } else {
                        console.warn('Failed to upload PDF, retrying...');
                        uploadPDF(pdfBlob, invoiceNumber); // Retry the upload
                    }
                })
                .catch(error => {
                    console.error('Error uploading PDF:', error);
                    // Retry the upload in case of an error
                    uploadPDF(pdfBlob, invoiceNumber);
                });
        }

        var container = document.querySelector('.main');
        var invoiceNumber = '{{ $formattedNumber }}';

        html2pdf().from(container).set({
            margin: 10,
            filename: invoiceNumber + '.pdf',
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
        }).outputPdf('blob').then(function(pdfBlob) {
            uploadPDF(pdfBlob, invoiceNumber); // Start the upload process
        });


 --}}


{{-- ================================================== --}}



<script>
    document.addEventListener('DOMContentLoaded', function() {
        var totalPrice = parseFloat(document.getElementById('price').value);

        var dollars = Math.floor(totalPrice);
        var cents = Math.round((totalPrice - dollars) * 100);

        var dollarsInWords = numberToWords.toWords(dollars);
        var centsInWords = numberToWords.toWords(cents);

        document.getElementById('totalInWords').value = "Rupees " + dollarsInWords + ' and ' + centsInWords +
            ' cents';
    });
</script>

<script>
    document.getElementById("downloadPdfBtn").addEventListener("click", function() {


        // ===============================


        function uploadPDF(pdfBlob, invoiceNumber) {
            var formData = new FormData();
            formData.append('pdf', pdfBlob, invoiceNumber + '.pdf');
            formData.append('invoiceNumber', invoiceNumber);

            fetch('{{ route('upload-pdf') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('PDF uploaded successfully!');
                        // Optionally, you can show a success message here.
                    } else {
                        console.warn('Failed to upload PDF, retrying...');
                        uploadPDF(pdfBlob, invoiceNumber); // Retry the upload
                    }
                })
                .catch(error => {
                    console.error('Error uploading PDF:', error);
                    // Retry the upload in case of an error
                    uploadPDF(pdfBlob, invoiceNumber);
                });
        }

        var container = document.querySelector('.main');
        var invoiceNumber = '{{ $formattedNumber }}';

        html2pdf().from(container).set({
            margin: 10,
            filename: invoiceNumber + '.pdf',
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
        }).outputPdf('blob').then(function(pdfBlob) {
            uploadPDF(pdfBlob, invoiceNumber); // Start the upload process
        });





        // ====================================
        var container = document.querySelector('.main');

        html2pdf(container, {
            margin: 10,
            filename: '{{ $formattedNumber }}',
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
