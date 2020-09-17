<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class MkCompromissoPessoa.
 *
 * @package namespace App\Entities;
 */
class MkCompromissoPessoa extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'pgsql';
    protected $table = "public.mk_compromisso_pessoa";
    protected $primaryKey = 'cdpessoa';
    protected $fillable = [];


    

}
