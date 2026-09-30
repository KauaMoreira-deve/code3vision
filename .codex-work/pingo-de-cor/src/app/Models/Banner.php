<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'tbl_banner';
    protected $primaryKey = 'id_banner';
    public const CREATED_AT = 'data_criacao_banner';
    public const UPDATED_AT = 'data_atualizacao_banner';
    protected $guarded = [];
}
