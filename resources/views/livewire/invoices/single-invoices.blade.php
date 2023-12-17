<div>
    @if ($storedInvoice)
        <div class="alert alert-info">تم حفظ البيانات بنجاح.</div>
    @endif

    @if ($updatedInvoice)
        <div class="alert alert-info">تم تعديل البيانات بنجاح.</div>
    @endif

    @if($showTable)
        @include('dashboard.invoices.single-invoice.table')
    @else
        <form wire:submit.prevent="updateOrStore" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col">
                    <label>اسم المريض</label>
                    <select wire:model="patient_id" class="form-control" required>
                        <option value="">-- اختار من القائمة --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col">
                    <label>اسم الدكتور</label>
                    <select wire:model="doctor_id"  wire:change="set_section_name" class="form-control" required>
                        <option value="" >-- اختار من القائمة --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{$doctor->id}}">{{ $doctor->user->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col">
                    <label>القسم</label>
                    <input wire:model="section_name" type="text" class="form-control" readonly >
                    @error('section_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col">
                    <label>نوع الفاتورة</label>
                    <select wire:model="type" class="form-control" {{ $updateMode == true ? 'disabled' : '' }}>
                        <option value="">-- اختار من القائمة --</option>
                        <option value="1">نقدي</option>
                        <option value="0" >تقسيط</option>
                    </select>
                    @error('type')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div><br>

            <div class="row row-sm">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mg-b-0"></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mg-b-0 text-md-nowrap" style="text-align: center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الخدمة</th>
                                        <th>سعر الخدمة</th>
                                        <th>قيمة الخصم</th>
                                        <th>نسبة الضريبة</th>
                                        <th>قيمة الضريبة</th>
                                        <th>الاجمالي مع الضريبة</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <select wire:model="service_id" class="form-control"
                                                    wire:change="get_service_price">
                                                <option value="">-- اختار الخدمة --</option>
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('service_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input wire:model="price" type="text" class="form-control" readonly>
                                        </td>
                                        <td>
                                            <input wire:model="discount_value" type="text" class="form-control">
                                            @error('discount_value')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <th>
                                            <input wire:model="tax_rate" type="text" class="form-control">
                                            @error('tax_rate')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </th>
                                        <td>
                                            <input type="text" class="form-control" value="{{$tax_value}}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" readonly
                                                   value="{{ $total_with_tax }}">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div><!-- bd -->
                        </div><!-- bd -->
                    </div><!-- bd -->
                </div>
            </div>
            <div class="col-xs-1 text-center">
                <input class="btn btn-outline-primary" type="submit" value="تاكيد البيانات">
            </div>
        </form>
    @endif
</div>
