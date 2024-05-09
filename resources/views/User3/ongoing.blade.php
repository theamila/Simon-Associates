@extends('sidebar.user3sub1')

@section('title', 'Ongoing Invoice')

@section('link')
{!! Route("dashboard-user-2") !!}
@endsection

@section('icon', 'fa-solid fa-angle-left')

@section('pageTitle', 'New Invoice')
@section('content')


<div class="container mt-4">

  <table class="table table-dark table-striped table-hover table-bordered rounded">
    <thead>
      <tr>
        <th scope="col" class="text-center" style="width: 50px;">Id</th>
        <th scope="col" class="text-center" style="width: 170px; max-width: 170px;">Invoice Number</th>
        <th scope="col" class="text-center">Company Name</th>
        <th scope="col" class="text-center">Address</th>
        <th scope="col" class="text-center" style="width: 50px;">Action</th>
      </tr>
    </thead>
    <tbody>

      @if ($data->count() > 0)
      @foreach($data as $get)

      <tr>
        <td class="text-center">{{ $get->id }}</td>
        <td class="text-start">{{ $get->invoiceNumber }}</td>
        <td>{{ $get->companyName }}</td>
        <td>{{ $get->address }}</td>
        <td class="">


          <a href="{{ Route('generateInvoice', $get->id) }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </td>
      </tr>
      @endforeach
      @else
      <tr>
        <td colspan="4" class="text-center fw-bold">
          No Records Found...
        </td>
      </tr>
      @endif

    </tbody>
  </table>
</div>



@endsection