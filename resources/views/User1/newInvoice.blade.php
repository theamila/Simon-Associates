@extends('sidebar.sub1')

@section('title', 'New Invoice')

@section('pageTitle', 'New Invoice')
@section('content')
    @include('sweetalert::alert')

    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrapNew.min.js') }}"></script>
@section('Ttopic', 'New Invoice')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@section('search')
    <form action="{{ Route('search.customer') }}" method="get">

        <div class="row">
            <div class="col d-flex flex-inline">
                <input type="text" name="name" class="form-control" placeholder="Customer Name..."
                    value="{{ $name }}" required>
                <input type="submit" value="Search" class="btn btn-sm btn-danger">
            </div>
        </div>
    </form>
@endsection
@if ($errors->has('invoiceNumber'))
    <script>
        alert('Invoice number already exists. Please enter a unique invoice number.');
    </script>
@endif

@section('thead')
    <th class="text-center">ID</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Address</th>
    <th class="text-center">Action</th>

@endsection
@section('tbody')
    @php $no =0; @endphp
    @if ($data->count() > 0)
        @foreach ($data as $get)
            @php $no += 1; @endphp
            <tr>
                <td class="text-center">{{ $no }}</td>
                <td class="text-center">{{ $get->companyName }}</td>
                <td>{{ $get->address }}</td>
                <td class="text-center">
                    <!-- Trigger the modal -->
                    <a href="#" class="btn btn-sm btn-success" data-toggle="modal"
                        data-target="#invoiceModal-{{ $get->id }}">
                        <i class="material-symbols-outlined">
                            navigate_next
                        </i>
                    </a>
                </td>
            </tr>

            <!-- Modal Structure for each company -->
            <div class="modal fade" id="invoiceModal-{{ $get->id }}" tabindex="-1"
                aria-labelledby="invoiceModalLabel-{{ $get->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="invoiceModalLabel-{{ $get->id }}">Enter Invoice Number for
                                {{ $get->companyName }}</h5>
                            <button type="button" class="close btn btn-sm btn-danger" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="invoiceForm-{{ $get->id }}">
                                <div class="form-group">
                                    <label for="invoiceNumber-{{ $get->id }}">Invoice Number</label>
                                    <input type="text" class="form-control" id="invoiceNumber-{{ $get->id }}"
                                        name="invoiceNumber" required>
                                </div>
                                <input type="hidden" id="userId-{{ $get->id }}" name="userId"
                                    value="{{ $get->id }}">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary"
                                onclick="submitInvoice({{ $get->id }})">Generate Invoice</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <tr>
            <td colspan="4" class="text-center fw-bold">
                No Records Found...
            </td>
        </tr>
    @endif

@endsection

@endsection

<script>
    function submitInvoice(id) {
        var invoiceNumber = document.getElementById('invoiceNumber-' + id).value;
        var userId = document.getElementById('userId-' + id).value;

        if (invoiceNumber) {
           
            // Redirect to generate the invoice using the entered invoice number and user ID
            window.location.href = `/generateInvoice/${userId}?invoiceNumber=${invoiceNumber}`;
        } else {
            alert('Please enter an invoice number.');
        }
    }
</script>

@if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

<script>
    function disableButton(button) {
        button.classList.add('disabled');
        button.setAttribute('disabled', 'disabled');
    }
</script>
