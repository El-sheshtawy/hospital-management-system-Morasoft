<!-- Modal -->
<div class="modal fade" id="delete_role{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('dashboard/sections_trans.delete_sections')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="post">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <input type="hidden" name="role_id" value="{{$role->id}}">
                    <h5>{{trans('dashboard/sections_trans.Warning'). ' '. $role->name}}</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('dashboard/sections_trans.Close')}}</button>
                    <button type="submit" class="btn btn-danger">{{trans('dashboard/sections_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
