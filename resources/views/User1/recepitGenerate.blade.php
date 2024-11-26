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
                <input type="number" name="balance" id="balance" class="form-control" placeholder="Payed amount"
                    step="0.01" required>

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
                <input type="text" name="receiptNo" id="receiptNo" class="form-control" placeholder="Receipt No"
                    required>
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
        <th class="text-center">Price (Rs.)</th>
    @endsection

    @php
        $no = 0;
        $total = 0;
    @endphp

    @section('tbody')
        @if ($invoice_data->isNotEmpty())
            @foreach ($invoice_data as $item)
                @if ($item->mark_status == 1 && $item->status == 0)
                    @php
                        $no++;
                        $price = $item->currancy == 1 ? $item->price * $item->dollerRate : $item->price;
                        $total += $price;
                    @endphp
                    <tr class="fw-bold t-4 {{ $item->status == 1 ? 'text-danger' : '' }}">
                        <td class="text-center" style="max-width: 80px;">
                            <input type="checkbox" class="m-3 form-check-input" style="width: 20px; height: 20px;"
                                name="selected_items[]" value="{{ $item->id }}"
                                {{ $item->status == 1 ? 'disabled' : '' }}>
                        </td>
                        <td class="fw-bold text-center" style="width: 80px;">{{ $item->invoiceNumber }}</td>
                        <td class="fw-bold text-start">{{ $item->description }}</td>
                        <td class="fw-bold text-center fs-3 text-success m-3" style="width: 80px;">
                            <i class="material-symbols-outlined">
                                {{ $item->Reimbursables == 1 ? 'check_circle' : '' }}
                            </i>
                        </td>
                        <td class="fw-bold text-center" style="width: 80px;">{{ $item->discount }}%</td>
                        <td class="text-end" style="max-width: 250px; width: 200px;">
                            {{ number_format($price, 2) }}
                        </td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="5" class="text-center fw-bold">Total</td>
                <td class="text-end fw-bold">{{ number_format($total, 2) }}</td>
            </tr>
        @else
            <tr>
                <td colspan="6" class="text-center fw-bold">No Records Found...</td>
            </tr>
        @endif

        <!-- Hidden input to store invoice number -->
        <input type="hidden" name="invoiceNumber" value="{{ $invoiceNumber }}">
    @endsection
@endsection
