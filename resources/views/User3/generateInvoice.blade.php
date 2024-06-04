@extends('sidebar.user3sub1')

@section('title', 'Invoice')

@section('pageTitle', 'Invoice')
<link rel="stylesheet" href="{{ asset('sidebar/css/toggle.css') }}">
<style>
    .disabled-link {
        color: gray;
        text-decoration: none;
        cursor: not-allowed;
        pointer-events: none;
    }

    .bank-details {
            display: flex;
            justify-content: space-between;
            font-size: 10pt;
            background: rgba(255, 255, 255, 0.5);
            padding-left: 10px;
            background: white;
            border-radius: 15px;
            margin-top: -10px;
            /* margin-top: 10px; */
        }

        .bank-intern-box {
            padding-left: 5px;
        }
        .gray,
        .bank-details {
            font-size: 11pt;
            margin-left: 10px;
        }

        .bank-box {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

</style>

@section('content')

    @include('sweetalert::alert')

@section('thead')
    <th class="fw-bold text-center">No</th>
    <th class="fw-bold text-center">Description</th>
    <th class="fw-bold text-center">Reimbursable</th>
    <th class="fw-bold text-center">Discount</th>
    <th class="fw-bold text-center">Price</th>
    <th class="fw-bold text-center">Action</th>
@endsection

@section('tbody')
@php $no = 1; @endphp

    @if ($invoice_data->count() > 0)
        @foreach ($invoice_data as $get)

            <tr class="fw-bold t-4">
                <td class="fw-bold text-center" style="width: 80px;">{{ $no }}</td>
                <td class="fw-bold text-center">{{ $get->description }}</td>
                <td class="fw-bold text-center fs-3 text-dark" style="width: 80px;"><i
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

                <td style="max-width: 170px; width:170px;" class="text-center">
                    <button type="button"
                        class="text-light btn btn-sm {{ $get->remark == '' ? 'btn-success' : 'btn-secondary' }}"
                        data-bs-toggle="modal" data-bs-target="#commentModal{{ $get->id }}">
                        <i class="material-symbols-outlined">
                            mark_unread_chat_alt
                        </i>
                    </button>

                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal{{ $get->id }}">
                        <i class="material-symbols-outlined">
                            edit_square
                        </i>
                    </button>

                    <a onclick="return confirm('Are you sure you want to delete this invoice Data?')"
                        href="{{ route('deleteInvoiceData', $get->id) }}" class="btn btn-sm btn-danger rounded">
                        <i class="material-symbols-outlined">
                            delete_forever
                        </i>
                    </a>

                </td>
            </tr>
            <!-- =================================================== -->
            <div class="modal fade" id="commentModal{{ $get->id }}" tabindex="-1" aria-labelledby="commentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentModalLabel">Add a Remark</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ Route('add-comment') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="commentTextarea" class="form-label">Remark:</label>
                                    <textarea class="form-control border shadow" id="commentTextarea" name="remark" rows="3">{{ $get->remark }}</textarea>
                                    <input type="hidden" name="id" value="{{ $get->id }}">
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


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
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="sdate" class="form-label text-dark fw-bold">Start Date</label>
                                        <input type="date" class="border form-control" id="sdate" name="sdate"
                                            value="{{ $get->sdate }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="nomModal" class="form-label">No of Month</label>
                                        <input type="number" class="border form-control" id="nomModal" name="NOM"
                                            placeholder="Number of month" value="{{ $get->nom }}">
                                    </div>
                                    <div class="col">
                                        <label for="MonthPriceModal" class="form-label">Price of a
                                            Month</label>
                                        <input type="number" class="border form-control" id="MonthPriceModal"
                                            name="POM" placeholder="Price of a month" value="{{ $get->pom }}">
                                    </div>
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

    @php
        $invoiceNumber = str_replace('/', '-', $invoiceNumber);
    @endphp
    <a href="{{ Route('send-to-user-back', $invoiceNumber) }}" class="btn btn-success mb-3 float-end">Send To Approver</a>

<div class="b-address">
    <span class="text-start fw-bold">
        Invoice No:  {{ $company_data->invoiceNumber }} <br> <br>
        {!! $company_data->to !!} <br>
        {!! $company_data->companyName . ',' !!} <br>
        {!! str_replace(',', ',<br>', $company_data->address) !!}<br>
        {!! str_replace(',', '<br>', $company_data->email) !!}
    </span>
</div>

<br>

@endsection

@section('bankDetails')
<div class="bank-details text-secondary py-3">
    <div class="bank-box fs-6">
        <div class="box-1">
            <div class="text-purple line">A/C Name</div>
            <div class="text-purple line">Account No</div>
            <div class="text-purple line">Bank Name</div>
            <div class="text-purple line">Bank Address</div>
            <div class="text-purple line">Swift Code</div>
        </div>
        <div class="box-2 bank-intern-box">
            <div class="line">: {{ $bank->acName }}</div>
            <div class="line">: {{ $bank->accountNo }}</div>
            <div class="line">: {{ $bank->bankName }}</div>
            <div class="line">: {{ $bank->bankAddress }}</div>
            <div class="line">: {{ $bank->swiftCode }}</div>
        </div>
    </div>
</div>
@endsection

@endsection
