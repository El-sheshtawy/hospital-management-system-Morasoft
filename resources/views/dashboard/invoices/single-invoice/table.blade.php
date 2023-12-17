<button class="btn btn-primary pull-right" wire:click="create" type="button">اضافة فاتورة جديدة </button>
<br><br>
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
        @foreach ($singleInvoices as $singleInvoice)
            <tr>
                <td>{{ $singleInvoice->full_invoice_number}}</td>
                <td>{{ $singleInvoice->singleService->name }}</td>
                <td>{{ $singleInvoice->patientUser->name }}</td>
                <td>{{ $singleInvoice->date }}</td>
                <td>{{ $singleInvoice->doctorUser->name }}</td>
                <td>{{ $singleInvoice->section->name }}</td>
                <td>{{ number_format($singleInvoice->price, 2) }}</td>
                <td>{{ number_format($singleInvoice->discount_value, 2) }}</td>
                <td>{{ $singleInvoice->tax_rate }}%</td>
                <td>{{ number_format($singleInvoice->tax_value, 2) }}</td>
                <td>{{ number_format($singleInvoice->total_with_tax, 2) }}</td>
                <td>{{ $singleInvoice->payment_method == 'cash' ? 'نقدي' : 'تقسيط' }}</td>
                <td>
                    <button wire:click="edit({{ $singleInvoice->id }})" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i></button>

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#delete" wire:click="set_single_invoice_id({{ $singleInvoice->id }})">
                        <i class="fa fa-trash"></i>
                    </button>
                    <button wire:click="print({{ $singleInvoice->id }})" class="btn btn-primary btn-sm">
                        <i class="fas fa-print"></i>
                    </button>
                </td>
            </tr>
            @include('dashboard.invoices.single-invoice.delete')
        </tbody>
        @endforeach
        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $singleInvoices->links() !!}
        </div>
    </table>
</div>
