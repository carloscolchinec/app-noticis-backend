<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'tb_posts';
    protected $primaryKey = 'id_posts';
    protected $fillable = ['title', 'image', 'description', 'likes', 'time_creation'];

    public $timestamps = false;

    /**
     * Define la relación entre los posts y los comentarios.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
