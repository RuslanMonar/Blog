<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Jenssegers\Date\Date;
#use Auth;
use Illuminate\Support\Facades\Auth;
class Post extends Model
{
    const IS_DRAFT = 1;
    const IS_PUBLIC = 0;
    protected $fillable =  ['title', 'content', 'date' , 'description'];
    use Sluggable;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = Auth::user()->id; 
        $post->save();
        return $post;
    }
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }
    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }
    public function uploadImage($image)
    {
        if ($image == null) {
            return;
        }
        $this->removeImage();
        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }
    public function removeImage()
    {
        if ($this->image != null) {
            Storage::delete('uploads/' . $this->image);
        }
    }
    public function getImage()
    {
        if ($this->image == null) {
            return '/img/no-image.png';
        }
       // return '/uploads/' . $this->image;
       return (substr($this->image , 0 ,5) == 'https') ? $this->image : '/uploads/' . $this->image;
    }
    public function setCategory($id)
    {
        if ($id == null) {
            return;
        }
        $this->category_id = $id;
        $this->save();
    }
    public function setTags($ids)
    {
        if ($ids == null) {
            return;
        }
        $this->tags()->sync($ids); //синхронізую статтю з тегами id яких = $ids
    }
    public function deleteTags()
    {
        $this->tags()->detach();
    }
    public function setDraft()
    {
        $this->is_draft = Post::IS_DRAFT;
        $this->save();
    }
    public function setPublic()
    {
        $this->is_draft = Post::IS_PUBLIC;
        $this->save();
    }
    public function toggleStatus($value)
    {
        if ($value == null) {
            return $this->setPublic();
        } else {
            return $this->setDraft();
        }
    }
    public function setFeatured()
    {
        $this->is_featured = 1;
        $this->save();
    }
    public function setStandart()
    {
        $this->is_featured = 0;
        $this->save();
    }
    public function toggleFeatured($value)
    {
        if ($value == null) {
            return $this->setStandart();
        } else {
            return $this->setFeatured();
        }
    }
    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('y-m-d');
        $this->attributes['date'] = $date;
    }
    public function getDateAttribute($value)
    {
        //Carbon::setLocale('ru');
        $date = Carbon::createFromFormat('y-m-d', $value)->format('d/m/y');
        return $date;
    }
    public function getCategoryTitle()
    {
        if ($this->category != null) {
            return $this->category->title;
        }
        return 'Нет категории';
    }
    public function getTagsTitles()
    {
        if (!$this->tags->isEmpty()) {
            return   implode(',', $this->tags->pluck('title')->all());
        }
        return "Нету тегов";
    }
    public function getCategoryId()
    {
        return $this->category_id != null ? $this->category->id : null;
    }
    public function getDate()
    {
        return Date::parse(Carbon::createFromFormat('d/m/y' , $this->date))->format('F d, Y');
    }
    public function hasPrevious()
    {
        return self::where('id' , '<' , $this->id)->max('id');
    }
    public function getPervious()
    {
        if($this->hasPrevious() != null){
        $postID = $this->hasPrevious();
        return self::find($postID);
        }
        return $this;
    }
    public function getNext()
    {
        if($this->hasNext() != null){
        $postID = $this->hasNext();
        return self::find($postID);
        }
        return $this;
    }
    public function hasNext()
    {
       return self::where('id' , '>' , $this->id)->min('id');
    }
    public function related()
    {
        return self::all()->except([$this->id , $this->getNext()->id , $this->getPervious()->id]);
    }
    public function hasCategory()
    {
        return $this->category != null ? true:false;
    }
    public function getComments()
    {
       return  $this->comments()->where([['status' , 1],['parent_id' , null]])->get();
    }
}
