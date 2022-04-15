<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Role;

use App\Helpers\Enums\DashboardRoles;

class User extends Authenticatable // implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'patronymic', 'surname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Загрузка связанных моделей по умолчанию
     *
     * @var array
     */
    protected $with = ['roles'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }


    /**
     * Assigning User role
     *
     * @param \App\Models\Role $role
     */
    public function assignRole(Role $role)
    {
        return $this->roles()->save($role);
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', DashboardRoles::ROLE_ADMIN->value)->exists();
    }

    public function isUser()
    {
        return $this->roles()->where('name', DashboardRoles::ROLE_USER->value)->exists();
    }

    public function isStudent()
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->name == DashboardRoles::ROLE_STUDENT->value)
            {
                return true;
            }
        }
        return false;
    }



    /**

        *Получение пользователей с заданными именем роли.
        *@param $query
        *@param string $roleName
        *@return User[]
     */

    public function scopeOfRole($query, string $roleName) {
        $query->whereHas('roles', function ($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }
}
