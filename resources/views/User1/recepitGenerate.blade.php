@extends('sidebar.user2sub1')

@section('title', 'Generate Receipt')

@section('pageTitle', 'Generate Receipt')
@section('content')

@include('sweetalert::alert')

@section('Ttopic')
<div class="row text-dark fw-bold" style="font-size: 11pt;">
    <div class="col">
        <span>
            To : {!! $company_data->to . ',' !!} <br>
            {!! $company_data->companyName . ',' !!} <br>
            {!! str_replace(',', ',<br>', $company_data->address) !!} <br>
            {!! str_replace(',', '<br>', $company_data->email) !!}

        </span>
    </div>

</div>

<form method="POST" action="{{ Route('CustomReceipt') }}">
    @php
        $total = 0;
    @endphp
        @csrf
        <div class="row justify-content-end mb-2 mt-4 mr-2">
            <div class="col">
                <select id="payment" name="payment" class="form-select">
                    <option value="online Transfer" selected>Online Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="cheque">Cheque</option>

                </select>
            </div>
            <div class="col">
                <input type="text" name="balance" id="balance" class="form-control" placeholder="Payed amount"
                    required>
                @error('Payment')
                    <span class="text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="col">
                <input type="text" name="additionalcharges" id="balance" class="form-control"
                    placeholder="Additional Costs">
                @error('additionalcharges')
                    <span class="text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="col">
                <input type="text" name="receiptNo" id="receiptNo" class="form-control"
                    placeholder="Receipt No" required>
                @error('receiptNo')
                    <span class="text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-sm btn-success col">Generate a Receipt</button>
        </div>

    @endsection


    @section('thead')
        <th class="text-center"></th>
        <th class="text-center">Invoice Number</th>
        <th class="text-center">Description</th>
        <th class="text-center">Reimbursable</th>
        <th class="text-center">Discount</th>
        <th class="text-center">Price(Rs.)</th>
    @endsection

    @php
        $no = 0;
    @endphp

    @section('tbody')
        @if ($invoice_data->count() > 0)
            @foreach ($invoice_data as $get)
                @if ($get->mark_status == 1)
                    @if ($get->status == 0)
                        @php

                            $no += 1;

                            @endphp
                        <tr class="fw-bold t-4 {{ $get->status == 1 ? 'text-danger' : '' }}">

                            <td style="max-width: 80px; width:80px;" class="text-center">
                                <input type="checkbox" class="m-3 form-check-input" style="width: 20px; height: 20px;"
                                    name="selected_items[]" value="{{ $get->id }}"
                                    {{ $get->status == 1 ? 'disabled' : '' }}>
                            </td>
                            <td class="fw-bold text-center" style="width: 80px;">{{ $get->invoiceNumber }}</td>
                            <td class="fw-bold text-start">{{ $get->description }}</td>
                            <td class="fw-bold text-center fs-3 text-success m-3" style="width: 80px;">

                                <i class="material-symbols-outlined">
                                    {{ $get->Reimbursables == 1 ? 'check_circle' : '' }}</i>
                            </td>
                            <td class="fw-bold text-center" style="width: 80px;">{{ $get->discount . ' %' }}</td>
                            <td style="max-width: 250px; width:200px;" class="text-end">
                                @php
                                    if ($get->currancy == 1) {
                                        $price = $get->price * $get->dollerRate;
                                    } else {
                                        $price = $get->price;
                                    }
                                    $total += $price;
                                @endphp
                                {{ number_format($price, 2) }}

                            </td>
                    @endif
                @endif
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-center">Total</td>
                <td class="text-end fw-bold">{{ number_format($total, 2) }}</td>
                <td></td>
            </tr>
        @else
            <tr>
                <td colspan="6" class="text-center fw-bold">
                    No Records Found...
                </td>
            </tr>
        @endif

        <input type="hidden" name="invoiceNumber" value="{{ $get->invoiceNumber }}">
    </form>

@endsection
@endsection
