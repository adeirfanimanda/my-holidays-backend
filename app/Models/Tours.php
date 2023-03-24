<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tours extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'price',
        'description',
        'tags',
        'categories_id',
    ];

    public function galleries()
    {
        return $this->hasMany(ToursGallery::class, 'tours_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ToursCategory::class, 'categories_id', 'id');
    }
}
