@extends('sidebar.main2')

@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Company Registration
                </div>
                <div class="card-body">
                    <form action="{{ Route('RegisterCompanySave') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="company_name" class="form-label">To</label>
                            <input type="text" class="form-control border" id="company_name" placeholder="To" name="to" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="border form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="companyName" class="form-label">Company Name</label>
                            <input type="text" class="border form-control" id="companyName" name="companyName" placeholder="Enter Company Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Address</label>
                            <textarea class="border form-control" id="address" name="address" rows="5" placeholder="Enter Company Address" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection