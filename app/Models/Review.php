<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'reviewer_id',
        'review_content',
        'review_date',
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'review_tag');
    }
    public function book()
    {
        return $this->belongsTo(Buku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
