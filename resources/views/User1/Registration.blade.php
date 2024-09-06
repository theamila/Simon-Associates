@extends('sidebar.register')

@section('title', 'Registration')

@section('pageTitle', 'Company Registration')
@section('content')
    @include('sweetalert::alert')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"></h4>

                <form action="{{ Route('RegisterCompanySave') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="company_name" class="form-label">To</label>
                        <input type="text" class="form-control border" id="company_name" placeholder="To" name="to"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="border form-control" id="email" name="email"
                            placeholder="Enter email" required>
                    </div>

                    <div class="mb-3">
                        <label for="companyName" class="form-label">Company Name</label>
                        <input type="text" class="border form-control" id="companyName" name="companyName"
                            placeholder="Enter Company Name" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="border form-control" id="address" name="address" rows="5" placeholder="Enter Company Address"
                            required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleSelect" class="form-label">Service By :</label>
                        <select class="form-control form-control-sm" id="exampleSelect" name="handlBy">
                            @foreach ($handlers as $handler)
                                <option value="{{ $handler->id }}">{{ $handler->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrapNew.min.js') }}"></script>
    <!-- Bootstrap JS -->



    @php
        $customers = App\Models\CompanyDetails::where('state', true)->get();
    @endphp

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card shadow" style="border-radius: 15px;">
                <div class="card-body">
                    <h4 class="card-title">@yield('Ttopic')</h4>
                    @yield('search')
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">To</th>
                                    <th class="text-center">Emails</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($customers as $cData)
                                    <tr>
                                        <td class="text-center">{{ $cData->to }}</td>
                                        <td class="text-center">{{ $cData->email }}</td>
                                        <td class="text-center">{{ $cData->companyName }}</td>
                                        <td class="text-center">{{ $cData->address }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#updateModal"
                                                data-id="{{ $cData->id }}" data-to="{{ $cData->to }}"
                                                data-email="{{ $cData->email }}"
                                                data-companyname="{{ $cData->companyName }}"
                                                data-address="{{ $cData->address }}"
                                                data-handleby="{{ $cData->handleBy }}">
                                                Update
                                            </button>
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

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Company Details</h5>
                    <button type="button" class="close btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateForm" action="{{ route('update.company') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="companyId" name="id">
                        <div class="form-group">
                            <label for="to">To</label>
                            <input type="text" class="form-control" id="to" name="to" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="companyName">Company Name</label>
                            <input type="text" class="form-control" id="companyName" name="companyName" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        @php
                            $ServiceBy = App\Models\handler::all();
                        @endphp

<div class="form-group">
    <label for="handleBy">Service By</label>
    <select name="handleBy" id="handleBy" class="form-control">
        <option value="">Select Service</option>
        @foreach ($ServiceBy as $service)
            <option value="{{ $service->id }}">{{ $service->name }}</option>
        @endforeach
    </select>
</div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $('#updateModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var to = button.data('to');
            var email = button.data('email');
            var companyName = button.data('companyname');
            var address = button.data('address');
            var handleBy = button.data('handleby'); // Extract handleBy

            var modal = $(this);
            modal.find('.modal-body #companyId').val(id);
            modal.find('.modal-body #to').val(to);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #companyName').val(companyName);
            modal.find('.modal-body #address').val(address);

            // Set the selected option for the handleBy dropdown
            modal.find('.modal-body #handleBy').val(handleBy);
        });
    </script>




@endsection

{{-- <script>
    function disableButton(button) {
        button.classList.add('disabled');
        button.setAttribute('disabled', 'disabled');
    }
</script> --}}
