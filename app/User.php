<?php

namespace App;

use App\Traits\FileUpload;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, FileUpload;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'alamat',
        'status',
        'jenis_kelamin',
        'last_login',
        'api_token',
        'roles',
        'avatar',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function list($request): LengthAwarePaginator
    {
        $users = $this->whereNull('deleted_at')->where('roles', 'super_admin');

        $search = $request->search;

        if ($search) {
            $users = $users->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        return $users->paginate(100);
    }

    public function store($request): User
    {
        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $file_name = $this->FileUpload($file, 'profile_picture');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->alamat = $request->alamat;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->password = Hash::make($request->password);
        $user->roles = $request->roles;

        if($request->file('avatar')){
            $user->avatar = $file_name;
        }
        
        $user->save();

        return $user;
    }

    public function updateUser($request): User
    {
        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $file_name = $this->FileUpload($file, 'profile_picture');
        }

        $user = $this;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->roles = $request->roles;
        $user->phone = $request->phone;
        $user->alamat = $request->alamat;
        $user->jenis_kelamin = $request->jenis_kelamin;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if($request->file('avatar')){
            $user->avatar = $file_name;
        }

        $user->save();

        return $user;
    }
}
