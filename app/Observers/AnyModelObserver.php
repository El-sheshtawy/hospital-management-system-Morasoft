<?php

namespace App\Observers;

use Illuminate\Support\Carbon;

class AnyModelObserver
{

    public function creating($model): void
    {
        $model->created_at = Carbon::now();
        $model->updated_at = null;
    }


    public function updating($model): void
    {
        $model->updated_at = Carbon::now();
    }
}
