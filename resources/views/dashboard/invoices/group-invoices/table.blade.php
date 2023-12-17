<button class="btn btn-primary pull-right" wire:click="create" type="button">اضافة فاتورة جديدة </button><br><br>
<div class="table-responsive">
    <table class="table text-md-nowrap" id="example1" data-page-length="50"style="text-align: center">
        <thead>
        <tr>
            <th>#</th>
            <th>اسم الخدمة</th>
            <th>اسم المريض</th>
            <th>تاريخ الفاتورة</th>
            <th>اسم الدكتور</th>
            <th>القسم</th>
            <th>سعر الخدمة</th>
            <th>قيمة الخصم</th>
            <th>نسبة الضريبة</th>
            <th>قيمة الضريبة</th>
            <th>الاجمالي مع الضريبة</th>
            <th>نوع الفاتورة</th>
            <th>العمليات</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($groupsInvoices as $groupInvoice)
            <tr>
                <td>{{ $groupInvoice->full_invoice_number}}</td>
                <td>{{ $groupInvoice->groupServices->name }}</td>
                <td>{{ $groupInvoice->patientUser->name }}</td>
                <td>{{ $groupInvoice->date }}</td>
                <td>{{ $groupInvoice->doctorUser->name }}</td>
                <td>{{ $groupInvoice->section->name }}</td>
                <td>{{ number_format($groupInvoice->price, 2) }}</td>
                <td>{{ number_format($groupInvoice->discount_value, 2) }}</td>
                <td>{{ $groupInvoice->tax_rate }}%</td>
                <td>{{ number_format($groupInvoice->tax_value, 2) }}</td>
                <td>{{ number_format($groupInvoice->total_with_tax, 2) }}</td>
                <td>{{ $groupInvoice->payment_method == 'cash' ? 'نقدي':'اجل' }}</td>
                <td>
                    <button wire:click="edit({{ $groupInvoice->id }})" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#delete_group_invoice" wire:click="set_group_invoice_id({{ $groupInvoice->id }})" >
                        <i class="fa fa-trash"></i>
                    </button>
                    <a href="" wire:click="print({{ $groupInvoice->id }})" class="btn btn-primary btn-sm"
                       target="_blank" title="طباعه ">
                        <i class="fas fa-print"></i>
                    </a>
                </td>
            </tr>
        @include('dashboard.invoices.group-invoices.delete')
        @endforeach
    </table>
</div>
