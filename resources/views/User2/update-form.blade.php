@extends('sidebar.user2sub1')

@section('title', 'Settings')

@section('pageTitle', 'Settings')
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



@section('Ttopic')
    <button type="button" class="btn btn-outline-success btn-icon-text" data-bs-toggle="modal" data-bs-target="#addBankModal">
        <i class="material-symbols-outlined btn-icon-prepend">account_balance</i> Add a Bank Account
    </button>
@endsection

@section('thead')
    <th class="text-center">Id</th>
    <th class="text-center">A/C Name</th>
    <th class="text-center">Bank Name</th>
    <th class="text-center">Account Number</th>
    <th style="width: 120px;" class="text-center">Action</th>
@endsection

@section('tbody')

    @if ($data->count() > 0)
        @foreach ($data as $get)
            <tr>
                <td class="text-center">{{ $get->id }}</td>
                <td class="text-center">{{ $get->acName }}</td>
                <td class="text-center">{{ $get->bankName }}</td>
                <td class="text-center">{{ $get->accountNo }}</td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#updateModal{{ $get->id }}"><i
                            class="material-symbols-outlined">edit_square</i></a>

                    <a href="{{ Route('pin', $get->id) }}"
                        class="btn btn-sm {{ $get->default == 0 ? 'btn-success' : 'btn-danger disabled' }}"
                        title="Set To Default">

                        <i class="material-symbols-outlined">keep</i>

                    </a>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="updateModal{{ $get->id }}" tabindex="-1" aria-labelledby="updateModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateModalLabel">Update Form</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ Route('updatedata') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="acName" class="form-label">A/C Name</label>
                                    <input type="text" class="form-control border" id="acName" name="acName"
                                        value="{{ $get->acName }}">
                                </div>
                                <div class="mb-3">
                                    <label for="accountNo" class="form-label">Account No</label>
                                    <input type="text" class="form-control border" id="accountNo" name="accountNo"
                                        value="{{ $get->accountNo }}">
                                </div>
                                <div class="mb-3">
                                    <label for="bankName" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control border" id="bankName" name="bankName"
                                        value="{{ $get->bankName }}">
                                </div>
                                <div class="mb-3">
                                    <label for="bankAddress" class="form-label">Bank Address</label>
                                    <textarea class="form-control border" id="bankAddress" name="bankAddress" rows="3">{{ $get->bankAddress }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="swiftCode" class="form-label">Swift Code</label>
                                    <input type="text" class="form-control border" id="swiftCode" name="swiftCode"
                                        value="{{ $get->swiftCode }}">
                                </div>

                                <input type="hidden" name="id" value="{{ $get->id }}">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-center">No Data Found</td>
        </tr>
    @endif


@endsection


<div class="row">
    <div class="col-12 grid-margin">
        <div class="card shadow" style="border-radius: 15px">
            <div class="card-body">
                <h4 class="card-title">Customers List
                </h4>
                <div class="table-responsive">
                    <table class="table" id="customersTable">

                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($customersList) > 0)
                                @foreach ($customersList as $get)
                                    <tr>
                                        <td class="text-center">
                                            {{ $get->id }}
                                        </td>
                                        <td class="text-center">
                                            {{ $get->companyName }}
                                        </td>
                                        <td class="text-center">
                                            {{ $get->email }}
                                        </td>
                                        <td class="text-center">
                                            {{ $get->phone }}
                                        </td>
                                        <td class="text-center">
                                            {{ $get->address }}
                                        </td>
                                        <td class="text-center">
                                            @if ($get->state)
                                                <a href="{{ route('customer.off', $get->id) }}"
                                                    class="btn btn-inverse-success fs-4">
                                                    <i class="material-symbols-outlined">toggle_on</i>
                                                </a>
                                            @else
                                                <a href="{{ route('customer.on', $get->id) }}"
                                                    class="btn btn-inverse-danger">
                                                    <i class="material-symbols-outlined fs-4">toggle_off</i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>



<div class="modal fade" id="addBankModal" tabindex="-1" aria-labelledby="addBankModalLabel" aria-hidden="true">
    <!-- Modal content for adding new bank details -->
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBankModalLabel">Add New Bank Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add.bank') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="acName" class="form-label">A/C Name</label>
                        <input type="text" class="form-control border" id="acName" name="acName"
                            value="">
                    </div>
                    <div class="mb-3">
                        <label for="accountNo" class="form-label">Account No</label>
                        <input type="text" class="form-control border" id="accountNo" name="accountNo"
                            value="">
                    </div>
                    <div class="mb-3">
                        <label for="bankName" class="form-label">Bank Name</label>
                        <input type="text" class="form-control border" id="bankName" name="bankName"
                            value="">
                    </div>
                    <div class="mb-3">
                        <label for="bankAddress" class="form-label">Bank Address</label>
                        <textarea class="form-control border" id="bankAddress" name="bankAddress" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="swiftCode" class="form-label">Swift Code</label>
                        <input type="text" class="form-control border" id="swiftCode" name="swiftCode"
                            value="">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12 grid-margin">
        <div class="card shadow" style="border-radius: 15px">
            <div class="card-body">
                <h4 class="card-title">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#addUserModal"><i
                            class="material-symbols-outlined btn-icon-prepend">person_add</i> Add a User</button>
                </h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">User Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($userData) > 0)
                                @foreach ($userData as $get)
                                    <tr>
                                        <td class="text-center">
                                            {{ $get->id }}
                                        </td>
                                        <td class="text-center">
                                            {{ $get->name }}
                                        </td>
                                        <td>
                                            {{ $get->email }}
                                        </td>
                                        <td class="text-center">
                                            {{ $get->roleName() }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- User Model -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Register User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nameModal" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailModal" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="roleModal" name="role">
                            <option value="{{ \App\Models\User::ROLE_USER }}">User</option>
                            <option value="{{ \App\Models\User::ROLE_FINANCE }}">Finance</option>
                            <option value="{{ \App\Models\User::ROLE_APPROVER }}">Approver</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="passwordModal" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="passwordConfirmationModal"
                            name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-12 grid-margin">
        <div class="card shadow" style="border-radius: 15px">
            <div class="card-body">
                <h4 class="card-title">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#HandlerModal"><i
                            class="material-symbols-outlined btn-icon-prepend">person_add</i> Add a Handler</button>
                </h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">User Name</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($handlerData) > 0)
                                @foreach ($handlerData as $get)
                                    <tr>
                                        <td class="text-center">
                                            {{ $get->id }}
                                        </td>
                                        <td class="text-center">
                                            {{ $get->name }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="HandlerModal" tabindex="-1" aria-labelledby="HandlerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add a Handler</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm" method="POST" action="{{ route('handler.add') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nameModal" name="name" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- =======================new bank====================== -->
<!-- Modal content for adding new bank details -->




<script>
    $(document).ready(function() {
        $('#customersTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 100],
            "ordering": true,
            "searching": true,
            "autoWidth": true,
            "language": {
                "search": "Search Customers:",
                "lengthMenu": "Show _MENU_ entries"
            }
        });
    });
</script>

@endsection
