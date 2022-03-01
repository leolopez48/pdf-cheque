<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conceptos extends Model
{
    use HasFactory, SoftDeletes;

    protected $data = ['deleted_at'];

    protected $fillable = [
        'id',
        'codigo',
        'concepto',
        'monto',
        'cheque_id'
    ];

    protected $table = 'conceptos';

    public function cheque()
    {
        return $this->belongsTo(Cheque::class, 'id', '');
    }
}
