<?php

namespace App\Observers;

class SampleObserver
{
    public function saving($model)
    {
        $model->size_gene = strtolower($model->size_gene);
    }
}
