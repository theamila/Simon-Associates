@extends('sidebar.user3sub1')

@section('title', 'Outstanding Invoice')

@section('pageTitle', 'Outstanding Invoice')
@section('content')

@section('Ttopic', 'Outstanding Invoice')
@section('thead')
<th class="text-center">ID</th>
<th class="text-center">Company Name</th>
<th class="text-center">Date</th>
<th class="text-center">Invoice Number</th>
<th class="text-center">Total</th>
<th class="text-center">Duration</th>
<th class="text-center">Action</th>

@endsection

@section('tbody')
@if ($data->count() > 0)
@foreach($data as $get)
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
@endphp

<tr>
    <td class="text-center">{{ $get->id }}</td>
    <td class="text-center">{{ $get->companyName }}</td>
    <td class="text-center">{{ $get->sendDate }}</td>
    <td class="text-center">{{ $get->invoiceNumber }}</td>

    @if ($invoiceDetails->count() > 0)
    @foreach($invoiceDetails as $item)
    <?php $totalPrice += $item->price * $item->dollerRate; ?>
    @endforeach
    <td class="text-center">{{ number_format($totalPrice, 2) }}</td>
    @else
    <td class="text-center">-</td>
    @endif

    <td class="text-center">{{ $durationInDays }}</td>
    <td class="text-center">

    @php
    $invoiceNumber = str_replace('/', '-', $get->invoiceNumber)
    @endphp
    {{-- <a href="{{ asset('pdfs/invoices/' . $invoiceNumber . '.pdf') }}" download="{{ $invoiceNumber . '.pdf' }}" class="btn btn-sm btn-danger align-items-center"><i class="material-symbols-outlined">download</i>PDF</a> --}}

    <a href="{{ Storage::url('invoices/' . $invoiceNumber . '.pdf') }}" class="btn btn-sm btn-danger" download title="download"><i class="material-symbols-outlined">download</i></a>
    <a href="{{ Storage::url('invoices/' . $invoiceNumber . '.pdf') }}" target="_blank" class="btn btn-sm btn-info" title="preview"><i class="material-symbols-outlined">visibility</i></a>

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
@endsection


@endsection
