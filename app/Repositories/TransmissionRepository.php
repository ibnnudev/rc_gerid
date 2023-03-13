<?php

namespace App\Repositories;

use App\Interfaces\TransmissionInterface;
use App\Models\Transmission;

class TransmissionRepository implements TransmissionInterface
{

    private $transmission;

    public function __construct(Transmission $transmission) {
        $this->transmission = $transmission;
    }

    public function get()
    {
        return $this->transmission->get();
    }

    public function store($data)
    {
        return $this->transmission->create($data);
    }

    public function find($id)
    {
        return $this->transmission->find($id);
    }

    public function update($data, $id)
    {
        return $this->transmission->find($id)->update($data);
    }

    public function destroy($id)
    {
        $transmission = $this->transmission->find($id);
        $transmission->setInactive();

        return true;
    }
}
