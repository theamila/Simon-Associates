@extends('sidebar.sub1')

<style>
    .disabled-link {
        pointer-events: none;
        /* Prevents click events */
        cursor: not-allowed;
        /* Shows a 'not allowed' cursor */
        opacity: 0.6;
        /* Reduces opacity to visually indicate disabled state */
    }
</style>

@section('title', 'Outstanding Invoice')

@section('pageTitle', 'Outstanding Invoice')

@section('content')

@section('Ttopic', 'Outstanding Invoice')




@section('thead')

    {{--
    <button type="button" class="btn btn-success col-3 float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Custom Receipt
    </button> --}}

    <th class="text-center">No</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Date</th>
    <th class="text-center">Invoice Number</th>
    <th class="text-center">Currency</th>
    {{-- <th class="text-center">Total(Rs.)</th> --}}
    <th class="text-center">Duration</th>
    <th class="text-center">Action</th>

@endsection

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
                <td class="text-center">{{ $get->currency }}</td>

                {{-- @if ($invoiceDetails->count() > 0)
                    @foreach ($invoiceDetails as $item)
                      <?php $totalPrice += $item->price * $item->dollerRate; ?>
                    @endforeach
                    <td class="text-center">{{ number_format($totalPrice, 2) }}</td>
                @else
                    <td class="text-center">-</td>
                @endif --}}



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
                    {{-- <a href="{{ Route('re.send', $get->id) }}" title="Re Send"
                        class="btn btn-sm btn-danger me-2 {{ $get->currency == 'USD' ? '' : '' }} ">
                        <i class="material-symbols-outlined">
                            sync
                        </i>
                    </a> --}}

                    @if (auth()->user()->role == 2)
                        <a href="{{ Route('generateReceiptForm', $get->id) }}" class="btn btn-sm btn-primary">
                            <i class="material-symbols-outlined">navigate_next</i>
                        </a>
                    @endif



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


    {{--
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
    </div> --}}

@endsection
@endsection
