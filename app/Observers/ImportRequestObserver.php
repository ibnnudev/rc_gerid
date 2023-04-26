<?php

namespace App\Observers;

class ImportRequestObserver
{
    public function created($model)
    {
        if (auth()->check()) {
            $model->created_by = auth()->user()->id;
            $model->save();
        }
    }
}
