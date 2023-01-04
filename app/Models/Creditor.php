<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creditor extends Model
{
    use HasFactory;
    
     public function telephone() {
        return $this->hasOne(Telephone::class,'user_id','id');
    }
     public function email() {
        return $this->hasOne(Email::class,'user_id','id');
    }
     public function adress() {
        return $this->hasOne(Adress::class,'user_id','id');
    }
    
      
}
