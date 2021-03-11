<?php

namespace App;
use App\ReplyComment;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function replies()
    {
        return $this->hasMany(Comment::class , 'parent_id');
    }
    public function allow()
    {
        $this->status = 1;
        $this->save();
    }
    public function disAllow()
    {
        $this->status = 0;
        $this->save();
    }
    public function toggelStatus()
    {
        if($this->status == 0){
            return $this->allow();
        }
        return $this->disAllow();
    }
    public function remove()
    {
        $this->delete();
    }
    public function getReplays()
    {
        return  $this->replies()->where('status' , 1)->get();
    }
}
