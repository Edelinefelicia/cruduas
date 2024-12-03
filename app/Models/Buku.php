<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;
    protected $table ='books';
    protected $fillable = ['judul', 'penulis', 'harga_asli', 'tgl_terbit','filepath','filename', 'diskon', 'harga_setelah_potongan'];
    protected $casts = [
        'tgl_terbit' => 'date'
    ];
    protected $dates =['tgl_terbit'];
    public function galleries(): HasMany{
        return $this->hasMany(Gallery::class);
    }
    public function bookmark(){
        return $this->hasOne(Bookmarks::class,'id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'book_id');
    }

}
