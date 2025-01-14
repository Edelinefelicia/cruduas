<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // Relasi ke model Review
    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'review_tag');
    }
}
