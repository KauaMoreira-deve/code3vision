<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'tbl_cliente';
    protected $primaryKey = 'id_cliente';
    public const CREATED_AT = 'data_criacao_cliente';
    public const UPDATED_AT = 'data_atualizacao_cliente';
    protected $guarded = [];
    protected $hidden = ['senha_cliente'];
}
