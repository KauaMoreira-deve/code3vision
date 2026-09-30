<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    protected $table = 'tbl_orcamento';
    protected $primaryKey = 'id_orcamento';
    public const CREATED_AT = 'data_criacao_orcamento';
    public const UPDATED_AT = 'data_atualizacao_orcamento';
    protected $guarded = [];
    protected function casts(): array
    {
        return ['valor_total_orcamento' => 'decimal:2'];
    }
}
