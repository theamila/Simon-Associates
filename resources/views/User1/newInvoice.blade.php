@extends('sidebar.sub1')

@section('title', 'New Invoice')

@section('pageTitle', 'New Invoice')
@section('content')
    @include('sweetalert::alert')

@section('Ttopic', 'New Invoice')
@section('search')
    <form action="{{ Route('search.customer') }}" method="get">

        <div class="row">
            <div class="col d-flex flex-inline">
                <input type="text" name="name" class="form-control" placeholder="Customer Name..."
                    value="{{ $name }}" required>
                <input type="submit" value="Search" class="btn btn-sm btn-danger">
            </div>
        </div>
    </form>
@endsection
@section('thead')
    <th class="text-center">ID</th>
    <th class="text-center">Company Name</th>
    <th class="text-center">Address</th>
    <th class="text-center">Action</th>

@endsection
@section('tbody')
    @php $no =0; @endphp
    @if ($data->count() > 0)
        @foreach ($data as $get)
            @php $no += 1; @endphp
            <tr>
                <td class="text-center">{{ $no }}</td>
                <td class="text-center">{{ $get->companyName }}</td>
                <td>{{ $get->address }}</td>
                <td class="text-center">

                    <a href="{{ Route('generateInvoice', $get->id) }}" class="btn btn-sm btn-success"
                        onclick="disableButton(this)">
                        <i class="material-symbols-outlined">
                            navigate_next
                        </i>
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
@endsection

@endsection

<script>
    function disableButton(button) {
        button.classList.add('disabled');
        button.setAttribute('disabled', 'disabled');
    }
</script>
