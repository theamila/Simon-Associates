<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('sidebar/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sidebar/css/receipt.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="{{ asset('css/css2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css3.css') }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container mt-3 border py-3">
        <div class="text-right">
            <a href="/group/receipt" class="btn btn-danger">Back</a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('selectedReceipts'))
            @php
                $invoiceArray = session('selectedReceipts');
            @endphp

            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr class="text-dark">
                        <th>Invoice Number</th>
                        <th>Amount</th>
                        <th>Receipt No</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoiceArray as $receipt)
                        <!-- Using $invoiceArray instead of $selectedReceipts -->
                        @php
                            $invoice = App\Models\Invoice::find($receipt);
                        @endphp

                        @if ($invoice)
                            <div class="my-3">
                                <form action="{{ Route('settle.outstanding.group') }}" method="get">
                                    <tr>
                                        <td class="text-center">
                                            <label for="amount"
                                                class="col-form-label">{{ $invoice->invoiceNumber }}</label>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="amount" id="amount"
                                                step="0.01" min="0" placeholder="0.00" required>

                                            <input type="hidden" value="{{ $invoice->id }}" name="invoiceID">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="receipt"
                                                placeholder="R0001" value="{{ session('receiptNumber', '') }}" required>

                                        </td>
                                        <td class="text-center">
                                            <input type="submit" value="Settle" class="btn btn-success">

                                        </td>
                                    </tr>
                                </form>
                            </div>
                        @else
                            @php
                                session()->flash('error', 'Invoice not found for receipt: ' . $receipt);
                            @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
            @php
                return redirect()->back()->with('error', 'Invoices not selected.');
            @endphp
        @endif
    </div>

    <script src="{{ asset('sidebar/css/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
