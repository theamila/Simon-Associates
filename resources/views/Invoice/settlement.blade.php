@extends('sidebar.sub1')

@section('title', 'Generate Receipt')

@section('pageTitle', 'Generate Receipt')
@section('content')

    @include('sweetalert::alert')

@section('thead')
    <div class="row">
        <div class="col">
            <span class="text-danger fw-bold mb-2">
                payment = {{ number_format($payment, 2) }}
            </span>
        </div>
        <div class="col">
            <span class="text-danger fw-bold mb-2">
                Total = {{ number_format($total, 2) }}
            </span>
        </div>
        <div class="col">
            <span class="text-danger fw-bold mb-2">
                Balance = {{ number_format($payment - $total, 2) }}
            </span>
        </div>

        <div class="col">
            <button type="submit" class="btn btn-primary float-end" id="submitBtn">Receipt</button>

        </div>
    </div>
    <th class="text-center">No</th>
    <th class="text-center">Invoice Number</th>
    <th class="text-center">Description</th>
    <th class="text-center" style="width: 20px;"></th>
    <th class="text-center">Price(Rs.)</th>
@endsection

@php
    $no = 0;
    $total = 0.0;
    $invo_list = [];
@endphp

@section('tbody')
    @if ($invoice_data->count() > 0)
        @foreach ($invoice_data as $get)
            @if (!in_array($get->invoiceNumber, $invo_list))
                @php
                    $no += 1;
                    $invo_list[] = $get->invoiceNumber;
                @endphp
                    <tr class="fw-bold t-4">
                        <td class="fw-bold text-center" style="width: 80px;">{{ $no }}</td>
                        <td class="fw-bold text-center" style="width: 80px;">{{ $get->invoiceNumber }}</td>
                        <td class="fw-bold text-start">
                            <form action="{{ route('receipt.settlement') }}" method="post">
                                @csrf
                            <input type="text" name="description" id="description" placeholder="Description"
                                class="w-100 form-control" style="border: 1px solid #000;">
                        </td>
                        <td>
                            <input type="hidden" name="id" value="{{ $get->id }}">
                            <input type="submit" value="save" class="btn btn-sm btn-danger">
                </form>
                </td>
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
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center fw-bold">
                No Records Found...
            </td>
        </tr>
    @endif



@endsection

@endsection
