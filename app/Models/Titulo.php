<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titulo extends Model
{
    public $timestamps = false;
    use HasFactory;
    
     public function credor() {
        return $this->hasOne(Creditor::class, 'id', 'creditors_id');
        
    }
    public function gerente() {
        return $this->hasOne(Manager::class, 'id', 'maneger_id');
        
    }

     public function devedor() {
        return $this->hasOne(Debertor::class, 'id', 'debertor_id');
        
    }

}
