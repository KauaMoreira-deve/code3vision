<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacao extends Model
{
    protected $table = 'tbl_publicacoes';
    protected $primaryKey = 'id_publicacoes';
    public const CREATED_AT = 'data_criacao_publicacoes';
    public const UPDATED_AT = 'data_atualizacao_publicacoes';
    protected $guarded = [];

    protected function casts(): array
    {
        return ['data_publicacoes' => 'datetime'];
    }
}
