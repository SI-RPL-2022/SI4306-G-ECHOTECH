<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atm extends Model
{
    use HasFactory;
    protected $table = 'atms';
    protected $fillable = [
        'user_id',
        'jmlhBotol',
        'penghasilan',
        'id_botol'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function bottle()
    {
        return $this->belongsTo('App\Models\Bottle', 'id_botol');
    }

    public function detailData($id)
    {
        return DB::table('atms')->where('id', $id)->first();
    }
}
