<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class erpSetup extends Model
{
    protected $fillable=['company_name','address','phone','email','logo'];
}
