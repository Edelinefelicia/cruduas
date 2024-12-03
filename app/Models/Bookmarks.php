<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmarks extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'book_id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['kata'] ?? false, function ($query, $kata) {
            // Filter berdasarkan atribut dari model Book
            $query->whereHas('book', function ($query) use ($kata) {
                $query->where('judul', 'like', '%' . $kata . '%')
                      ->orWhere('penulis', 'like', '%' . $kata . '%');
            });
        });
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    // Relasi ke Book
    public function book()
    {
        return $this->belongsTo(Buku::class, 'book_id','id');
    }


}
