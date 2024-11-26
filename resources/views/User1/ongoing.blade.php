@extends('sidebar.sub1')
@include('sweetalert::alert')

@section('title', 'Ongoing Invoice')

@section('pageTitle', 'Ongoing Invoices')
@section('content')

@section('Ttopic', 'Ongoing Invoices')
@section('thead')
    <th class="text-center">ID</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Invoice Number</th>
    <th class="text-center">Action</th>

@endsection
@section('tbody')
    @php $no = 0; @endphp
    @if ($data->count() > 0)
        @foreach ($data as $get)
            @php $no += 1; @endphp

            <tr>
                <td class="text-center">{{ $no }}</td>
                <td class="text-center">{{ $get->companyName }}</td>
                <td class="text-center">{{ $get->invoiceNumber }}</td>
                <td class="text-center">
                    @php
                        $invoiceNumber = str_replace('/', '-', $get->invoiceNumber);
                    @endphp

                    @if ($get->status == '2')
                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#editInvoiceModal{{ $get->id }}">
                            <i class="material-symbols-outlined">edit</i>
                        </button>
                    @endif

                    <a href="{{ Route('modify', $invoiceNumber) }}" class="btn btn-sm btn-success">
                        <i class="material-symbols-outlined">navigate_next</i>
                    </a>

                    <a onclick="return confirm('Are you sure you want to permanently delete this invoice? This action cannot be undone.');" href="/user/one/delete/invoice/{{ str_replace('/', '-', $get->invoiceNumber) }}" class="btn btn-sm btn-danger">
                        <i class="material-symbols-outlined">
                            delete
                        </i>
                    </a>

                </td>
            </tr>

            <!-- Bootstrap Modal -->
            <div class="modal fade" id="editInvoiceModal{{ $get->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editInvoiceModalLabel{{ $get->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editInvoiceModalLabel{{ $get->id }}">Edit Invoice Number</h5>
                            <button type="button" class="close btn btn-sm btn-danger" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ Route('edit.invoice.number', $get->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" name="oldInvoiceNumber" value="{{ $get->invoiceNumber }}">
                                    <label for="invoiceNumber{{ $get->id }}">Invoice Number</label>
                                    <input type="text" class="form-control" id="invoiceNumber{{ $get->id }}"
                                        name="invoiceNumber" value="{{ $get->invoiceNumber }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
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

    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@endsection

@endsection
