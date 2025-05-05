@extends('sidebar.sub1')

@section('title', 'All Invoices')

@section('link')
    {!! Route('dashboard') !!}
@endsection

@section('icon', 'fa-solid fa-angle-left')

@section('pageTitle', 'All Invoices')
@section('content')


{{-- @section('Ttopic', 'All Invoice') --}}
@section('thead')
    <th class="text-center">ID</th>
    {{-- <th class="text-center">Invoice Number</th> --}}

    <th class="text-center">Company Name</th>
    <th class="text-center">Invoice Number</th>
    <th class="text-center">Action</th>

@endsection

@section('tbody')

    @php $no = 0; @endphp
    @if ($data->count() > 0)
        @foreach ($data as $get)
            @php $no += 1; @endphp
            <tr>
                <td class="text-center">{{ $no }}</td>
                <td class="text-center">{{ $get->companyName }}</td>
                {{-- <td class="text-center">{{ $get->invoiceNumber }}</td> --}}


                <td class="text-center">{{ $get->invoiceNumber }}</td>
                <td class="text-center">
                    @if ($get->offline == 0)


                                <a href="{{ Storage::url('invoices/' . str_replace('/', '-', $get->invoiceNumber) . '.pdf') }}" class="btn btn-sm btn-danger" download title="download"><i class="material-symbols-outlined">download</i></a>
                                <a href="{{ Storage::url('invoices/' . str_replace('/', '-', $get->invoiceNumber) . '.pdf') }}" target="_blank" class="btn btn-sm btn-info" title="preview"><i class="material-symbols-outlined">visibility</i></a>

                    @else
                        <a href="#" class="btn btn-secondary btn-sm align-items-center"><i
                                class="material-symbols-outlined">steppers</i></a>
                    @endif

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
@endsection --}}
@endsection

@endsection
