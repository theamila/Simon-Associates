@extends('sidebar.user2sub1')

@section('title', 'Receipt')

@section('pageTitle', 'Receipt')
@section('content')

@section('Ttopic', 'Receipt')
@section('thead')
    <th class="text-center">No</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Receipt No</th>
    <th class="text-center">Action</th>

@endsection

@section('tbody')
    @php
        $no = 0;
    @endphp

    @if ($invoices->count() > 0)
        @foreach ($invoices as $get)
            @php
                $no += 1;
            @endphp
            <tr>
                <td class="text-center">{{ $no }}</td>
                <td class="text-center">@if (isset($InvoiceData[$get->invoiceNumber]))
                    {{ $InvoiceData[$get->invoiceNumber]->companyName }}
                @else
                    Unknown Company
                @endif</td>
                <td class="text-center">{{ $get->receiptNumber }}</td>
                <td class="text-center">
                    @if ($get->offline == 0)
                        <a href="{{ Storage::url('pdfs/' . $get->receiptNumber . '.pdf') }}" class="btn btn-sm btn-danger"
                            download title="download"><i class="material-symbols-outlined">download</i></a>
                        <a href="{{ Storage::url('pdfs/' . $get->receiptNumber . '.pdf') }}" target="_blank"
                            class="btn btn-sm btn-info" title="preview"><i
                                class="material-symbols-outlined">visibility</i></a>
                    @else
                        <a href="#" class="btn btn-secondary btn-sm align-items-center"><i
                                class="material-symbols-outlined">steppers</i></a>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4" class="text-center fw-bold">
                No Records Found...
            </td>
        </tr>
    @endif

    @endsection
    <div class="d-flex justify-content-center">
        {{ $invoices->links('pagination::bootstrap-4') }}
    </div>
    
{{--
@section('paginate')

    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
                <li class="page-item {{ $data->currentPage() == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $data->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @for ($i = 1; $i <= $data->lastPage(); $i++)
                    <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $data->currentPage() == $data->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@endsection
 --}}

@endsection





{{-- @extends('sidebar.user2sub1')

<style>
    .disabled-link {
        pointer-events: none;
        cursor: not-allowed;
        opacity: 0.6;
    }
</style> --}}
{{--
@section('title', 'Outstanding Invoice')

@section('pageTitle', 'Outstanding Invoice')

@section('content')

@section('Ttopic', 'Outstanding Invoice')
@section('thead')

    <button type="button" class="btn btn-success col-3 float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Custom Receipt
    </button>


    <th class="text-center">No</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Date</th>
    <th class="text-center">Invoice Number</th>
    <th class="text-center">Currency</th> --}}
{{-- <th class="text-center">Duration</th>
    <th class="text-center">Action</th> --}}

{{-- @endsection

@section('tbody')
    @php
        $no = 0;
    @endphp
    @if ($data->count() > 0)
        @foreach ($data as $get)
            @php

                $startDate = strtotime($get->sendDate);
                $currentDate = time();
                $durationInSeconds = $currentDate - $startDate;
                $durationInDays = floor($durationInSeconds / (60 * 60 * 24));

                $invoiceDetails = DB::table('invoice_details')
                    ->where('invoiceNumber', $get->invoiceNumber)
                    ->where('status', 0)
                    ->get();

                $totalPrice = 0;

                $no += 1;
            @endphp

            <tr>
                <td class="text-center">{{ $no }}</td>
                <td class="text-center">{{ $get->companyName }}</td>
                <td class="text-center">{{ $get->sendDate }}</td>
                <td class="text-center">{{ $get->invoiceNumber }}</td>
                <td class="text-center">{{ $get->currency }}</td> --}}



{{--

                <td class="text-center">{{ $durationInDays }}</td>
                @php $invoiceNumber = str_replace("/", "-", $get->invoiceNumber); @endphp
                <td class="text-center d-flex align-items-center justify-content-around">


                    <a href="{{ Storage::url('invoices/' . $invoiceNumber . '.pdf') }}" target="_blank"
                        class="btn btn-sm btn-success me-1">
                        <i class="material-symbols-outlined">visibility</i>
                    </a>


                    <a href="{{ Route('invoiceGenForm', $invoiceNumber) }}" class=" btn btn-sm btn-info me-1">
                        <i class="material-symbols-outlined">edit_square</i>
                    </a>

                    <a href="{{ Route('generateReceiptForm', $get->id) }}" class="btn btn-sm btn-primary">
                        <i class="material-symbols-outlined">navigate_next</i>
                    </a>


                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center fw-bold">
                No Records Found...
            </td>
        </tr>
    @endif


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Modal body content goes here -->
                    @if (!empty($company))
                        <ul>
                            @foreach ($company as $customer)
                                <a href="/cus-receipt/{{ $customer->id }}"
                                    style="font-size: 12pt; text-decoration: none; color: #000;">
                                    <li title="{{ $customer->address }}" class="p-2">
                                        {{ $customer->companyName }}
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@endsection --}}
