@extends('sidebar.user2sub1')

@section('title', 'Reports')

@section('pageTitle', 'Reports')
<link rel="stylesheet" href="{{ asset('sidebar/css/toggle.css') }}">
<style>
    .disabled-link {
        color: gray;
        text-decoration: none;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>

@section('content')

    @include('sweetalert::alert')

@section('thead')
    <tr>
        <th>No</th>
        <th>Company Name</th>
        <th>Address</th>
        <th>Outstanding</th>
        <th>Action</th>
    </tr>
@endsection

@section('tbody')
    <tbody>
        @php
            $companys = App\Models\CompanyDetails::orderBy('companyName', 'asc')->paginate(25);
        @endphp
        @if (count($companys) > 0)
            @foreach ($companys as $no => $Citem)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $Citem->companyName }}</td>
                    <td>{{ $Citem->address }}</td>
                    <td class="text-end">{{ number_format($Citem->outstanding, 2) }}</td>
                    <td>
                        <a class="btn btn-sm btn-success" target="_blank"  href="/company/history/report/{{$Citem->id}}">
                            <i class="material-symbols-outlined">visibility</i>
                        </a>
                    </td>
                </tr>

                <tr id="invoice{{ $Citem->id }}" class="collapse bg-light">
                    <td colspan="4">
                        <div class="py-2">
                            <table class="table table-bordered">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 20px;">No</th>
                                        <th>Date</th>
                                        <th>Details</th>
                                        <th>Invoices Value</th>
                                        <th>Receipts Value</th>
                                        <th>Net Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $invoice = App\Models\Invoice::where('address', $Citem->address)
                                            ->whereNotIn('status', [1, 9])
                                            ->get();
                                    @endphp

                                    @if (count($invoice) > 0)
                                        @foreach ($invoice as $rkey => $ritem)
                                            <tr>
                                                <td>{{ $rkey }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center fw-bold" colspan="4">No Receipts Found...</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
@endsection


<div class="d-flex justify-content-center">
    {{ $companys->onEachSide(1)->links('pagination::bootstrap-4') }}
</div>
@endsection
