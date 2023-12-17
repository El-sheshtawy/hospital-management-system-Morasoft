<!-- Delete Model -->
<div class="modal fade" id="delete{{ $payment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف سند صرف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="post">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                    <h5>{{trans('Dashboard/sections_trans.Warning')}}<span style="color: red">
                            {{ $payment->patient->name }}
                        </span></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/sections_trans.Close')}}</button>
                    <button type="submit" class="btn btn-danger">{{trans('Dashboard/sections_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>