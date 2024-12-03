<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i=0;$i<10;$i++){
            Buku::create([
                'judul'=>fake()->sentence(3),
                'penulis' => fake()->name(),
                'harga_asli'=>fake()->numberBetween(10000,50000),
                'diskon'=>0,
                'harga_setelah_potongan'=>0,
                'tgl_terbit'=>fake()->date(),
            ]);
        }
    }
}
