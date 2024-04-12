<?php

namespace App\Repositories;

use App\Interfaces\UserManagementInterface;
use App\Models\User;

class UserManagementRepository implements UserManagementInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function active($id)
    {
        return $this->user->find($id)->update(['status' => true]);
    }
}
