<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_user extends Model
{
    protected $table = 'm_user';
    protected $primaryKey ='user_id';

    public $timestamps = false;
    protected $fillable =['user_id','level_id','username', 'nama','password' ];


}
