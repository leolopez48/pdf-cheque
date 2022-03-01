<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cheque extends Model
{
    use HasFactory, SoftDeletes;

    protected $data = ['deleted_at'];

    protected $fillable = [
        'id',
        'nombre',
        'monto',
    ];

    protected $table = 'cheques';

    public function conceptos()
    {
        return $this->hasMany(Cheque::class);
    }
}
