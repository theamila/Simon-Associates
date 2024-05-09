@extends('sidebar.user2')

@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard')
<style>
    .bg-success-cus {
        background: #7ddd00
    }
</style>

<script src="{{ asset('assets/js/chart.js') }}"></script>

@section('content')



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

@section('f-state', 'Approved Invoices')
@section('s-state', 'Ongoing Invoices')
@section('t-state', 'Outstanding Invoices')

@section('f-state-c', $apr_cnt)
@section('s-state-c', $ong_cnt)
@section('t-state-c', $out_cnt)


@section('Ttopic', 'All Invoices')
@section('thead')
    <th class="text-center">No</th>
    <th class="text-center">Invoice Number</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Address</th>
    <th class="text-center">Progress</th>
    <th class="text-center">Date</th>

@endsection

@php $no = 1; @endphp
@section('tbody')
    @if ($data && $data->count() > 0)
        @foreach ($data as $get)
            <tr>
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
@endsection


@section('BarChart')


    <canvas id="invoiceChart" width="800" height="300" class="mb-2 shadow p-2 border-light"></canvas>

    <script>
        var ctx = document.getElementById('invoiceChart').getContext('2d');
        var invoices = @json($invoices);
        var amountsData = @json($amount);

        var labels = invoices.map(invoice => invoice.invoiceNumber).reverse();
        var amounts = Object.values(amountsData);

        var backgroundColors = [];
        for (var i = 0; i < invoices.length; i++) {
            var r = Math.floor(Math.random() * 150) + 100;
            var g = Math.floor(Math.random() * 150) + 100;
            var b = Math.floor(Math.random() * 150) + 100;
            backgroundColors.push('rgba(' + r + ', ' + g + ', ' + b + ', 0.2)');
        }

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Invoice Amount',
                    data: amounts,
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors.map(color => color.replace('0.2', '1')),
                    borderWidth: 1
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

@section('LineChart')
    <canvas id="lineChart" width="800" height="300" class="mb-2 shadow p-2 bg-light"></canvas>
    <script>
        var ctx = document.getElementById('lineChart').getContext('2d');
        var invoices = @json($invoices);
        var amountsData = @json($amount);

        var labels = invoices.map(invoice => invoice.invoiceNumber).reverse();
        var amounts = Object.values(amountsData);

        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Invoice Amount',
                    data: amounts,
                    fill: false, // Do not fill area under the line
                    borderColor: 'rgba(255, 99, 132, 1)',
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
@endsection
