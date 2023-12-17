<!-- Modal -->
<div class="modal fade" id="edit{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('dashboard/sections_trans.edit_sections')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.sections.update', $section->id) }}" method="post">
                @method('put')
                @csrf
                <input type="hidden" name="section_id" value="{{$section->id}}">
                <div class="modal-body">
                    <label for="exampleInputPassword1">{{trans('dashboard/sections_trans.name_sections')}}</label>
                    <input type="text" name="name" class="form-control" required value="{{ $section->name }}">
                    <label for="exampleInputPassword1">
                        {{trans('dashboard/sections_trans.section_description')}}
                    </label>
                    <input type="text" name="description" class="form-control" required
                           value="{{ $section->description }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{trans('dashboard/sections_trans.Close')}}
                    </button>
                    <button type="submit" class="btn btn-primary">{{trans('dashboard/sections_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>