@extends('sidebar.user1')

@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard')

@section('content')
@include('sweetalert::alert')

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
                                                <a href="#" class="btn btn-sm btn-inverse-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-id="{{ $get->id }}">
                                                    <i class="material-symbols-outlined">delete</i>
                                                </a>
                                                <a href="{{ route('recent.home', str_replace('/', '-', $get->invoiceNumber)) }}"
                                                    class="btn btn-sm btn-inverse-success">
                                                    <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                </a>

{{-- ------------------------ Delete confimation modal --------------------------------- --}}

<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger" id="confirmDeleteButton">Delete</a>
            </div>
        </div>
    </div>
</div>



{{-- ------------------------ Delete confimation modal --------------------------------- --}}
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        var confirmDeleteButton = document.getElementById('confirmDeleteButton');

        deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var id = button.getAttribute('data-id'); // Extract info from data-* attributes

            // Update the delete link with the correct ID
            confirmDeleteButton.href = '{{ route("recent.delete", "") }}/' + id;
        });
    });
    </script>
