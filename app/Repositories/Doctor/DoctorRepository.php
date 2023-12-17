<?php

namespace App\Repositories\Doctor;

use App\Http\Requests\StoreDoctorRequest;
use App\Interfaces\Doctor\DoctorRepositoryInterface;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\UploadImageTrait;
use App\Http\Requests\UpdateDoctorPassworRequest;


class DoctorRepository implements DoctorRepositoryInterface
{
    use UploadImageTrait;

    public function index()
    {

        $doctors = Doctor::with(['section.translations:id,name', 'appointments:id,name', 'image', 'user.translations'])
            ->get(['id', 'active', 'section_id', 'user_id', 'created_at']);
        return view('dashboard.doctor.index', compact('doctors'));
    }

    public function create()
    {
        $sections = Section::withTranslation()->get('id');
        $appointments = Appointment::withTranslation()->get('id');
        return view('dashboard.doctor.create', compact('sections', 'appointments'));
    }

    public function store(StoreDoctorRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_numbers' =>[ 'first_number' => $request->first_number, 'second_number' => $request->second_number],
            ])->assignRole('doctor');

            $doctor = Doctor::create([
                'user_id' => $user->id,
                'section_id' => $request->section_id,
            ]);

            $doctor->appointments()->attach($request->post('appointments'));
            $this->uploadOneImage($request, 'photo', 'name', $doctor->id,
                'APP\Models\Doctor', 'doctors', 'dashboard');
            DB::commit();
            session()->flash('add');
            return redirect()->route('admin.doctors.index');

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $sections = Section::all();
        $appointments = Appointment::all();
        $doctorAppointments = $doctor->appointments->pluck('id')->toArray();

        return view('dashboard.doctor.edit', compact('doctor', 'sections',
            'appointments', 'doctorAppointments'));
    }


    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $doctor = Doctor::findOrFail($id);
            $doctor->update([
                'name' => $request->input('name'),
                'email' => $request->post('email'),
                'password' => Hash::make($request->post('password')),
                'phone' => $request->post('phone'),
                'section_id' => $request->post('section_id'),
            ]);
            $doctor->appointments()->sync($request->post('appointments'));
            $this->updateImageUploading($request, 'image', $doctor, 'photo', 'dashboard',
                '/doctors/'.$doctor->image->filename, $doctor->id, 'name', 'doctors',
            'App\Models\Doctor');
            DB::commit();
            session()->flash('edit');
            return redirect()->route('admin.doctors.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            if ($request->post('delete_type') == 'one_doctor') {
                DB::beginTransaction();
                $doctor = Doctor::findOrFail($request->id);
                $doctorImage = $doctor->image;
                if ($doctorImage) {
                    $this->destroyImage('dashboard', '/doctors/'.$doctorImage->filename, $doctor->id);
                }
                $doctor->delete();
                DB::commit();

                session()->flash('delete');
                return redirect()->route('admin.doctors.index');
            } else {
                DB::beginTransaction();
                $selectedDoctors = explode(',', $request->post('selected_doctors'));
                foreach ($selectedDoctors as $selectedDoctor) {
                    $doctor = Doctor::findOrFail($selectedDoctor);
                    $doctorImage = $doctor->image;
                    if ($doctorImage) {
                        $this->destroyImage('dashboard','/doctors/'.$doctorImage->filename,$doctor->id);
                    }
                    $doctor->delete();
                }
                DB::commit();
                session()->flash('delete');
                return redirect()->route('admin.doctors.index');
            }
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function updatePassword(UpdateDoctorPassworRequest $request)
    {
        try {
            $doctor = Doctor::findOrFail($request->doctor_id);
            $doctor->update([
                'password' => Hash::make($request->post('password')),
            ]);
            session()->flash('edit');
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $doctor = Doctor::findOrFail($request->post('doctor_id'));
            $doctor->update([
                'active' => $request->post('active'),
            ]);
            session()->flash('edit');
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors([
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
