<?php
namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserRepository {
    public static function search(array $validatedSearch) {
        $userQuery = User::query();
        foreach($validatedSearch as $key => $value) {
            $userQuery->when(true, function($query) use ($key, $value) {
                if(is_numeric($value)) { // если поле числовое (в данном случае id), ищем только ид
                    $query->where($key, $value);
                }
                // в противном случае ищем совпадение, для более удобного поиска
                else $query->where($key, 'like', '%'.$value.'%');
            });
        }
        $users = $userQuery->get();
        return new UserResource($users) ?? [];
    }
}
