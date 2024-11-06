<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data[0]->companyName }}</title>
    <link rel="stylesheet" href="{{ asset('assets/Boostrap/bootstrap.min.css') }}">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Receipts Overview</h2>
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <td colspan="5" class="text-center fw-bold">{{  $data[0]->companyName }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <th>Details</th>
                    <th>Invoices Value</th>
                    <th>Receipts Value</th>
                    <th>Net Balance</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalInvoices = 0.0;
                    $totalReceipts = 0.0;
                    $cumulativeBalance = 0.0; // This will keep track of the running Net Balance
                @endphp

                @if (count($data) > 0)
                    @foreach ($data as $key => $item)
                        @php
                            $amount = 0.0;
                            $invoData = App\Models\InvoiceDetails::where('invoiceNumber', $item->invoiceNumber)->get();

                            if (!$invoData->isEmpty()) {
                                foreach ($invoData as $value) {
                                    $amount += $value->price;
                                }
                            }

                            $receiptAmount = 0.0;
                            $receipts = App\Models\Modelreceipt::where('invoiceNumber', $item->invoiceNumber)->get();
                            if (!$receipts->isEmpty()) {
                                foreach ($receipts as $rvalue) {
                                    $receiptAmount += $rvalue->payedAmount;
                                }
                            }

                            // Update the cumulative net balance for invoice entries
                            $cumulativeBalance += $amount;
                        @endphp

                        <!-- Displaying the Invoice Row -->
                        <tr>
                            <td>{{ $item->sendDate }}</td>
                            <td>{{ $item->invoiceNumber }}</td>
                            <td class="text-end">{{ number_format($amount, 2) }}</td>
                            <td></td>
                            <td class="text-end">{{ number_format($cumulativeBalance, 2) }}</td>
                        </tr>

                        <!-- Displaying the Receipt Rows -->
                        @foreach ($receipts as $ritem)
                            @php
                                // Deduct the receipt amount from the cumulative balance
                                $cumulativeBalance -= $ritem->payedAmount;
                                $totalReceipts += $ritem->payedAmount;
                            @endphp

                            <tr>
                                <td>{{ $ritem->payedDate }}</td>
                                <td>{{ $ritem->receiptNumber }}</td>
                                <td></td>
                                <td class="text-end">{{ number_format($ritem->payedAmount, 2) }}</td>
                                <td class="text-end">{{ number_format($cumulativeBalance, 2) }}</td>
                            </tr>
                        @endforeach

                        @php
                            $totalInvoices += $amount;
                        @endphp
                    @endforeach

                    <!-- Total Row -->
                    <tr>
                        <td colspan="2" class="text-end"><strong>Total</strong></td>
                        <td class="text-end"><strong>{{ number_format($totalInvoices, 2) }}</strong></td>
                        <td class="text-end"><strong>{{ number_format($totalReceipts, 2) }}</strong></td>
                        <td class="text-end"><strong>{{ number_format($cumulativeBalance, 2) }}</strong></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="5" class="text-center">No Data Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>
