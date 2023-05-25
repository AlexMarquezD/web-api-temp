<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryContract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryContract
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        $user = $this->model->create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'email' => $data['email']
        ]);

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function delete(int $id)
    {
        return $this->model->where($id)->delete();
    }

    public function update(int $id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }
}
