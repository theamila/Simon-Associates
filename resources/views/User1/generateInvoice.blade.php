@extends('sidebar.register')

@section('title', 'Generate Invoice')

@section('pageTitle', 'Generate Invoice')

<link rel="stylesheet" href="{{ asset('sidebar/css/toggle.css') }}">
@section('content')
    @include('sweetalert::alert')

    <div class="container border rounded">

        <div class="row m-1 p-2 bg-light align-items-center">
            <div class="col">
                <span class="text-danger">Outstanding Amount : <span class="fw-bold">
                        {{ $outdata->outstanding }}
                    </span></span>
            </div>

            <div class="col">
                <select id="bank" name="Selectbank" class="form-select">
                    @foreach ($bank as $get)
                        <option value="{{ $get->id }}" {{ $get->default == 1 ? 'selected' : '' }}>
                            {{ $get->accountNo }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <form action="{{ Route('invoiceDataAdd') }}" method="post" class="mt-3">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label for="sdate" class="form-label text-dark fw-bold">Start Date</label>
                    <input type="date" class="border form-control" id="sdate" name="sdate"
                        value="{{ now()->toDateString() }}">
                </div>

                <div class="col">
                    <label for="nom" class="form-label text-dark fw-bold">No of Month</label>
                    <input type="number" class="border form-control" id="nom" name="NOM"
                        placeholder="Number of month" min="0">
                </div>

                <div class="col">
                    <label for="MonthPrice" class="form-label text-dark fw-bold">Price of a Month</label>
                    <input type="number" class="border form-control" id="MonthPrice" name="POM"
                        placeholder="Price of a month" min="0">
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label text-dark fw-bold">Description</label>
                <textarea class="form-control border" id="description" name="description" placeholder="Enter description" rows="5"
                    required></textarea>
                @error('descriptione')
                    <span class="text-danger mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="price" class="form-label text-dark fw-bold">Price</label>
                        <input type="text" class="form-control border" id="retail" value="0.00" name="price"
                            placeholder="Enter price" required>

                        @error('price')
                            <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <div class="mb-3">
                        <label for="discount" class="form-label text-dark fw-bold">Discount %</label>
                        <input type="text" class="form-control border" id="discount" name="discount"
                            placeholder="Enter Discount" value="0" required>
                        @error('discount')
                            <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="mb-3 align-items-start">
                <span class="fw-bold text-dark mr-3">Reimbursable</span>
                <label class="switch" for="toggle">
                    <input type="checkbox" id="toggle" name="toggle">
                    <span class="slider round"></span>,
                </label>
            </div>
            <input type="hidden" name="invoiceNumber" value="{{ $company_data->invoiceNumber }}">

            <button type="submit" class="btn btn-gradient-primary rounded mb-3">Save</button>
        </form>
        @php
            $no = 0;
        @endphp
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Reimbursable</th>
                                        <th class="text-center">Discount</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($invoice_data->count() > 0)
                                        @foreach ($invoice_data as $get)
                                            @php
                                                $no += 1;
                                            @endphp
                                            <tr class="fw-bold t-4">
                                                <td class="fw-bold text-center" style="width: 80px;">{{ $no }}
                                                </td>
                                                <td class="fw-bold text-start">{{ $get->description }}</td>
                                                <td class="fw-bold text-center fs-3 text-warning" style="width: 80px;"><i
                                                        class="material-symbols-outlined text-success">{{ $get->Reimbursables == 1 ? 'check_circle' : '' }}</i>
                                                </td>


                                                <td class="fw-bold text-center" style="width: 80px;">
                                                    {{ $get->discount . ' %' }}
                                                </td>
                                                <td style="max-width: 250px; width:200px;" class="text-end">
                                                    @php

                                                        $price = $get->price - $get->price * ($get->discount / 100);
                                                    @endphp
                                                    <span class="text-danger">
                                                        {{ number_format($get->price, 2) }}
                                                    </span><br>
                                                    <span class="fw-bold" style="font-size: 12pt;">
                                                        {{ number_format($price, 2) }}
                                                    </span>
                                                </td>

                                                <td style="max-width: 150px; width:150px;" class="text-end">

                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $get->id }}">
                                                        <i class="material-symbols-outlined">edit_square</i>
                                                    </button>

                                                    <a onclick="return confirm('Are you sure you want to delete this invoice Data?')"
                                                        href="{{ route('deleteInvoiceData', $get->id) }}"
                                                        class="btn btn-sm btn-danger rounded">
                                                        <i class="material-symbols-outlined">delete</i>

                                                    </a>
                                                </td>
                                            </tr>


                                            <!-- =============================================================================== -->
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{ $get->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Invoice
                                                                Data</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form
                                                                action="{{ route('invoiceEditDataSave', ['id' => $get->id]) }}"
                                                                method="post">

                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="description"
                                                                        class="form-label text-dark fw-bold">Description</label>
                                                                    <textarea class="form-control border" id="description" name="description" placeholder="Enter description"
                                                                        rows="5" required>{{ $get->description }}</textarea>
                                                                    @error('description')
                                                                        <span
                                                                            class="text-danger mt-2">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="price"
                                                                        class="form-label text-dark fw-bold">Price</label>
                                                                    <input type="text" class="form-control border"
                                                                        id="retailModal" name="price"
                                                                        placeholder="Enter price"
                                                                        value='{{ $get->price }}' required>
                                                                    @error('price')
                                                                        <span
                                                                            class="text-danger mt-2">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="discount"
                                                                        class="form-label text-dark fw-bold">Discount
                                                                        %</label>
                                                                    <input type="text" class="form-control border"
                                                                        id="discount" name="discount"
                                                                        placeholder="Enter Discount"
                                                                        value="{{ $get->discount }}" required>
                                                                    @error('discount')
                                                                        <span
                                                                            class="text-danger mt-2">{{ $message }}</span>
                                                                    @enderror
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="sdate"
                                                                            class="form-label text-dark fw-bold">Start
                                                                            Date</label>
                                                                        <input type="date" class="border form-control"
                                                                            id="sdate" name="sdate"
                                                                            value="{{ $get->sdate }}">
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <div class="col">
                                                                        <label for="nomModal" class="form-label">No of
                                                                            Month</label>
                                                                        <input type="number" class="border form-control"
                                                                            id="nomModal" name="NOM"
                                                                            placeholder="Number of month"
                                                                            value="{{ $get->nom }}">
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="MonthPriceModal"
                                                                            class="form-label">Price of a
                                                                            Month</label>
                                                                        <input type="number" class="border form-control"
                                                                            id="MonthPriceModal" name="POM"
                                                                            placeholder="Price of a month"
                                                                            value="{{ $get->pom }}">
                                                                    </div>
                                                                </div>



                                                                <div
                                                                    class="mb-3 d-flex align-items-start justify-content-start">
                                                                    <span
                                                                        class="fw-bold text-dark mr-3">Reimbursable</span>
                                                                    <label class="csswitch" for="toggle">
                                                                        <input type="checkbox"
                                                                            style="width: 20px; height: 20px; margin-left: 10px;"
                                                                            name="cstoggle"
                                                                            {{ $get->Reimbursables === '1' ? 'checked' : '' }}>
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="invoiceNumber"
                                                                    value="{{ $company_data->invoiceNumber }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-gradient-primary ">Save</button>


                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <script>
                                                function calculateModalTotal() {
                                                    const nomInputModal = document.getElementById('nomModal');
                                                    const pomInputModal = document.getElementById('MonthPriceModal');
                                                    const retailInputModal = document.getElementById('retailModal');

                                                    const nomValue = parseFloat(nomInputModal.value);
                                                    const pomValue = parseFloat(pomInputModal.value);
                                                    const total = nomValue * pomValue;
                                                    retailInputModal.value = total.toFixed(
                                                        2);
                                                }

                                                document.getElementById('nomModal').addEventListener('input', calculateModalTotal);
                                                document.getElementById('MonthPriceModal').addEventListener('input', calculateModalTotal);
                                            </script> -->
                                            <!-- ============================================================================== -->
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center fw-bold">
                                                No Records Found...
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @php $invoiceNumber = str_replace('/', '-', $invoiceNumber); @endphp
                    {{-- <a href="{{ Route('sendToApprover', $invoiceNumber) }}" class="btn btn-inverse-success btn-fw">Send
                        To
                        Approver</a> --}}

                        <a id="sendToApproverBtn" href="#" class="btn btn-inverse-success btn-fw">Send To Approver</a>
                </div>
            </div>


        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var selectElement = document.getElementById('bank');
                var defaultBankId = selectElement.value;

                var url = "{{ route('sendToApprover', ['invoiceNumber' => $invoiceNumber, 'bankId' => 'jsvariable']) }}";
                url = url.replace('jsvariable', defaultBankId);

                document.getElementById('sendToApproverBtn').href = url;

                selectElement.addEventListener('change', function() {
                    var selectedBankId = this.value;

                    var url = "{{ route('sendToApprover', ['invoiceNumber' => $invoiceNumber, 'bankId' => 'jsvariable']) }}";
                    url = url.replace('jsvariable', selectedBankId);

                    document.getElementById('sendToApproverBtn').href = url;
                });
            });
        </script>
        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("sdate").addEventListener("change", updateDescription);
                document.getElementById("nom").addEventListener("input", updateDescription);
                document.getElementById("MonthPrice").addEventListener("input", updateDescription);
            });

            function updateDescription() {
                var startDate = document.getElementById("sdate").value;
                var nom = parseInt(document.getElementById("nom").value);
                var pom = parseFloat(document.getElementById("MonthPrice").value);

                if (startDate && !isNaN(nom) && !isNaN(pom)) {
                    var startDateObj = new Date(startDate);
                    var endDateObj = new Date(startDateObj.getFullYear(), startDateObj.getMonth() + nom, startDateObj
                        .getDate() - 1);
                    var description = "Secretarial fees from " + formatDate(startDateObj) + " to " + formatDate(endDateObj) +
                        " at the rate of Rs." + pom.toFixed(2) + " per month.";
                    document.getElementById("description").value = description;
                    var price = nom * pom;
                    document.getElementById("retail").value = price.toFixed(2);
                }
            }

            function formatDate(date) {
                var month = date.toLocaleString('default', {
                    month: 'long'
                });
                var day = date.getDate();
                var year = date.getFullYear();
                return ordinalSuffix(day) + " " + month + " " + year;
            }

            function ordinalSuffix(i) {
                var j = i % 10,
                    k = i % 100;
                if (j == 1 && k != 11) {
                    return i + "st";
                }
                if (j == 2 && k != 12) {
                    return i + "nd";
                }
                if (j == 3 && k != 13) {
                    return i + "rd";
                }
                return i + "th";
            }
        </script>

        <script>
            // Get references to the input fields
            const nomInput = document.getElementById('nom');
            const pomInput = document.getElementById('MonthPrice');
            const retailInput = document.getElementById('retail');

            // Function to calculate the total and update the retail input
            function calculateTotal() {
                const nomValue = parseFloat(nomInput.value);
                const pomValue = parseFloat(pomInput.value);
                const total = nomValue * pomValue;
                retailInput.value = total.toFixed(2); // Set the total value in the retail input field
            }

            // Listen for input events on the NOM and POM input fields
            nomInput.addEventListener('input', calculateTotal);
            pomInput.addEventListener('input', calculateTotal);
        </script>



    @endsection
