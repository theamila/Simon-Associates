<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Outstanding Price</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Update Customer Outstanding Price</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Outstanding Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $key => $customer)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $customer->companyName }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>
                        <form action="{{ route('update.outstanding', $customer->id) }}" method="POST">
                            @csrf
                            <input type="text" name="outstanding_price" value="{{ number_format($customer->outstanding, 2) }}" class="form-control" placeholder="Enter new price" required>
                    </td>
                    <td>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        <a href="/deactivate/fix/{{$customer->id}}" class="btn btn-danger">Deactivate</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
