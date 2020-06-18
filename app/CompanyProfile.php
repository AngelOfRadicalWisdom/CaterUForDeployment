<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CompanyProfile extends Model
{
    use SoftDeletes;
    protected $table = 'companies';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;
}
