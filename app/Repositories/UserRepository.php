<?php
namespace App\Http\Repositories;

use App\Models\User;

class UserRepository {
    public static function search(string $query) {
        if(is_numeric($query)) {
            return User::findOrFail($query);
        } else return User::where('surname','%'.$query.'%')->firstOrFail();
    }
}
