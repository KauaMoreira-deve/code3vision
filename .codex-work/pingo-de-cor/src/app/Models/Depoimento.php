<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depoimento extends Model
{
    protected $table = 'tbl_depoimento';
    protected $primaryKey = 'id_depoimento';
    public const CREATED_AT = 'data_criacao_depoimento';
    public const UPDATED_AT = 'data_atualizacao_depoimento';
    protected $guarded = [];
}
