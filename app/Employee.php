<?php
namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model implements Authenticatable
{

    use  HasApiTokens, Notifiable, AuthenticatableTrait,SoftDeletes;

    protected $primaryKey = 'empid';
    protected $table = 'employees';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable =array('empid','empfirstname','emplastname','username','position','password');

    public function show(Request $request, $id)
    {
        $value = $request->session()->get('key');
    }
}
