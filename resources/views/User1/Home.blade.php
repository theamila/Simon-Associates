@extends('sidebar.user1')

@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard')

@section('content')

@section('f-state', 'Approved Invoices')

@section('f-state-c', $apr_cnt)
@section('s-state-c', $ong_cnt)
@section('t-state-c', $out_cnt)

@section('f-icon')
    <i class="material-symbols-outlined mdi-24px float-right">order_approve</i>
@endsection

@section('s-icon')
    <i class="material-symbols-outlined mdi-24px float-right">
        hourglass_top
    </i>
@endsection

@section('t-icon')
    <i class="material-symbols-outlined mdi-24px float-right">
        schedule
    </i>
@endsection

@section('s-state', 'Ongoing Invoices')
@section('t-state', 'Outstanding Invoices')

@section('Recent')

    @if ($recent->count() > 0)

        @php
            $no = 0;
        @endphp
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card shadow" style="border-radius: 15px;">
                    <div class="card-body">
                        <h4 class="card-title">Recent Invoices</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th class="text-center">
                                            Invoice Number
                                        </th>
                                        <th class="text-center">
                                            Company Name
                                        </th>
                                        <th class="text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recent as $get)
                                        @php
                                            $no += 1;
                                        @endphp
                                        <tr>
                                            <td class="text-center">
                                                {{ $no }}
                                            </td>
                                            <td class="text-center">{{ $get->invoiceNumber }}</td>
                                            <td class="text-center">{{ $get->companyName }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('recent.home', str_replace('/', '-', $get->invoiceNumber)) }}"
                                                    class="btn btn-sm btn-inverse-success">
                                                    <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@php $no = 1; @endphp

@section('Ttopic', 'All Invoices')
@section('thead')
    <th class="text-center">No</th>
    <th class="text-center">Invoice Number</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Address</th>
    <th class="text-center">Progress</th>
    <th class="text-center">Date</th>

@endsection
@section('tbody')
    @if ($data->count() > 0)
        @foreach ($data as $get)
            <tr style="padding: 10px;">
                <td class="text-center">{{ $no }}</td>
                <td class="text-center">{{ $get->invoiceNumber }}</td>
                <td class="text-center">{{ $get->companyName }}</td>
                <td>{{ $get->address }}</td>
                <td>
                    <div class="progress">
                        <div class="progress-bar

                        @php
                        $no += 1;
switch ($get->status) {
                        case 1:
                            echo 'bg-gradient-secondary';
                            break;
                        case 2:
                            echo 'bg-gradient-warning';
                            break;
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                            echo 'bg-gradient-primary';
                            break;
                        case 7:
                            echo 'bg-gradient-danger';
                            break;
                        default:
                            echo 'bg-gradient-success';
                    } @endphp

                "
                            role="progressbar"
                            style="width:
                            @php
switch ($get->status) {
                    case 1:
                        echo '10%';
                        break;
                    case 2:
                        echo '25%';
                        break;
                    case 3:
                    echo '40%';
                        break;
                    case 4:
                    echo '53%';
                        break;
                    case 5:
                    echo '60%';
                        break;
                    case 6:
                        echo '70%';
                        break;
                    case 7:
                        echo '90%';
                        break;
                    default:
                        echo '100%';
                } @endphp">
                        </div>
                </td>
                <td class="text-center">{{ $get->date }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">No Data Found...</td>
        </tr>
    @endif


@endsection
@endsection
