<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Debertor;
use Illuminate\Support\Facades\DB;
use App\Models\Creditor;



class EventController extends Controller {

    public function index() {
       
    }

    public function cep() {

        $cep = $_GET['cep'];
       
        
        $cURL = curl_init("viacep.com.br/ws/" . str_replace(['-', '.', '_', '-'], "", $cep) . "/json/");
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($cURL);
        $cod = curl_getinfo($cURL, CURLINFO_HTTP_CODE); // tras o COD de retorno (200) ou outro cod

        curl_close($cURL);

        print_r($result);
    }


    public function email_delete() {
      
        $cod = $_GET['cod'];
        $email = $_GET['email'];

      
        $debertor = Debertor::where('codigo', $cod)->get();

        foreach ($debertor as $debertors) {
            $id = $debertors->id;
            DB::delete('DELETE FROM emails WHERE user_id=:id and email=:email', [
                'id' => $id,
                'email' => $email,
            ]);
        }

        
    }
     public function searchDevedor($data) {
         //Busca os devedores por credor busca vem do Jquery
         $credor = $_GET['credor'];
         $id_creditor = Creditor::select('id')->where('nome', $credor )->first();
         $debertor = Debertor::where('creditor_id', $id_creditor->id);
        
            echo json_encode($debertor->get());
     }
     
        public function searchCpfDevedor($data) {
         //Busca os devedores por credor busca vem do Jquery

         $devedor = $_GET['nome'];
         
         
         
         $debertor = Debertor::select('cpf')->where('nome', $devedor )->first();
       
         echo json_encode($debertor->cpf);
       
         
     }
}
