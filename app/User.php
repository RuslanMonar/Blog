<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
class User extends Authenticatable
{
    const IS_BANNED = 1;
    const IS_ACTIVE = 0;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
    public function reply_comments()
    {
        return $this->hasMany(ReplyComment::class);
    }
    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->save();
        return $user;
    }
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }
    public function generatePassword($password)
    {
        if($password != null){
            $this->password = bcrypt($password);   
            $this->save();
        }
    }
    public function remove()
    {
        $this->removeAvatar();
        $this->delete();
    }
    public function uploadAvatar($image)
    {
        if ($image == null) {
            return;
        }
        // dd(get_class_methods($image)); !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $this->removeAvatar();
        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->avatar = $filename;
        $this->save();
    }
    public function removeAvatar()
    {
        if ($this->avatar != null) {
            Storage::delete('uploads/' . $this->avatar);
        }
    }
    public function getImage()
    {
        if ($this->avatar == null) {
            return '/img/default-user.jpg';
        }
        return '/uploads/' . $this->avatar;
    }
    public function makeAdmin()
    {
        $this->is_admin = 1;
        $this->save();
    }
    public function makeNormal()
    {
        $this->is_admin = 0;
        $this->save();
    }
    public function toggleAdmin($value)
    {
        if ($value == null) {
            return $this->makeNormal();
        } else {
            return $this->makeAdmin();
        }
    }
    public function ban()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }
    public function unband()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }
    public function toggleBan($value)
    {
        if ($value == null) {
            return $this->unband();
        } else {
            return $this->ban();
        }
    }
    public function userStatusRouting($action)
    {
      return  Auth::user()->is_admin ? 'posts.'.$action : 'user_posts.'.$action;
    }
}
