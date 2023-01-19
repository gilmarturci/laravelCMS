<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use DateTime;
use App\Models\Debertor;
use App\Models\Adress;
use App\Models\Email;
use App\Models\Telephone;
use App\Models\Creditor;
use App\Models\Manager;
use App\Models\Pessoa;
use App\Models\Category;
use App\Models\Titulo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TituloController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
      
      $data = $request->except('_token');
      
      // salva as informações que vem no request para enviar a paginação
        if (isset($data['contrato'])) {
            $contrato = $data['contrato'];
        } else { $contrato = "";}
          if (isset($data['codigo'])) {
            $codigo = $data['codigo'];
        } else { $codigo= "";}
        if (isset($data['cpf'])) {
            $cpf= $data['cpf'];
        } else { $cpf = "";}
         if (isset($data['data_pgto'])) {
            $data_pgto = $data['data_pgto'];
        } else { $data_pgto = "";}
        if (isset($data['nome'])) {
            $nome = $data['nome'];
        } else { $nome = "";}
      if (isset($data['creditor'])) {
            $creitor = $data['creditor'];
        } else {$creitor = ""; }
         if (isset($data['category'])) {
            $category = $data['category'];
        } else {$category = ""; }
         if (isset($data['data_geracao'])) {
            $data_geracao= $data['data_geracao'];
        } else {$data_geracao = ""; }
        if (isset($data['status'])) {
            $status = $data['status'];
        } else {$status = ""; }
         if (isset($data['negociacao'])) {
            $negociacao = $data['negociacao'];
        } else {$negociacao = ""; }
      ///****************************************/////  
         





        $titulos = $this->searchAll($data); //Faz a pesquisa dos dados enviados no metodo searchAll
    
        $gerentes = Manager::all();
        $categorias = Category::all();
        $pessoas = Pessoa::all();
        $credores = Creditor::all();
        $loggedID = Auth::id();
      

        return view('admin.titulo.index', [
            'titulos' => $titulos,
            'loggedID' => $loggedID,
            'gerentes' => $gerentes,
            'pessoas' => $pessoas,
            'credores' => $credores,
            'categorias' => $categorias,
            
            'contrato' => $contrato,
            'codigo' => $codigo,
            'cpf' => $cpf,
            'data_pgto' => $data_pgto,
            'nome' => $nome,
            'creditor' => $creitor,
            'category' => $category,
            'data_geracao' => $data_geracao,
            'status' => $status,
            'negociacao' => $negociacao,
]);
    }


    public function create() {
       Session::forget('warning');// limpa da sessão o alert warning 
        
  
      
        $categorias = Category::all();
        $credores = Creditor::all();

          return view('admin.titulo.create', [
            'credores' => $credores,
            'categorias' => $categorias
        ]);
    }

 
    public function store(Request $request) {
        //Salvar
        $data = $request->except('_token');
        
     
        //verifica se tem array vazio (contrato, data-vencimento, valor, data-geração)
        foreach ($data as $value => $key) {
            if (in_array(NULL, $data[$value])) {   
           return redirect()->route('titulo.create')
                   ->withErrors("verifique o campo " . $value)
                   ->withInput();       
       
            }
        }

    //verifica se já tem a parcela cadastrada para o contrato informado
        
        //busca id do devedor para comparação id c/ id_debertor
         foreach ($data['nome'] as $nome) {
            $debertor = Debertor::select('id')->where('nome', $nome)->get();         
        }
        //lista se a parcela já existe para o contrato para o devedor selecionado
        foreach ($data['contrato'] as $contrato) {
            foreach ($data['parcela'] as $parcela) {
                
               $tl_duplicado = Titulo::where('contrato', $contrato)->where('debertor_id', $debertor->first()->id)->where('parcela', $parcela)->get();
             
               if ($tl_duplicado != null) {
                    foreach ($tl_duplicado as $info) {
                        return redirect()->route('titulo.create')
                                        ->withErrors("O cliente informado já posui cadastro da parcela " . $info->parcela . " para o contrato " . $info->contrato)
                                        ->withInput();
                    }
                }
            }
        }
        
     //***Faz a inclusão dos novos titulos   
         for ($i = 0; $i < count($data['contrato']); $i++) {
             
             $titulo = new Titulo();//Insancia o modelo Titulo
             
            //Primeiro foreach busca ID credor pelo nome do credor
             foreach ($data['creditor'] as $credor) {
                $id_credor = Creditor::where('nome', $credor)->get();
                $titulo->creditors_id = $id_credor->first()->id;

                //Segundo foreach busca ID devedor e ID do gerente da conta pelo nome do devedor
                foreach ($data['nome'] as $devedor) {
                    $id_devedor = Debertor::where('nome', $devedor)->get();
                    $id_gerente = $id_devedor->first()->gerente->id;
                    $titulo->debertor_id = $id_devedor->first()->id;
                    $titulo->maneger_id = $id_gerente;
                }
            }
            
            $status = "A";
            $valor = $data['valor'][$i];
            $parcela = $data['parcela'][$i];
            $contrato = $data['contrato'][$i];
            $data_venc = $data['data-vencimento'][$i];
            $data_geracao = $data['data-geracao'][$i];

            $titulo->status = $status;
            $titulo->valor = $valor;
            $titulo->parcela = $parcela;
            $titulo->contrato = $contrato;
            $titulo->vencimento = date('Y-m-d', strtotime($data_venc)); // convet formato de data;
            $titulo->data_geracao = date('Y-m-d', strtotime($data_geracao));
            
            echo $parcela.' - Parcela </br>';
            $titulo->save();
        }
       
        return redirect()->route('titulo.create')
                ->with('success','Títulos cadastrado com Sucesso!');
    }
    

    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        var_dump($id);
        die();
    }

    public function searchAll($data) {
        
       
        $query = Titulo::query();

        $fields = ( array_filter($data, function ($value, $key) {
                    return $value != null; // retorna todos os valores que forem diferentes de null
                }, ARRAY_FILTER_USE_BOTH) );

        if (!empty($fields)) {
            
            Session::forget('warning');

            foreach ($fields as $value => $key) {
                
               
                if ($value == 'cpf' || $value == 'codigo' || $value == 'nome') {
                    $query->whereHas('devedor', function ($q) use($data, $value) {
                        $q->where($value, 'LIKE', '%' . $data[$value] . '%');
                    });   
                }
                if ($value == 'manager') {
                    $query->whereHas('gerente', function ($q) use($data, $value) {
                        $q->where('nome', 'LIKE', '%' . $data[$value] . '%');
                    }); 
                }
                if ($value == 'creditor') {
                    $query->whereHas('credor', function ($q) use($data, $value) {
                        $q->where('nome', 'LIKE', '%' . $data[$value] . '%');
                    });
                }
                if ($value == 'status') {
                    
                    $query->where('status', $data[$value]); 
                  
                }
                if ($value == 'data_geracao' || $value == 'data_pgto') {

                    $date = explode('-', $key);
                    
                    $startdate = $date[0];
                    $startdate = strtr($startdate, '/', '-');
                    $startdate = date('Y-m-d', strtotime($startdate)); // convet formato de data

                
                    $endDate = $date[1];
                    $endDate = strtr($endDate, '/', '-');
                    $endDate = date('Y-m-d', strtotime($endDate)); // convet formato de data

                  
                   $query->whereBetween($value, [$startdate, $endDate])->get();
                   
                }
                if ($value == 'negociacao') {
                    $query->where('tipo_negociacao', $data[$value]);  
                }

                if ($value == 'contrato') {
                    $query->where('contrato', $data[$value]);  
                }
                
               
            }
            
         
             
            $titulos = $query->with('devedor')->paginate(5);
          
                  
                    
          

            if (count($titulos) > 0) {
                return $titulos;
            } else {
                return array();
            }
        } else {
            
            return array();
        }
    }
   
}
