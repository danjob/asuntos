<?php

namespace App\Models;

use Auth;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $hidden = ['category_id'];

    protected $appends = ['likesCount', 'isLiked', 'owner_name'];

    protected $with = ['category'];

    protected $casts = [
        'category_id' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    public function getIsLikedAttribute()
    {
        if (Auth::check()) {
            return Auth::user()
                ->likes
                ->where('id', $this->id)
                ->count();
        }

        return false;
    }

    public function getOwnerNameAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d.m.y');
    }

    /*
    |--------------------------------------------------------------------------
    | Mutator
    |--------------------------------------------------------------------------
    */

    public function setCategoryIdAttribute($value)
    {
        if (is_numeric($value)) {
            return $this->attributes['category_id'] = $value + 1;
        }

        return $this->attributes['category_id'] = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
