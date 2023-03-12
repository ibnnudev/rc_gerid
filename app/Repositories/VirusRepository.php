<?php

namespace App\Repositories;

use App\Interfaces\VirusInterface;
use App\Models\Virus;

class VirusRepository implements VirusInterface
{
    private $virus;

    public function __construct(Virus $virus)
    {
        $this->virus = $virus;
    }

    public function get()
    {
        return $this->virus->get();
    }
}
