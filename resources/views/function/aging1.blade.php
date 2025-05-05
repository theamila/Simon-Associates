@extends('sidebar.sub1copy1')
@section('content')

<section class="">
    <h2>Aging Report - Rs</h2>

    @php
        use Carbon\Carbon;

        $currentDate = Carbon::now('Asia/Colombo');

        // Retrieve all companies
        $companies = App\Models\CompanyDetails::orderBy('companyName', 'asc')->get();

        // Initialize grand totals
        $grandTotal0_30 = 0;
        $grandTotal31_60 = 0;
        $grandTotal61_90 = 0;
        $grandTotal90plus = 0;
        $grandTotalAmount = 0;
    @endphp

    <div class="card shadow" style="border-radius: 15px;">
        <div class="card-body">
            <button id="exportButton" class="btn btn-success my-2">Excel</button>
            <div class="table-responsive">
                <table id="agingReportTable" class="table table-bordered table-hover table-striped">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Company Name</th>
                            <th scope="col" class="text-center">0 - 30 Days</th>
                            <th scope="col" class="text-center">31 - 60 Days</th>
                            <th scope="col" class="text-center">61 - 90 Days</th>
                            <th scope="col" class="text-center">90+ Days</th>
                            <th scope="col" class="text-center">Total Rs.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $rowNumber = 1; @endphp
                        @foreach ($companies as $company)
                            @php
                                // Retrieve invoices with status = 7 for the current company
                                $invoices = App\Models\Invoice::where('status', 7)
                                    ->where('customerRefId', $company->id)
                                    ->where('currency', 'LKR')
                                    ->get();

                                // Skip the company if it has no valid invoices
                                if ($invoices->isEmpty()) {
                                    continue;
                                }

                                // Initialize aging categories
                                $amount0_30 = 0;
                                $amount31_60 = 0;
                                $amount61_90 = 0;
                                $amount90plus = 0;
                                $totalAmount = 0;

                                foreach ($invoices as $inv) {
                                    $invoiceDate = $inv->sendDate ? Carbon::parse($inv->sendDate) : null;
                                    $duration = $invoiceDate ? $currentDate->diffInDays($invoiceDate) : null;

                                    // Calculate total invoice price minus payments
                                    $invoiceDetails = App\Models\InvoiceDetails::where(
                                        'invoiceNumber',
                                        $inv->invoiceNumber,
                                    )->get();
                                    $totalInvoicePrice = $invoiceDetails->sum('price');
                                    $receipts = App\Models\ModelReceipt::where(
                                        'invoiceNumber',
                                        $inv->invoiceNumber,
                                    )->get();

                                    foreach ($receipts as $receipt) {
                                        $totalInvoicePrice -= $receipt->payedAmount;
                                    }

                                    // Categorize the total based on duration
                                    if ($duration !== null) {
                                        if ($duration <= 30) {
                                            $amount0_30 += $totalInvoicePrice;
                                        } elseif ($duration <= 60) {
                                            $amount31_60 += $totalInvoicePrice;
                                        } elseif ($duration <= 90) {
                                            $amount61_90 += $totalInvoicePrice;
                                        } else {
                                            $amount90plus += $totalInvoicePrice;
                                        }
                                    }

                                    $totalAmount += $totalInvoicePrice;
                                }

                                $grandTotal0_30 += $amount0_30;
                                $grandTotal31_60 += $amount31_60;
                                $grandTotal61_90 += $amount61_90;
                                $grandTotal90plus += $amount90plus;
                                $grandTotalAmount += $totalAmount;
                            @endphp

                            <tr>
                                <td class="text-center">{{ $rowNumber++ }}</td>
                                <td class="text-center"> <a style="text-decoration: none;" target="_blank" href="/company/history/report/{{$company->id}}/LKR">{{ $company->companyName }}</a></td>
                                <td class="text-end">{{ number_format($amount0_30, 2) }}</td>
                                <td class="text-end">{{ number_format($amount31_60, 2) }}</td>
                                <td class="text-end">{{ number_format($amount61_90, 2) }}</td>
                                <td class="text-end">{{ number_format($amount90plus, 2) }}</td>
                                <td class="text-end" style="background-color: rgb(214, 214, 214)">
                                    {{ number_format($totalAmount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: rgb(214, 214, 214)">
                            <td colspan="2" class="text-center font-weight-bold">Total: - Rs</td>
                            <td class="text-end fw-bold">{{ number_format($grandTotal0_30, 2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($grandTotal31_60, 2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($grandTotal61_90, 2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($grandTotal90plus, 2) }}</td>
                            <td class="text-end fw-bold" style="background-color: rgb(214, 214, 214)">
                                {{ number_format($grandTotalAmount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>



















<section class="my-4">
    <h2>Aging Report - USD</h2>

    @php

        $currentDate = Carbon::now('Asia/Colombo');

        // Retrieve all companies
        $companies = App\Models\CompanyDetails::orderBy('companyName', 'asc')->get();

        // Initialize grand totals
        $grandTotal0_30 = 0;
        $grandTotal31_60 = 0;
        $grandTotal61_90 = 0;
        $grandTotal90plus = 0;
        $grandTotalAmount = 0;
    @endphp

    <div class="card shadow" style="border-radius: 15px;">
        <div class="card-body">
            <button id="exportButtonDoller" class="btn btn-success my-2">Excel</button>
            <div class="table-responsive">
                <table id="agingReportTableDoller" class="table table-bordered table-hover table-striped">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Company Name</th>
                            <th scope="col" class="text-center">0 - 30 Days</th>
                            <th scope="col" class="text-center">31 - 60 Days</th>
                            <th scope="col" class="text-center">61 - 90 Days</th>
                            <th scope="col" class="text-center">90+ Days</th>
                            <th scope="col" class="text-center">Total USD $</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $rowNumber = 1; @endphp
                        @foreach ($companies as $company)
                            @php
                                // Retrieve invoices with status = 7 for the current company
                                $invoices = App\Models\Invoice::where('status', 7)
                                    ->where('customerRefId', $company->id)
                                    ->where('currency', 'USD')
                                    ->get();

                                // Skip the company if it has no valid invoices
                                if ($invoices->isEmpty()) {
                                    continue;
                                }

                                // Initialize aging categories
                                $amount0_30 = 0;
                                $amount31_60 = 0;
                                $amount61_90 = 0;
                                $amount90plus = 0;
                                $totalAmount = 0;

                                foreach ($invoices as $inv) {
                                    $invoiceDate = $inv->sendDate ? Carbon::parse($inv->sendDate) : null;
                                    $duration = $invoiceDate ? $currentDate->diffInDays($invoiceDate) : null;

                                    // Calculate total invoice price minus payments
                                    $invoiceDetails = App\Models\InvoiceDetails::where(
                                        'invoiceNumber',
                                        $inv->invoiceNumber,
                                    )->get();
                                    $totalInvoicePrice = $invoiceDetails->sum('price');
                                    $receipts = App\Models\ModelReceipt::where(
                                        'invoiceNumber',
                                        $inv->invoiceNumber,
                                    )->get();

                                    foreach ($receipts as $receipt) {
                                        $totalInvoicePrice -= $receipt->payedAmount;
                                    }

                                    // Categorize the total based on duration
                                    if ($duration !== null) {
                                        if ($duration <= 30) {
                                            $amount0_30 += $totalInvoicePrice;
                                        } elseif ($duration <= 60) {
                                            $amount31_60 += $totalInvoicePrice;
                                        } elseif ($duration <= 90) {
                                            $amount61_90 += $totalInvoicePrice;
                                        } else {
                                            $amount90plus += $totalInvoicePrice;
                                        }
                                    }

                                    $totalAmount += $totalInvoicePrice;
                                }

                                $grandTotal0_30 += $amount0_30;
                                $grandTotal31_60 += $amount31_60;
                                $grandTotal61_90 += $amount61_90;
                                $grandTotal90plus += $amount90plus;
                                $grandTotalAmount += $totalAmount;
                            @endphp

                            <tr>
                                <td class="text-center">{{ $rowNumber++ }}</td>
                                <td class="text-center"> <a style="text-decoration: none;" target="_blank" href="/company/history/report/{{$company->id}}/USD">{{ $company->companyName }}</a></td>
                                <td class="text-end">{{ number_format($amount0_30, 2) }}</td>
                                <td class="text-end">{{ number_format($amount31_60, 2) }}</td>
                                <td class="text-end">{{ number_format($amount61_90, 2) }}</td>
                                <td class="text-end">{{ number_format($amount90plus, 2) }}</td>
                                <td class="text-end" style="background-color: rgb(214, 214, 214)">
                                    {{ number_format($totalAmount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: rgb(214, 214, 214)">
                            <td colspan="2" class="text-center font-weight-bold">Total - USD:</td>
                            <td class="text-end fw-bold">{{ number_format($grandTotal0_30, 2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($grandTotal31_60, 2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($grandTotal61_90, 2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($grandTotal90plus, 2) }}</td>
                            <td class="text-end fw-bold" style="background-color: rgb(214, 214, 214)">
                                {{ number_format($grandTotalAmount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('assets/js/xlsx.full.min.js') }}"></script>
<script>
    document.getElementById('exportButtonDoller').addEventListener('click', function() {
        var table = document.getElementById('agingReportTableDoller');
        var worksheet = XLSX.utils.table_to_sheet(table);
        var workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Aging Report');
        XLSX.writeFile(workbook, 'Aging_Report.xlsx');
    });
</script>














<script src="{{ asset('assets/js/xlsx.full.min.js') }}"></script>
<script>
    document.getElementById('exportButton').addEventListener('click', function() {
        var table = document.getElementById('agingReportTable');
        var worksheet = XLSX.utils.table_to_sheet(table);
        var workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Aging Report');
        XLSX.writeFile(workbook, 'Aging_Report.xlsx');
    });
</script>


@endsection
