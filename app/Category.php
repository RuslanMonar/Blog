<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
/* Кожна категорія може мати декілька постів,
один або багатою. Навіть якщо буде один пост ми будемо получати в
вигляді масиву маючи на увазы що в нас звязок один до багатьох */
class Category extends Model
{
    use Sluggable;
    protected $fillable = ['title'];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
