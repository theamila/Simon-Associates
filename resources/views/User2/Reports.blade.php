@extends('sidebar.user2sub2')

@section('title', 'Reports')

<style>
    .bg-cs-success {
        background: rgba(144, 238, 144, 1)
    }
</style>
@section('pageTitle', 'Reports')
@section('content')
    @include('sweetalert::alert')


@section('LineChart')

    <script src="{{ asset('assets/js/chart.js') }}"></script>

    <canvas id="lineChart" width="800" height="300" class="mb-2 shadow mt-2 p-2 bg-light"
        style="border-radius: 10px"></canvas>
    <script>
        var ctx = document.getElementById('lineChart').getContext('2d');
        var invoices = @json($cdata);
        var amountsData = @json($amount);

        var labels = invoices.map(cdata => cdata.invoiceNumber).reverse();
        var amounts = Object.values(amountsData);

        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Invoice Amount',
                    data: amounts,
                    fill: true, // Do not fill area under the line
                    borderColor: '#00c04b',
                    borderWidth: 1.5
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection

@section('serviceBy')

    <div class="row justify-content-center mb-2">
        <div class="col-md-12">
            <div class="card" style="border-radius: 15px">
                <div class="card-body">
                    <h5 class="card-title">Filter Invoices</h5>
                    <form action="{{ Route('filter.invoices') }}" method="GET">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col mb-3">
                                    <label for="customer" class="form-label">Select Customer:</label>
                                    <select id="customer" name="customer" class="form-select">
                                        <option value="0">All</option>
                                        @if ($cudata->count() > 0)
                                            @foreach ($cudata as $uget)
                                                <option value="{{ $uget->id }}"
                                                    {{ $uget->id == $customerID ? 'selected' : '' }}>
                                                    {{ $uget->companyName }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col mb-3">
                                <label for="sdate" class="form-label">Start Date:</label>
                                <input type="date" id="sdate" name="sdate" value="{{ $sdate ? $sdate : '' }}"
                                    class="form-control">
                            </div>
                            <div class="col mb-3">
                                <label for="fdate" class="form-label">End Date:</label>
                                <input type="date" id="fdate" name="fdate" value="{{ $edate ? $edate : '' }}"
                                    class="form-control">
                            </div>
                            <div class="col mb-3">
                                <label for="serviceBy" class="form-label">Service By:</label>
                                <select id="serviceBy" name="serviceBy" class="form-select">
                                    <option value="0">All</option>
                                    @if ($sdata->count() > 0)
                                        @foreach ($sdata as $sget)
                                            <option value="{{ $sget->id }}"
                                                {{ $sget->id == $serviceBy ? 'selected' : '' }}>{{ $sget->name }}</option>
                                        @endforeach
                                    @endif
                                    <!-- Add more options as needed -->
                                </select>

                            </div>
                            <div class="col-md-2 d-flex align-items-center mt-2">
                                <button type="submit" class="btn btn-sm btn-primary">Filter Invoices</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('Ttopic', 'Invoices')
 @section('Table')
    @php $no = 0; @endphp
    <table id="exampleTwo" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Company</th>
                <th class="text-center">Invoice Number</th>
                <th class="text-center">Send Date</th>
                <th class="text-center">Service By</th>
                <th class="text-center">Status</th>
                <th class="text-center">Duration</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->count() > 0)
                @foreach ($data as $get)
                    @php
                        $no += 1;

                        $startDate = strtotime($get->sendDate);
                        $currentDate = time();
                        $durationInSeconds = $currentDate - $startDate;
                        $durationInDays = floor($durationInSeconds / (60 * 60 * 24)); // Moved inside the loop

                        $invoiceDetailsT = DB::table('invoice_details')
                            ->where('invoiceNumber', $get->invoiceNumber)
                            ->get();

                        $totalPrice = 0;

                        foreach ($invoiceDetailsT as $item) {
                            $totalPriceT = $item->price * $item->dollerRate;
                            if ($item->mark_status == 0 && $item->discount != 0) {
                                $totalPriceT -= ($totalPriceT * $item->discount) / 100;
                            }
                            $totalPrice += $totalPriceT;
                        }
                    @endphp
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td class="text-center">{{ $get->companyName }}</td>
                        <td class="text-center">{{ $get->invoiceNumber }}</td>
                        <td class="text-center">{{ $get->sendDate }}</td>
                        <td class="text-center">
                            @foreach ($sdata as $hnd)
                                @if ($get->handleBy == $hnd->id)
                                    {{ $hnd->name }}
                                @endif
                            @endforeach
                        </td>
                        <td class="text-center">
                            @switch($get->status)
                                @case(1)
                                    Recent
                                @break

                                @case(2)
                                @case(3)

                                @case(4)
                                @case(5)

                                @case(6)
                                    Ongoing
                                @break

                                @case(7)
                                    Outstanding
                                @break

                                @default
                                    Completed
                            @endswitch
                        </td>
                        <td class="text-center">{{ $durationInDays }}</td>
                        <td class="text-center">
                            @if ($invoiceDetailsT->count() > 0)
                                {{ number_format($totalPrice, 2) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection



<h2>Outstandings</h2>

@php
    $totals = [
        '0-30' => 0,
        '30-60' => 0,
        '60-90' => 0,
        '90+' => 0,
    ];
@endphp

<div class="table-responsive">
    <table id="aggregatedReport" class="table table-striped table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Invoice Number</th>
                <th>0-30 Days</th>
                <th>30-60 Days</th>
                <th>60-90 Days</th>
                <th>90+ Days</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->count() > 0)
                @foreach ($data as $key => $get)
                    @php
                        $startDate = strtotime($get->sendDate);
                        $currentDate = time();
                        $durationInSeconds = $currentDate - $startDate;
                        $durationInDays = floor($durationInSeconds / (60 * 60 * 24));

                        $invoiceDetailsT = DB::table('invoice_details')
                            ->where('invoiceNumber', $get->invoiceNumber)
                            ->get();

                        $totalPrice = 0;

                        foreach ($invoiceDetailsT as $item) {
                            $totalPriceT = $item->price * $item->dollerRate;
                            if ($item->mark_status == 0 && $item->discount != 0) {
                                $totalPriceT -= ($totalPriceT * $item->discount) / 100;
                            }
                            $totalPrice += $totalPriceT;
                        }

                        $rangeAmounts = [
                            '0-30' => 0,
                            '30-60' => 0,
                            '60-90' => 0,
                            '90+' => 0,
                        ];

                        if ($durationInDays <= 30) {
                            $rangeAmounts['0-30'] = $totalPrice;
                            $totals['0-30'] += $totalPrice;
                        } elseif ($durationInDays <= 60) {
                            $rangeAmounts['30-60'] = $totalPrice;
                            $totals['30-60'] += $totalPrice;
                        } elseif ($durationInDays <= 90) {
                            $rangeAmounts['60-90'] = $totalPrice;
                            $totals['60-90'] += $totalPrice;
                        } else {
                            $rangeAmounts['90+'] = $totalPrice;
                            $totals['90+'] += $totalPrice;
                        }
                    @endphp

                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $get->invoiceNumber }}</td>
                        <td class="text-end">{{ number_format($rangeAmounts['0-30'], 2) }}</td>
                        <td class="text-end">{{ number_format($rangeAmounts['30-60'], 2) }}</td>
                        <td class="text-end">{{ number_format($rangeAmounts['60-90'], 2) }}</td>
                        <td class="text-end">{{ number_format($rangeAmounts['90+'], 2) }}</td>
                    </tr>
                @endforeach

                <tr class="table-secondary">
                    <td colspan="2" class="font-weight-bold text-center">Total</td>
                    <td class="text-end font-weight-bold">{{ number_format($totals['0-30'], 2) }}</td>
                    <td class="text-end font-weight-bold">{{ number_format($totals['30-60'], 2) }}</td>
                    <td class="text-end font-weight-bold">{{ number_format($totals['60-90'], 2) }}</td>
                    <td class="text-end font-weight-bold">{{ number_format($totals['90+'], 2) }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>













@section('firstTable')

    @if (!empty($table2))
        <div class="row">
            <div class="col">
                <a href="/reset/customer" class="btn btn-danger col">Reset</a>
                <a href="/fix/outstanding" target="_blank" class="btn btn-success col">fix outstanding</a>
                <a href="/fix/receipt" target="_blank" class="btn btn-primary col">fix Receipt</a>
            </div>


            <div class="col-12 grid-margin">
                <div class="card shadow" style="border-radius: 15px">
                    <div class="card-body">
                        <h4 class="card-title text-danger">Customers</h4>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th class="text-center">Company Name</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Outstanding</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($table2 as $table)
                                        <tr
                                            style="
                                {{ $table->outstanding == 0
                                    ? 'background: #d1f5d1;'
                                    : ($table->outstanding > 0
                                        ? 'background: #ffffbf;'
                                        : ($table->outstanding < 0
                                            ? 'background: #ffb9b9;'
                                            : '')) }}
                                ">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $table->companyName }}</td>
                                            <td>{{ $table->address }}</td>
                                            <td>{{ $table->outstanding }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modal{{ $loop->iteration }}">
                                                    <span class="material-symbols-outlined"
                                                        style="font-size: 15px;">visibility</span>
                                                </button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modal{{ $loop->iteration }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel{{ $loop->iteration }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="exampleModalLabel{{ $loop->iteration }}">All Invoices
                                                            {{ $table->companyName }}</h5>
                                                        <button type="button" class="close btn btn-sm btn-danger"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        @php
                                                            // $settleData = App\Models\Invoice::where(
                                                            //     'address',
                                                            //     $table->address,
                                                            // )->get();

                                                            $settleData = App\Models\Invoice::where(
                                                                'customerRefId',
                                                                $table->id,
                                                            )->get();

                                                        @endphp
                                                        @if ($settleData)
                                                            <ui>
                                                                @foreach ($settleData as $data)
                                                                    <li>{{ $data->invoiceNumber }}</li>
                                                                @endforeach
                                                            </ui>
                                                        @endif
                                                        <!-- Add more details as necessary -->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif
    <script src="{{ asset('js/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
@endsection
@endsection
