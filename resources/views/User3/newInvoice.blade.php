@extends('sidebar.user3sub1')

@section('title', 'Invoice Request')

@section('pageTitle', 'Invoice Request')
@section('content')


@section('Ttopic', 'Invoice Request')
@section('thead')
<th class="text-center">Id</th>
<th class="text-center" style="width: 170px; max-width: 170px;">Invoice Number</th>
<th class="text-center">Company Name</th>
<th class="text-center">Address</th>
<th class="text-center" style="width: 80px;">Action</th>

@endsection
@section('tbody')
@if ($data->count() > 0)
@foreach($data as $get)

<tr>
  <td>{{ $get->id }}</td>
  <td class="text-start">{{ $get->invoiceNumber }}</td>
  <td>{{ $get->companyName }}</td>
  <td>{{ $get->address }}</td>
  <td class="">

    @php
    $invoiceNumber = str_replace('/', '-', $get->invoiceNumber);
    @endphp

    <a href="{{ Route('view-user-3', $invoiceNumber) }}" class="btn btn-sm btn-success">
    <i class="material-symbols-outlined">chevron_right</i>
    </a>
  </td>
</tr>
@endforeach
@else
<tr>
  <td colspan="5" class="text-center fw-bold">
    No Records Found...
  </td>
</tr>
@endif


@endsection
@endsection
