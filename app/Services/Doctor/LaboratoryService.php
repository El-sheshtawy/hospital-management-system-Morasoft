<?php

namespace App\Services\Doctor;

use App\Models\Laboratory;

class LaboratoryService
{
    public function store(array $laboratoryData): Laboratory
    {
        return Laboratory::create($laboratoryData);
    }

    public function update(array $laboratoryData, Laboratory $laboratory): Laboratory
    {
        $laboratory->update($laboratoryData);
        return $laboratory;
    }

    public function destroy(Laboratory $laboratory)
    {
        return $laboratory->delete();
    }
}
