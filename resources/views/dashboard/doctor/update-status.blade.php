<!-- Modal -->
<div class="modal fade" id="update-status{{ $doctor->id }}" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('doctors.Status_change') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.doctor.status.update') }}" method="post" autocomplete="off">
                @csrf
                @method('patch')
                <div class="modal-body">

                    <div class="form-group">
                        <label for="status">{{trans('Doctors.Status')}}</label>
                        <select class="form-control" id="active" name="active" required>
                            <option value="" disabled>--{{trans('doctors.Choose')}}--</option>
                            <option value=1 @selected(old('active', $doctor->active) == 1)>{{trans('Doctors.Enabled')}}</option>
                            <option value=0 @selected(old('active', $doctor->active) == 0)>{{trans('Doctors.Not_enabled')}}</option>
                        </select>
                    </div>

                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{trans('Dashboard/sections_trans.Close')}}
                    </button>
                    <button type="submit" class="btn btn-primary">{{trans('Dashboard/sections_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>