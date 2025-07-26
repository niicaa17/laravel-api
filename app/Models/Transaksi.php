<?php

// app/Models/Transaksi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['tanggal', 'uraian', 'total'];
}