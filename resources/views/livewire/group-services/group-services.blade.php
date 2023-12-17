<div>
    @if ($storedGroup)
        <div class="alert alert-info">تم حفظ البيانات بنجاح.</div>
    @endif

    @if ($updatedGroup)
        <div class="alert alert-info">تم تحديث البيانات بنجاح.</div>
    @endif

        @if ($deletedGroup)
            <div class="alert alert-danger">تم حذف البيانات بنجاح.</div>
        @endif

    @if($showTable)
        @include('livewire.group-services.table')
    @else

    <form wire:submit.prevent="storeOrUpdate" autocomplete="off">
        @csrf
        <div class="form-group">
            <label>اسم العرض</label>
            <input wire:model="group_name" type="text" name="group_name" class="form-control">
            @error('group_name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>الوصف</label>
            <textarea wire:model="description" name="description" class="form-control" rows="5"></textarea>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <div class="col-md-12">
                    <button class="btn btn-outline-primary" wire:click.prevent="add">
                        اضافة خدمة فرعية
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="table-primary">
                            <th>اسم الخدمة</th>
                            <th width="200">العدد</th>
                            <th width="200">العمليات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($groupServices as $index => $selectedService)
                            <tr>
                                <td>
                                    @if($selectedService['is_saved'])

                                        <input type="hidden" name="groupServices[{{$index}}][service_id]"
                                               wire:model="groupServices.{{$index}}.service_id" />

                                        @if($selectedService['service_name'] && $selectedService['service_price'])
                                            {{ $selectedService['service_name'] }}
                                            ({{ number_format($selectedService['service_price'], 2) }})
                                        @endif

                                    @else
                                        <select name="groupServices[{{$index}}][service_id]"
                                                wire:change="setDefaultQuantity({{ $index }})"
                                                class="form-control{{ $errors->has('groupServices.' . $index) ?' is-invalid' : '' }}"
                                                wire:model="groupServices.{{$index}}.service_id">
                                            <option value="" selected disabled>-- Choose service --</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ \App\Models\SingleServiceTranslation::where('single_service_id' , '=', $service->id)
                                                                                 ->pluck('name')->first() }}
                                                    ({{ number_format($service->price, 2) }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("groupServices.{$index}"))
                                            <em class="invalid-feedback">
                                                {{ $errors->first("groupServices.{$index}") }}
                                            </em>
                                        @endif

                                        @error('groupServices.*.service_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    @endif
                                </td>
                                <td>

                                    @if($selectedService['is_saved'])
                                        <input type="hidden" name="groupServices[{{$index}}][quantity]"
                                               wire:model="groupServices.{{$index}}.quantity"/>
                                        {{ $selectedService['quantity'] }}
                                    @else

                                        <input type="number" name="groupServices[{{$index}}][quantity]"
                                               class="form-control @error('groupServices.*.quantity') is-invalid @enderror"
                                               wire:model="groupServices.{{$index}}.quantity"/>
                                   @error('groupServices.*.quantity')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                   @enderror

                                    @endif
                                </td>
                                <td>
                                    @if($selectedService['is_saved'])
                                        <button class="btn btn-sm btn-primary"
                                                wire:click.prevent="editSelectedService({{$index}})">
                                            تعديل
                                        </button>
                                    @elseif($selectedService['service_id'])
                                        <button class="btn btn-sm btn-success mr-1"
                                                wire:click.prevent="save({{$index}})">
                                            تاكيد
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-danger"
                                            wire:click.prevent="remove({{$index}})">حذف
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<div class="row">
        <div class="col-lg-4 ml-auto text-right">
            <table class="table pull-right">
                <tr>
                    <td style="color: red">الاجمالي</td>
                    <td>{{ number_format($subtotal, 2) }}</td>
                </tr>

                <tr>
                    <td style="color: red">قيمة الخصم</td>
                    <td width="125">
                        <input type="number" name="discount_value" class="form-control w-75 d-inline"
                               wire:model="discount_value">
                    </td>
                </tr>

                <tr>
                    <td style="color: red">نسبة الضريبة</td>
                    <td>
                        <input type="number" name="taxes" class="form-control w-75 d-inline" min="0" max="100"
                               wire:model="taxes"> %
                    </td>
                </tr>
                <tr>
                    <td style="color: red">الاجمالي مع الضريبة</td>
                    <td>{{ number_format($total, 2) }}</td>
                </tr>
            </table>
        </div>
        <br/>
    @if($showErrors)
    <div class="col">
        @if ($errors->any())
            <div class="alert alert-warning" role="alert" style="text-align: center">
                An errors Occurred!
            </div>

            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    @endif
</div>
        <div>
            <input class="btn btn-outline-success" type="submit" value="تاكيد البيانات">
        </div>
</form>
</div>
@endif
