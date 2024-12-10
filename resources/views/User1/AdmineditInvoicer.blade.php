@extends('sidebar.user2sub1')
{{-- @extends('sidebar.sub1') --}}

@section('title', 'Finalizing Invoice')


@section('pageTitle', 'Finalizing Invoice')
<link rel="stylesheet" href="{{ asset('sidebar/css/toggle.css') }}">
@section('content')

    @php
        $issu_count = 0;
        $no = 1;
    @endphp

@section('custom')
    <div class="container">
        <div class="row p-2 m-2">
            <form action="{{ Route('change.bank') }}" method="get">
                <div class="row align-items-center">
                    <div class="col">
                        <select id="bank" name="Selectbank" class="form-select">
                            @foreach ($bank as $get)
                                <option value="{{ $get->id }}" {{ $invoice->bankId == $get->id ? 'selected' : '' }}>
                                    {{ $get->accountNo }}
                                </option>
                            @endforeach
                        </select>

                        <input type="hidden" name="invoiceNumber" value="{{ $invoice->invoiceNumber }}">
                    </div>
                    <div class="col-2">
                        <input type="submit" value="Change" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('thead')
    <th class="fw-bold text-center">No</th>
    <th class="fw-bold text-center">Description</th>
    <th class="fw-bold text-center">Reimbursable</th>
    {{-- <th class="fw-bold text-center">Discount</th> --}}
    <th class="fw-bold text-center">Price</th>
    @if ($invoice->status != 7)
        <th class="fw-bold text-center">Action</th>
    @endif

@endsection
@section('tbody')
    @if ($invoice_data->count() > 0)
        @php
            $invoicePrice = 0.0;
            $totalPrice = 0.0;
        @endphp
        @foreach ($invoice_data as $get)
            <tr>

                <td class="fw-bold text-center" style="width: 80px;">{{ $no }}</td>
                <td class="fw-bold text-start">{{ $get->description }}</td>
                <td class="fw-bold text-center fs-3 text-dark" style="width: 80px;">
                    <i
                        class="material-symbols-outlined text-success">{{ $get->Reimbursables == 1 ? 'check_circle' : '' }}</i>

                </td>


                {{-- <td class="fw-bold text-center" style="width: 80px;">{{ $get->discount . ' %' }}</td> --}}
                <td style="max-width: 250px; width:200px;" class="text-end">
                    @php
                        $no += 1;
                        $price = $get->price - $get->price * ($get->discount / 100);

                        $totalPrice += $price;

                        if (!$get->Reimbursables == 1) {
                            $invoicePrice += $price;
                        }

                    @endphp
                    {{-- <span class="text-danger">
                        {{ number_format($get->price, 2) }}
                    </span><br> --}}
                    <span class="fw-bold" style="font-size: 12pt;">
                        {{ number_format($price, 2) }}
                    </span>
                </td>
                @if ($invoice->status != 7)
                    <td style="max-width: 150px; width:150px;" class="text-end">

                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal{{ $get->id }}">
                            <i class="material-symbols-outlined">edit_square</i>
                        </button>

                        <a onclick="return confirm('Are you sure you want to delete this invoice Data?')"
                            href="{{ route('deleteInvoiceData', $get->id) }}" class="btn btn-sm btn-danger rounded">
                            <i class="material-symbols-outlined">delete</i>
                        </a>

                    </td>
                @endif
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
            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{ $get->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Invoice Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form action="{{ route('invoiceEditDataSave', ['id' => $get->id]) }}" method="post">

                                @csrf
                                <div class="mb-3">
                                    <label for="description" class="form-label text-dark fw-bold">Description</label>
                                    <textarea class="form-control border" id="description" name="description" placeholder="Enter description" rows="5"
                                        required>{{ $get->description }}</textarea>
                                    @error('description')
                                        <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label text-dark fw-bold">Price</label>
                                    <input type="text" class="form-control border" id="price" name="price"
                                        placeholder="Enter price" value='{{ $get->price }}' required>
                                    @error('price')
                                        <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="discount" class="form-label text-dark fw-bold">Discount %</label>
                                    <input type="text" class="form-control border" id="discount" name="discount"
                                        placeholder="Enter Discount" value="{{ $get->discount }}" required>
                                    @error('discount')
                                        <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 d-flex align-items-start justify-content-start">
                                    <span class="fw-bold text-dark mr-3">Reimbursable</span>
                                    <label class="csswitch" for="toggle">
                                        <input type="checkbox" style="width: 20px; height: 20px; margin-left: 10px;"
                                            name="cstoggle" {{ $get->Reimbursables === '1' ? 'checked' : '' }}>
                                    </label>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        @php
                            $invoiceNumber = str_replace('-', '/', $invoiceNumber);
                        @endphp
                        <input type="hidden" name="invoiceNumber" value="{{ $invoiceNumber }}">
                        </form>
                    </div>
                </div>
            </div>

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

<div class="d-flex mb-3" style="justify-content: space-around;">
    <span class="text-danger fw-bold">Invoce Amount - <span
            class="text-success fw-bold">{{ number_format($invoicePrice, 2) }}</span></span>
    <span class="text-danger fw-bold">Total Amount - <span
            class="text-success fw-bold">{{ number_format($totalPrice, 2) }}</span></span>
</div>

@php
    $invoiceNumber = str_replace('/', '-', $invoiceNumber);
@endphp


@if ($issu_count == 0 && $invoice->status == 4)
    <a href="{{ Route('send-invoice', $invoiceNumber) }} " class="btn btn-primary mb-3">Finalize Invoice</a>
@elseif($issu_count == 0 && $invoice->status == 6)
    <p>Invoice Finalized..</p>
    {{-- <a href="{{ Route('send-invoice-last', $invoiceNumber) }} " class="btn btn-primary mb-3">Re-Send Invoice</a> --}}
@elseif($issu_count == 0 && $invoice->status == 7)
    <a href="{{ Route('send-invoice-last', $invoiceNumber) }} " class="btn btn-primary mb-3">Re-Send Invoice</a>
    <p>Invoice Finalized..</p>
@elseif($issu_count != 0)
    <p>Fix issues.</p>
@elseif ($invoice->status == 2)
    <a href="/invoice/{{ $invoiceNumber }}" class="btn btn-danger">Edit</a>
@else
    <p>Waiting for approve.</p>
@endif
</div>

@endsection
