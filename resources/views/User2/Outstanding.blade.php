@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@extends('sidebar.user2sub1')

@section('title', 'Outstanding Invoice')
@section('pageTitle', 'Outstanding Invoice')

{{-- Include Select2 CSS --}}


@section('content')
    <!-- Add to your Blade file's <head> section -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Add before the closing </body> tag -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @include('sweetalert::alert')

@section('Ttopic', 'Outstanding Invoice')

@section('thead')
    <button type="button" class="btn btn-success col-3 float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">Custom
        Receipt</button>

    <a href="{{ route('group.receipt') }}" class="btn btn-primary float-end me-1">Group Receipt</a>

    <a href="#" class="btn btn-danger float-end mx-1" data-bs-toggle="modal"
        data-bs-target="#advancePaymentModal">Advance Payment</a>

    <th class="text-center">ID</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Date</th>
    <th class="text-center">Invoice Number</th>
    <th class="text-center">Total</th>
    <th class="text-center">Duration</th>
    <th class="text-center">Action</th>
@endsection

@section('tbody')
    @if ($data->count())
        @foreach ($data as $key => $get)
            @php
                $start = strtotime($get->sendDate);
                $ageDays = floor((time() - $start) / 86400);
                $details = DB::table('invoice_details')
                    ->where('invoiceNumber', $get->invoiceNumber)
                    ->where('status', 0)
                    ->get();
                $total = $details->sum(fn($i) => $i->price * $i->dollerRate);
            @endphp

            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="text-center">{{ $get->companyName }}</td>
                <td class="text-center">{{ $get->sendDate }}</td>
                <td class="text-center">{{ $get->invoiceNumber }}</td>
                <td class="text-center">
                    {{ $details->count() ? number_format($total, 2) : '-' }}
                </td>
                <td class="text-center">{{ $ageDays }}</td>
                <td class="text-center">
                    @php $invNum = str_replace('/', '-', $get->invoiceNumber); @endphp

                    {{-- <a href="/settle/invoice/manual/{{ $get->id }}" class="btn btn-sm btn-success"
                        onclick="return confirm('Settle this invoice?')"><i class="material-symbols-outlined">check</i></a> --}}

                    <a href="{{ Storage::url("invoices/{$invNum}.pdf") }}" target="_blank" class="btn btn-sm btn-info"><i
                            class="material-symbols-outlined">visibility</i></a>

                    <a href="{{ route('re.send', $get->id) }}" class="btn btn-sm btn-warning" title="Re Send"><i
                            class="material-symbols-outlined">sync</i></a>

                    <a href="/delete/invoice/{{ $get->id }}" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this invoice?')"><i class="material-symbols-outlined">delete</i></a>

                    <a href="{{ route('generateReceiptForm', $get->id) }}" class="btn btn-sm btn-primary"><i
                            class="material-symbols-outlined">navigate_next</i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center fw-bold">No Records Found...</td>
        </tr>
    @endif

    {{-- Custom Receipt Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Custom Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if (!empty($company))
                        <ul>
                            @foreach ($company as $cust)
                                <li class="p-2">
                                    <a href="/cus-receipt/{{ $cust->id }}" title="{{ $cust->address }}"
                                        class="text-decoration-none text-dark">{{ $cust->companyName }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Advance Payment Modal --}}
    <div class="modal fade" id="advancePaymentModal" tabindex="-1" aria-labelledby="advancePaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Advance Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="advancePaymentForm" action="/advancePayment" method="get">
                        @csrf
                        <div class="mb-3">
                            <label for="customerSelect" class="form-label">Select Customer</label>
                            <select id="customerSelect" class="form-select" name="customer_id" required style="width: 100%">
                                <option value="">Select a customer</option>
                                @foreach ($company as $cust)
                                    <option value="{{ $cust->id }}">
                                        {{ $cust->companyName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="receiptNo" class="form-label">Invoice No (If avalible)</label>
                                <select id="invoiceNo" class="form-select" name="invoiceNo"  style="width: 100%">
                                <option value="">Select an Invoice</option>
                               @foreach ($data as $i)
                               <option value="{{ $i->id }}">{{ $i->invoiceNumber }}</option>
                               @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="receiptNo" class="form-label">Receipt No</label>
                            <input type="text" id="receiptNo" name="receiptNo" class="form-control"
                                placeholder="Receipt No" />
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control"
                                placeholder="Enter amount" required />
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" id="description" name="description" class="form-control"
                                placeholder="Optional description" />
                        </div>

                        <div class="mb-3">
                            <label for="Currency" class="form-label">Select Currency</label>
                            <select id="Currency" class="form-select" name="currency" required style="width: 100%">
                                <option value="">Select a customer</option>
                                <option value="LKR">LKR</option>
                                <option value="doller">DOLLAR</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select id="paymentMethod" name="payment_method" class="form-select" required>
                                <option value="">Select a method</option>
                                <option value="Cash">Cash</option>
                                <option value="online_transfer">Bank Transfer</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="date" class="form-label">Payed Date</label>
                            <input type="date" name="date" id="date" value="{{ now()->toDateString() }}"
                                class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="advancePaymentForm">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
   <script>
    $(document).ready(function() {
        $('#customerSelect').select2({
            placeholder: 'Select a customer',
            allowClear: true,
            dropdownParent: $('#advancePaymentModal') // keep it inside modal
        });

        $('#invoiceNo').select2({
            placeholder: 'Select an invoice',
            allowClear: true,
            dropdownParent: $('#advancePaymentModal') // 👈 same fix for invoice
        });
    });
</script>

@endpush
@endsection
