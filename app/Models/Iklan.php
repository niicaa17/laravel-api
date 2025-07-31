<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    class Iklan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_iklan';
    protected $fillable = ['uraian', 'gambar_iklan'];
}