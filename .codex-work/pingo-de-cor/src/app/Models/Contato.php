<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'tbl_contato';
    protected $primaryKey = 'id_contato';
    public const CREATED_AT = 'data_criacao_contato';
    public const UPDATED_AT = 'data_atualizacao_contato';
    protected $guarded = [];
}
