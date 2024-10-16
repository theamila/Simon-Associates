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
    <div class="container mt-3">

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <form action="{{ route('sendCheckedReceipts') }}" method="GET">
            @csrf
            <div class="row">
                @php
                    // Group invoices by customerRefId
                    $groupedInvoices = $data->groupBy('customerRefId');
                @endphp

                @foreach ($groupedInvoices as $customerRefId => $invoices)
                    @php
                        $customer = App\Models\CompanyDetails::find($customerRefId);
                    @endphp

                    <div class="col-12 mb-2">
                        <h4 class="font-weight-bold"><i
                                class="fa-solid fa-caret-right me-2 text-danger"></i>{{ $customer ? $customer->companyName : 'Not Found..' }}
                        </h4>
                    </div>

                    @foreach ($invoices as $invoice)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input type="checkbox" name="receipt_ids[]" value="{{ $invoice->id }}"
                                            class="form-check-input" style="transform: scale(1.5);">
                                        <label class="form-check-label">
                                            Invoice No: {{ $invoice->invoiceNumber }}
                                        </label>
                                    </div>
                                    {{-- <p class="mt-2">Invoice Date: {{ $invoice->created_at->format('Y-m-d') }}</p> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

            <div class="text-right">
                <a href="/2/outstanding/view" class="btn btn-danger"
                    onclick="return confirm('Are You sure you want to exit?')">Back</a>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Are You sure?')">Next</button>
            </div>
        </form>
    </div>
    <script src="{{ asset('sidebar/css/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
