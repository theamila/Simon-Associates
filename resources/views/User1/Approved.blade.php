@extends('sidebar.sub1')

@section('title', 'Approved Invoice')

@section('pageTitle', 'Approved Invoice')
@section('content')


@section('Ttopic', 'Approved Invoice')
@section('thead')
    <th class="text-center">ID</th>
    <th class="text-center">Invoice Number</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Address</th>
    <th class="text-center">Action</th>

@endsection

@section('tbody')
    @if ($data->count() > 0)
        @foreach ($data as $get)
            <tr>
                <td class="text-center">{{ $get->id }}</td>
                <td class="text-start">{{ $get->invoiceNumber }}</td>
                <td>{{ $get->companyName }}</td>
                <td>{{ $get->address }}</td>
                <td class="text-center">


                    <a href="{{ Route('generate-Invoice', $get->id) }}" class="btn btn-sm btn-success">
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
