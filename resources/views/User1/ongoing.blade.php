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
        @foreach($data as $get)
        @php $no += 1; @endphp

        <tr>
            <td class="text-center">{{ $no }}</td>
            <td class="text-center">{{ $get->companyName }}</td>
            <td class="text-center">{{ $get->invoiceNumber }}</td>
            <td class="text-center">
            @php
            $invoiceNumber = str_replace('/', '-', $get->invoiceNumber);
            @endphp

        <a href="{{ Route('modify', $invoiceNumber) }}" class="btn btn-sm btn-success">
        <i class="material-symbols-outlined">
navigate_next
</i>
        </a>
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

@endsection
