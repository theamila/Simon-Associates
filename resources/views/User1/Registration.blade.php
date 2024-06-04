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
                                <input type="text" class="form-control border" id="company_name" placeholder="To"  name="to" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="text" class="border form-control" id="email" name="email" placeholder="Enter email" required>
                            </div>

                            <div class="mb-3">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" class="border form-control" id="companyName" name="companyName" placeholder="Enter Company Name" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="border form-control" id="address" name="address" rows="5" placeholder="Enter Company Address" required></textarea>
                            </div>

                            <div class="mb-3">
                            <label for="exampleSelect" class="form-label">Service By :</label>
                                <select class="form-control form-control-sm" id="exampleSelect" name="handlBy" >
                                    @foreach($handlers as $handler)

                                        <option value="{{ $handler->id }}">{{ $handler->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection

{{-- <script>
    function disableButton(button) {
        button.classList.add('disabled');
        button.setAttribute('disabled', 'disabled');
    }
</script> --}}
