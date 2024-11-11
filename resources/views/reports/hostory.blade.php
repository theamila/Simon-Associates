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
        <h2 class="mb-3">Receipts Overview</h2>

        <button id="exportButton" class="btn btn-success mb-2">Export to Excel</button>


        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <td colspan="5" class="text-center fw-bold">{{ $data[0]->companyName }}</td>
                </tr>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Details</th>
                    <th class="text-center">Invoices Value</th>
                    <th class="text-center">Receipts Value</th>
                    <th class="text-center">Net Balance</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalInvoices = 0.0;
                    $totalReceipts = 0.0;
                    $cumulativeBalance = 0.0; // Running net balance

                    // Combine invoices and receipts into a single array
                    $transactions = [];

                    foreach ($data as $item) {
                        // Get invoice details
                        $amount = 0.0;
                        $invoData = App\Models\InvoiceDetails::where('invoiceNumber', $item->invoiceNumber)->get();

                        if (!$invoData->isEmpty()) {
                            foreach ($invoData as $value) {
                                $amount += $value->price;
                            }
                        }

                        // Add invoice entry to the transactions array
                        $transactions[] = [
                            'date' => $item->sendDate,
                            'details' => $item->invoiceNumber,
                            'invoicesValue' => $amount,
                            'receiptsValue' => null,
                            'type' => 'invoice',
                        ];

                        // Get receipt details
                        $receipts = App\Models\Modelreceipt::where('invoiceNumber', $item->invoiceNumber)->get();
                        if (!$receipts->isEmpty()) {
                            foreach ($receipts as $rvalue) {
                                // Add receipt entry to the transactions array
                                $transactions[] = [
                                    'date' => $rvalue->payedDate,
                                    'details' => $rvalue->receiptNumber,
                                    'invoicesValue' => null,
                                    'receiptsValue' => $rvalue->payedAmount,
                                    'type' => 'receipt',
                                ];
                            }
                        }
                    }

                    // Sort transactions by date
                    usort($transactions, function ($a, $b) {
                        return strtotime($a['date']) <=> strtotime($b['date']);
                    });
                @endphp

                @if (count($transactions) > 0)
                    @foreach ($transactions as $transaction)
                        @php
                            if ($transaction['type'] == 'invoice') {
                                $cumulativeBalance += $transaction['invoicesValue'];
                                $totalInvoices += $transaction['invoicesValue'];
                            } else {
                                $cumulativeBalance -= $transaction['receiptsValue'];
                                $totalReceipts += $transaction['receiptsValue'];
                            }
                        @endphp

                        <tr>
                            <td class="text-end">{{ \Carbon\Carbon::parse($transaction['date'])->format('d F Y') }}
                            </td>

                            <td class="text-center">{{ $transaction['details'] }}</td>
                            <td class="text-end">
                                {{ $transaction['invoicesValue'] !== null ? number_format($transaction['invoicesValue'], 2) : '' }}
                            </td>
                            <td class="text-end">
                                {{ $transaction['receiptsValue'] !== null ? number_format($transaction['receiptsValue'], 2) : '' }}
                            </td>
                            <td class="text-end">{{ number_format($cumulativeBalance, 2) }}</td>
                        </tr>
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

    <script src="{{ asset('assets/js/xlsx.full.min.js') }}"></script>

    <script>
        // document.getElementById('exportButton').addEventListener('click', function() {
        //     var wb = XLSX.utils.table_to_book(document.querySelector('table'), {
        //         sheet: "Sheet1"
        //     });
        //     XLSX.writeFile(wb, 'transactions.xlsx');
        // });

        document.getElementById('exportButton').addEventListener('click', function() {
            // Get all the table rows
            const rows = document.querySelectorAll('table tbody tr');

            // Loop through the rows and format the date column
            rows.forEach(row => {
                const dateCell = row.querySelector(
                    'td:nth-child(1)'); // Assuming the date is in the first column
                if (dateCell) {
                    const date = new Date(dateCell
                        .textContent); // Convert the text content to a Date object

                    // Format the date as 'dd MMMM yyyy' (e.g., '06 November 2024')
                    const formattedDate = date.toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });

                    // Update the cell with the formatted date
                    dateCell.textContent = formattedDate;
                }
            });

            // Convert the table to Excel and download it
            var wb = XLSX.utils.table_to_book(document.querySelector('table'), {
                sheet: "Sheet1"
            });
            XLSX.writeFile(wb, 'transactions.xlsx');
        });
    </script>

</body>

</html>
