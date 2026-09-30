<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $table = 'tbl_projetos';
    protected $primaryKey = 'id_projetos';
    public const CREATED_AT = 'data_criacao_projetos';
    public const UPDATED_AT = 'data_atualizacao_projetos';
    protected $guarded = [];
}
