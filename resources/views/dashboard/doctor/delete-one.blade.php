{{-- Delete one Modal --}}
<div class="modal fade" id="delete-one{{ $doctor->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('doctors.delete_doctor') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="post">
               @csrf
                @method('delete')
                <div class="modal-body">
                    <h5>{{trans('dashboard/sections_trans.Warning')}} {{$doctor->name}}</h5>
                    <input type="hidden" name="delete_type" value="one_doctor" >
                    @if(!is_null($doctor->image))
                        <input type="hidden" name="filename" value="{{ $doctor->image->filename }}">
                    @endif
                    <input type="hidden" name="id" value="{{ $doctor->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{trans('dashboard/sections_trans.Close')}}</button>
                    <button type="submit" class="btn btn-danger">{{trans('dashboard/sections_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>