<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Petani extends Model
{
    use HasFactory;

    // protected $table = 'petanis';
    protected $fillable = [
        'nama', 'nik', 'alamat', 'telp', 'foto', 'id_kelompok_tani', 'status'
    ];

    static function getPetani()
    {
        $return = DB::table('petanis')
            ->join('kelompok_tanis', 'petanis.id_kelompok_tani', '=', 'kelompok_tanis.id_kelompok_tani');
        return $return;
    }
}
