<?php
namespace App\Repositories;

use App\Http\Requests\Users\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        return $users ?? [];
    }

    public function update(UserRequest $request, int $id) {
        $user = User::findOrFail($id);

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
    }

    public function delete(int $id)
    {
        $user = User::find($id);
        $user->delete();
    }

    public function hasRole(int $userId, int $roleId): bool {
        $userRoles = User::find($userId)->roles;
        return $userRoles->contains(Role::find($roleId));
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
