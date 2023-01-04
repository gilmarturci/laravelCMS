<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Telephone;
use App\Models\Email;

class Debertor extends Model
{
    
    use HasFactory;
    
    public function telephone() {
        return $this->hasMany(Telephone::class,'user_id','id');
    }
     public function email() {
        return $this->hasMany(Email::class,'user_id','id');
    }
     public function adress() {
        return $this->hasOne(Adress::class,'user_id','id');
    }
    public function titulo() {
        return $this->hasMany(Titulo::class,'debertor_id','id');
    }
   public function gerente() {
        return $this->hasOne(Manager::class,'id','manager_id');
    }
    public function credor() {
        return $this->hasOne(Creditor::class,'id','creditor_id');
    }
     public function pessoa() {
        return $this->hasOne(Pessoa::class,'id','pessoa_id');
    }
     public function categoria() {
        return $this->hasOne(Category::class,'id','pessoa_id');
    }
    
}
