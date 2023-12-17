<?php

namespace App\Traits;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadImageTrait
{
    public function uploadOneImage(Request $request, $inputName, $personNameInput, $imageable_id, $imageable_type,
                                        $folderName, $diskName)
    {
        if (!$request->hasFile($inputName)) {
            return;
        }
        $image = $request->file($inputName);
        if (!$image->isValid()) {
            flash('Invalid Image!')->error()->important();
            return redirect()->back()->withInput();
        }
        $imageSlug = Str::slug($request->input($personNameInput));
        $imageName = $imageSlug . '.' . $image->getClientOriginalExtension();

        Image::create([
            'filename' => $imageName,
            'imageable_id' => $imageable_id,
            'imageable_type' => $imageable_type,
        ]);
        return $image->storeAs($folderName, $imageName, $diskName);
    }

    public function destroyImage($diskName, $folderPath, $modelId)
    {
        Storage::disk($diskName)->delete($folderPath);
        image::where('imageable_id', $modelId)->delete();
    }

    public function updateImageUploading(Request $request, $imageRelation, $model, $inputName, $diskName, $folderPath,
                                                 $imageable_id, $personNameInput, $folderName, $imageable_type)
    {
        if ($model->$imageRelation && !isset($request->$inputName)) {
            return;
        } else {
            $this->destroyImage($diskName, $folderPath, $imageable_id);
            $this->uploadImage($request, $inputName, $personNameInput, $imageable_id, $imageable_type, $folderName, $diskName);
        }
    }


    public function uploadMultipleImages(Request $request, $imageable_id, $imageable_type, $directory)
    {
        if (!$request->hasFile('images')) {
            return;
        }
        foreach ($request->file('images') as $image) {
            if (!$image->isValid()) {
                flash('Invalid Image!')->error()->important();
                return redirect()->back()->withInput();
            }
            $imageName = rand(1000,1000000) . '.' . $image->getClientOriginalExtension();
            Image::create([
                'filename' => $imageName,
                'imageable_id' => $imageable_id,
                'imageable_type' => $imageable_type,
                ]);
            $image->move($directory, $imageName);
        }
    }
}
