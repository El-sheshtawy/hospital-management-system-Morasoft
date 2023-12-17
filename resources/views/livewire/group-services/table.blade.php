<button class="btn btn-primary pull-right" wire:click="create" type="button">
    اضافة مجموعة خدمات
</button>
<br><br>
<div class="table-responsive">
    <table class="table text-md-nowrap" id="example1" data-page-length="50"style="text-align: center">
        <thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>اجمالي العرض شامل الضريبة</th>
            <th>الوصف</th>
            <th>العمليات</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($groups as $group)
            <tr>
                <td>{{ $loop->iteration}}</td>
                <td>{{ $group->name }}</td>
                <td>{{ number_format($group->total_with_tax, 2) }}</td>
                <td>{{ $group->description }}</td>
                <td>
                    <button wire:click="edit({{ $group->id }})" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            wire:click="destroy({{ $group->id }})"
                            data-target="#deleteGroup{{$group->id}}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        {{-- include delete Model here --}}
        @endforeach
    </table>
</div>
