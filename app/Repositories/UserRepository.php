<?php
namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserRepository {

    public function getAll()
    {
        return new UserResource(User::paginate(10));
    }

    public function search(array $validatedSearch)
    {
        $userQuery = User::with(['roles']);
        foreach($validatedSearch as $key => $value) {
            $userQuery->when(true, function($query) use ($key, $value) {
                if(is_numeric($value)) { // если поле числовое (в данном случае id), ищем только ид
                    $query->where($key, $value);
                }
                // в противном случае ищем совпадение в строке, для более удобного поиска
                else $query->where($key, 'like', '%'.$value.'%');
            });
        }
        $users = $userQuery->paginate(10);
        return new UserResource($users) ?? [];
    }

    public function setRole(int $userId, int $roleId)
    {
        $user = User::find($userId);
        $user->roles()->attach($roleId);
    }

    public function detachRole(int $userId, int $roleId)
    {
        $user = User::find($userId);
        $user->roles()->detach($roleId);
    }
}
