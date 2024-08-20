@extends('sidebar.user2sub1')

@section('title', 'View Invoice')


@section('pageTitle', 'View Invoice')
<link rel="stylesheet" href="{{ asset('sidebar/css/toggle.css') }}">
@section('content')

    @php
        $issu_count = 0;
        $no = 1;
    @endphp

@section('custom')

@endsection

@section('thead')
    <th class="fw-bold text-center">No</th>
    <th class="fw-bold text-center">Description</th>
    <th class="fw-bold text-center">Reimbursable</th>
    <th class="fw-bold text-center">Discount</th>
    <th class="fw-bold text-center">Price</th>


@endsection
@section('tbody')
    @if ($data->count() > 0)
        @foreach ($data as $get)
            <tr>

                <td class="fw-bold text-center" style="width: 80px;">{{ $no }}</td>
                <td class="fw-bold text-start">{{ $get->description }}</td>
                <td class="fw-bold text-center fs-3 text-dark" style="width: 80px;">
                    <i
                        class="material-symbols-outlined text-success">{{ $get->Reimbursables == 1 ? 'check_circle' : '' }}</i>

                </td>


                <td class="fw-bold text-center" style="width: 80px;">{{ $get->discount . ' %' }}</td>
                <td style="max-width: 250px; width:200px;" class="text-end">
                    @php
                        $no += 1;
                        $price = $get->price - $get->price * ($get->discount / 100);
                    @endphp
                    <span class="text-danger">
                        {{ number_format($get->price, 2) }}
                    </span><br>
                    <span class="fw-bold" style="font-size: 12pt;">
                        {{ number_format($price, 2) }}
                    </span>
                </td>
            </tr>

            @if ($get->remark != '')
                @php
                    $issu_count += 1;
                @endphp
                <tr class="table-warning">
                    <td colspan="5" class="text-center">
                        {{ $get->remark }}
                    </td>
                    <td class="text-center">
                        <a href="{{ Route('fixed', $get->id) }}" class="btn btn-sm btn-success rounded float-end"
                            style="display: flex; align-items: center; width: 100px;">
                            <i class="material-symbols-outlined " style="margin-right: 5px;">check_circle</i>
                            <span>Fixed</span>
                        </a>
                    </td>
            @endif

            <!-- =============================================================================== -->


            <!-- ============================================================================== -->
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center fw-bold">
                No Records Found...
            </td>
        </tr>
    @endif
@endsection

</div>

@endsection
