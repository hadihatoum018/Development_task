<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function checkUserExist($email){
        try {
            $result = $this->where('email',$email)->exists();
            if ($result){
                return true;
            }
            return false;
        }catch (QueryException $ex){
            return false;
        }
    }
    public function registerAuth($name,$email,$password){
        try{
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            if ($this->save()){
                return true;
            }
            return false;
        }catch (QueryException $ex){
            return false;
        }
    }

    public function loginAuth($email){
        try {
            $result = $this->where('email',$email)->first();
            if (isset($result) && !empty($result)){
                return $result;
            }
            return null;
        }catch (QueryException $ex){
            return null;
        }
    }




}
