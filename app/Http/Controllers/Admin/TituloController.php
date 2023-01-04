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

        $titulos = $this->searchAll($data); //Faz a pesquisa dos dados enviados no metodo searchAll
  
        $gerentes = Manager::all();
        $categorias = Category::all();
        $pessoas = Pessoa::all();
        $credores = Creditor::all();
        $loggedID = Auth::id();


        $dataFilter = array_filter($data); //Exclui tudo que for nulo


        return view('admin.titulo.index', [
            'titulos' => $titulos,
            'loggedID' => $loggedID,
            'gerentes' => $gerentes,
            'pessoas' => $pessoas,
            'credores' => $credores,
            'categorias' => $categorias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
       Session::forget('warning');// limpa da sessão o alert warning 
        
  
      
        $categorias = Category::all();
        $credores = Creditor::all();

          return view('admin.titulo.create', [
            'credores' => $credores,
            'categorias' => $categorias
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //Salvar
         $data = $request->except('_token');
         
         
         
           dd($data);
        
       
       die();
         $validator = $this->validator($data);
           if($validator->fails()){
           return redirect()->route('titulo.create')
                   ->withErrors($validator)
                   ->withInput();       
       }
       
      
       
       // Salva os contratos enviados passando o Id do devedor como chave estrangeira  
        foreach ($data['contrato'] as $contrato) {
            $validator = $this->validatorArray($data);
        }
       
           /*
       Debertor::whereHas('titulo', function ($q) use($value) {
                        $q->where('nome', 'LIKE', '%' . $data[$value] . '%');
                    });
       }
        */
        $devedor = $this->searchAll($dataSearch);
       
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        //
    }

    public function searchAll($data) {

        $query = Titulo::query();
    

        $fields = ( array_filter($data, function($value, $key) {
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

           
                if ($value == 'contrato') {
                    $query->where('contrato', $data[$value]);
                }
            }


            $titulos = $query->with('devedor')->get();
          
            
            if (count($titulos) > 0) {
                return $titulos;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
       protected function validator(array $data){
            
        return Validator::make($data, [
            
                    'creditor' => 'required',
                    'nome' => 'required',
                    'cpf' => 'required','numeric',
                    'data-vencimento' => 'required',
                    'data-geracao' => 'required',
                    'valor' => 'required',
                    'contrato' => 'required',
                    'parcela' => 'required',  
        ]);
        
     
    }

}
