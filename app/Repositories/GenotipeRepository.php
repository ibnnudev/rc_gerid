<?php

namespace App\Repositories;

use App\Interfaces\GenotipeInterface;
use App\Models\Genotipe;

class GenotipeRepository implements GenotipeInterface {

    private $genotipe;

    public function __construct(Genotipe $genotipe) {
        $this->genotipe = $genotipe;
    }

    public function get()
    {
        return $this->genotipe->with('virus')->get();
    }

    public function store($data):bool
    {
        $this->genotipe->create([
            'genotipe_code' => $data['genotipe_code'],
            'viruses_id'    => $data['viruses_id'],
        ]);
        return true;
    }
    public function find($id)
    {
        return $this->genotipe->find($id);
    }

    public function update($data, $id) :bool
    {
        $this->genotipe->where('id', $id)->update([
            'genotipe_code'       => $data['genotipe_code'],
            'viruses_id'          => $data['viruses_id'],
        ]);

        return true;

    }

    public function destroy($id): bool
    {
        $genotipe = $this->genotipe->find($id);
        $genotipe->setInactive();

        return true;
    }

}
