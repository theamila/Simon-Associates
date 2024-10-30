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
                        <a class="btn btn-sm btn-success" data-bs-toggle="collapse" href="#invoice{{ $Citem->id }}"
                            role="button" aria-expanded="false" aria-controls="invoice{{ $Citem->id }}">
                            <i class="material-symbols-outlined">visibility</i>
                        </a>
                    </td>
                </tr>
                <!-- Collapsible row with nested table for additional details -->
                <tr id="invoice{{ $Citem->id }}" class="collapse bg-light">
                    <td colspan="4">
                        <div class="py-2">
                            <table class="table table-bordered">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 20px;">No</th>
                                        <th>Invoice Number</th>

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
                                                <td>
                                                    {{ $rkey + 1 }}
                                                </td>
                                                <td>
                                                    <a data-bs-toggle="collapse" href="#receiptN{{ $Citem->id }}"
                                                        role="button" aria-expanded="false"
                                                        aria-controls="receiptN{{ $Citem->id }}">{{ $ritem->invoiceNumber }}</a>
                                                </td>
                                            </tr>

                                            <tr id="receiptN{{ $Citem->id }}" class="collapse bg-light">
                                                <td colspan="4">
                                                    <div class="p-3">
                                                        <table class="table table-bordered">
                                                            <thead class="table-secondary">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Receipt Number</th>
                                                                    <th>Additional</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $receipt = App\Models\Modelreceipt::where(
                                                                        'invoiceNumber',
                                                                        $ritem->invoiceNumber,
                                                                    )->get();
                                                                @endphp

                                                                @if (count($receipt) > 0)
                                                                    @foreach ($receipt as $rkey => $ritem)
                                                                        <tr>
                                                                            <td>
                                                                                {{ $rkey + 1 }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $ritem->receiptNumber }}
                                                                            </td>
                                                                            <td>
                                                                                {{ number_format($ritem->additional, 2) }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $ritem->payedDate }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td class="text-center fw-bold" colspan="4">
                                                                            No Receipts Found...</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
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
