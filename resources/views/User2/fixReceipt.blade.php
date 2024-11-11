<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Outstanding Price</title>
    <link href="{{ asset('Login-customa/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Update Receipt Payment Price</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-center">Receipt Number</th>
                    <th class="text-center">Pay Date</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (!$data->isEmpty())
                    @foreach ($data as $key => $item)
                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td class="text-center">{{ $item->receiptNumber }}</td>
                            <td class="text-center">{{ $item->payedDate }}</td>
                            <td>
                                <form action="{{ route('update.receipt', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="number" name="receipt_price"
                                        value="{{ $item->payedAmount }}" class="form-control" required
                                        step="0.01" aria-label="Receipt Price">
                            </td>
                            <td class="text-center">
                                <button type="submit" class="btn btn-primary" aria-label="Update Price">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center fw-bold"> All Receipts are Updated.. </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</body>
</html>
