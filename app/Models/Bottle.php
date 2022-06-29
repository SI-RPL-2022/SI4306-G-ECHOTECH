<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    use HasFactory;
    protected $table = 'bottles';
    protected $fillable = [
        'harga',
        'ukuran'
    ];

    public function show($id)
    {
        $botol = Bottle::find($id);
        return $botol;
    }
}
