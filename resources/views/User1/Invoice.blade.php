@if (Auth::user()->roleName() == 'User')
    @extends('sidebar.user2sub1')
@else
    {{-- @extends('sidebar.sub1') --}}
@endif

@section('title', 'Send Invoioce')


@section('pageTitle', 'Send Invoioce')
@section('content')

    @include('sweetalert::alert')

@section('Ttopic')
    <div class="row d-flex justify-content-between text-dark fw-bold" style="font-size: 10pt;">
        <div class="col">
            <span>
                To : {!! $company_data->to . ',' !!} <br>
                {!! $company_data->companyName . ',' !!} <br>
                {!! str_replace(',', ',<br>', $company_data->address) !!} <br>

                <span class="text-danger">
                    Invoice No : {{ $invoiceNumber }}
                </span>
            </span>
        </div>


        <form action="{{ Route('lastGenerate') }}" method="post">
            @csrf

    </div>

    @php
        $invoiceTotal = 0;
        $Total = 0;

        $id_array = [];
    @endphp

    @csrf

    <div class="row mb-3 mt-3 d-flex justify-content-end">
        @php
            $invoiceNumber = str_replace('-', '/', $invoiceNumber);
        @endphp
        <div class="col">
            <select id="currency" name="currency" class="form-select">
                <option value="LKR" selected>Sri Lanka Rupees (LKR)</option>
                <option value="USD">Dollar (USD)</option>
            </select>
        </div>
        <div class="col">
            <input type="number" id="dollarRate" name="dollarRate" class="form-control" step="0.01"
                placeholder="Enter dollar rate" value="1.0" title="Doller Rate">
        </div>
        <div class="col">
            <input type="date" id="date" name="date" class="form-control" value="{{ date('Y-m-d') }}"
                title="Date">
        </div>

        <input type="hidden" name="invoiceNo" value="{{ $invoiceNumber }}">

        <div class="col">
            <input type="submit" value="Generate Invoice" class="btn btn-primary form-control text-light">
        </div>
    </div>





@endsection
@php $no = 0; @endphp
@section('thead')
    <th class="text-center">No</th>
    <th class="text-center">Description</th>
    <th class="text-center">Reimbursable</th>
    <th class="text-center">Price</th>
@endsection

@section('tbody')

    @if ($invoice_data->count() > 0)
        @foreach ($invoice_data as $get)
            @php

                $price = $get->price - $get->price * ($get->discount / 100);

                array_push($id_array, $get->id);

                if ($get->Reimbursables == '0') {
                    $invoiceTotal += $price;
                }
                $Total += $price;
                $no += 1;
            @endphp


            <tr class="fw-bold">
                <td class="fw-bold text-center" style="width: 80px;">{{ $no }}</td>
                <td class="fw-bold text-start">{{ $get->description }}</td>
                <td class="fw-bold text-center fs-3 text-dark" style="width: 80px;"><i
                        class="{{ $get->Reimbursables == 1 ? 'fas fa-registered' : '' }}"></i>
                </td>

                <td style="max-width: 250px; width:200px;" class="text-end">

                    {{ number_format($price, 2) }}

                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3" class="text-center fw-bold">
                No Records Found...
            </td>
        </tr>
    @endif

@endsection

<div class="row mb-3 mt-2 text-dark" style="font-size: 12pt;">
    <div class="row d-flex justify-content-around text-center text-success fw-bold">
        <div class="col">{{ number_format($invoiceTotal, 2) }}</div>
        <div class="col">{{ number_format($Total, 2) }}</div>
    </div>
    <div class="row d-flex justify-content-around text-danger text-center fw-bold">
        <div class="col">Invoice Total Price</div>
        <div class="col">Total Price</div>
    </div>
</div>

<input type="hidden" name="id_array" Value="{{ json_encode($id_array) }}">

</form>
@endsection
