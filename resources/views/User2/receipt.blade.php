@extends('sidebar.user2sub1')

@section('title', 'Receipt')

@section('pageTitle', 'Receipt')
@section('content')
@include('sweetalert::alert')

@section('Ttopic', 'Receipt')
@section('thead')
    <th class="text-center">No</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Receipt No</th>
    <th class="text-center">Action</th>

@endsection

@section('tbody')
    @php
        $no = 0;
        $invoices = App\Models\Modelreceipt::orderBy('id', 'desc')->get();
    @endphp

    @if ($invoices->count() > 0)
        @foreach ($invoices as $get)
            @php
                $no += 1;
            @endphp
            <tr>
                <td class="text-center">{{ $no }}</td>


                <td class="text-center">
                    @php
                        $company = App\Models\Invoice::where('invoiceNumber', $get->invoiceNumber)->first();
                        // dd($company);
                    @endphp


                    {{ $company->companyName }}
                </td>
                <td class="text-center">{{ $get->receiptNumber }}</td>
                <td class="text-center">
                    @if ($get->offline == 0)
                        <a href="{{ Storage::url('pdfs/' . $get->receiptNumber . '.pdf') }}" class="btn btn-sm btn-success"
                            download title="download"><i class="material-symbols-outlined">download</i></a>
                        <a href="{{ Storage::url('pdfs/' . $get->receiptNumber . '.pdf') }}" target="_blank"
                            class="btn btn-sm btn-info" title="preview"><i
                                class="material-symbols-outlined">visibility</i></a>

                                <a href="/delete/receipt/{{$get->id}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this receipt? This action cannot be undone.')">
                                    <i class="material-symbols-outlined">delete</i>
                                </a>
                    @else
                        <a href="#" class="btn btn-secondary btn-sm align-items-center"><i
                                class="material-symbols-outlined">steppers</i></a>
                    @endif
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
{{-- <div class="d-flex justify-content-center">
    {{ $invoices->links('pagination::bootstrap-4') }}
</div> --}}



@endsection



