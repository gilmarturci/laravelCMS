<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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


class DebertorController extends Controller {

    
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
  
        $data = $request->except('_token');
         
        $devedores = $this->searchAll($data);//Faz a pesquisa dos dados enviados no metodo searchAll
        $gerentes = Manager::all();
        $categorias = Category::all();
        $pessoas = Pessoa::all();
        $credores = Creditor::all();
        $loggedID = Auth::id();
        
      
        $dataFilter = array_filter($data); //Exclui tudo que for nulo
        
        return view('admin.debertor.index', [
            'devedores' => $devedores,
            'loggedID' => $loggedID,
            'gerentes' => $gerentes,
            'pessoas' => $pessoas,
            'credores' => $credores,
            'categorias' => $categorias
        ]);
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
    Session::forget('warning');// limpa da sessão o alert warning 
        
  
        $gerentes = Manager::all();
        $categorias = Category::all();
        $pessoas = Pessoa::all();
        $credores = Creditor::all();

          return view('admin.debertor.create', [
            'gerentes' => $gerentes,
            'pessoas' => $pessoas,
            'credores' => $credores,
            'categorias' => $categorias
        ]);
     
    }

    public function store(Request $request) {
        
        //Salvar
         $data = $request->except('_token');
         
         $validator = $this->validator($data);
       
       
          if($validator->fails()){
           return redirect()->route('debertor.create')
                   ->withErrors($validator)
                   ->withInput();       
       }
       
       
       //Faz a pesquisa dos dados enviados no metodo searchAll Se tem o CPF para o credor informado
        $dataSearch = [
            'cpf' => $data['cpf'],
            'creditor' => $data['creditor'],
        ];
       
       $devedores = $this->searchAll($dataSearch);
   
       
       if (!empty($devedores)) {
                return redirect()->route('debertor.create')
                        ->withErrors('Devedor Já Cadastrado para esse Credor')
                         ->withInput();
                        
       } 

        // Faz a inclusão do novo deveror
     
       
        $devedor = new Debertor;
        $devedor->codigo = $data['codigo'];
        $devedor->nome = $data['nome'];
        $devedor->cpf = $data['cpf'];
        $devedor->rg = $data['rg'];
        $id_creditor = Creditor::select('id')->where('nome',$data['creditor'])->first();
        $devedor->creditor_id = $id_creditor->id;
        $id_manager = Manager::select('id')->where('nome',$data['manager'])->first();
        $devedor->manager_id = $id_manager->id;
        $id_pessoa = Pessoa::select('id')->where('tipo',$data['pessoa'])->first();
        $devedor->pessoa_id = $id_pessoa->id;
        $id_category = Category::select('id')->where('categoria',$data['category'])->first();
        $devedor->category_id = $id_category->id;
        $devedor->save();
        
        // Resgata o ID do devedor cadastrado   
        $idfirst = Debertor::select('id')->orderBy('id', 'desc')->first();
  
        // Salva o endereço passando o Id do devedor como chave estrangeira
        $endereco = new Adress;
        $endereco->user_id = $idfirst->id;
        $endereco->cep = $data['cep'];
        $endereco->logadouro = $data['logadouro'];
        $endereco->numero = $data['numero'];
        $endereco->bairro = $data['bairro'];
        $endereco->cidade = $data['cidade'];
        $endereco->uf = $data['uf'];
        $endereco->save();
        
       // Salva os emails enviados passando o Id do devedor como chave estrangeira  
        foreach ($data['email'] as $emails) {
            $email = new Email;
            $email->user_id = $idfirst->id;
            $email->email = $emails;
            $email->status = '1';
            $email->save();
        }
       // Salva os telefones enviados passando o Id do devedor como chave estrangeira  
        foreach ($data['telefone'] as $telefones) {
            $telefone = new Telephone;
            $telefone->user_id = $idfirst->id;
            $telefone->numero = $telefones;
            $telefone->status = '1';
            $telefone->save();
        }

       // redireciona para a tela de cadastro de devedores
        Session::flash('success', 'Cadastro realizado com sucesso!');
        return redirect()->route('debertor.create');
        

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
         $debertor = Debertor::find($id);
         $gerentes = Manager::all();
         $categorias = Category::all();
         $pessoas = Pessoa::all();
         $credores = Creditor::all();
         $email = Email::where('user_id', $id)->get();
         $telefone = Telephone::where('user_id', $id)->get(); 
        
        if(!empty($debertor)){
            return view('admin.debertor.edit',[
                'debertor' => $debertor,
                'gerentes' => $gerentes,
                'categorias' => $categorias,
                'pessoas' => $pessoas,
                'credores' => $credores,
                'email' => $email,
                'telefone' => $telefone,
                
            ]);  
        }
        return redirect()->route('debertor.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        
        
        $devedor = Debertor::find($id);
        $endereco = Adress::where('user_id', $id)->first();
        $dbemail = Email::where('user_id', $id)->get();
        $debertor = Debertor::find($id);
        $gerentes = Manager::all();
        $categorias = Category::all();
        $pessoas = Pessoa::all();
        $credores = Creditor::all();
        $email = Email::where('user_id', $id)->get();
        $telefone = Telephone::where('user_id', $id)->get();


        $data = $request->except('_token');
        
        $validator = $this->validator($data);
        

       //Alteração do e-mail
        if($validator->fails()){
            return view('admin.debertor.edit',[
                'debertor' => $debertor,
                'gerentes' => $gerentes,
                'categorias' => $categorias,
                'pessoas' => $pessoas,
                'credores' => $credores,
                'email' => $email,
                'telefone' => $telefone,
            ])->withErrors($validator);
                 
       }
      
       
     if (isset($data['email'])) {
            foreach ($data['email'] as $emails) {
                $email = new Email;
                $email->user_id = $devedor->id;
                $email->email = $emails;
                $email->status = '1';
                $email->save();
            }
        }

        //Alteraçoes
        
        $id_creditor = Creditor::select('id')->where('nome', $data['creditor'])->first();
    
        $devedor->creditor_id = $id_creditor->id;
        $id_manager = Manager::select('id')->where('nome', $data['manager'])->first();
        $devedor->manager_id = $id_manager->id;
        $id_pessoa = Pessoa::select('id')->where('tipo', $data['pessoa'])->first();
        $devedor->pessoa_id = $id_pessoa->id;
        $id_category = Category::select('id')->where('categoria', $data['category'])->first();
        $devedor->category_id = $id_category->id;

        $devedor->codigo = $data['codigo'];
        $devedor->nome = $data['nome'];
        $devedor->cpf = $data['cpf'];
        $devedor->rg = $data['rg'];
        $endereco->cep = $data['cep'];
        $endereco->logadouro = $data['logadouro'];
        $endereco->numero = $data['numero'];
        $endereco->bairro = $data['bairro'];
        $endereco->cidade = $data['cidade'];
        $endereco->uf = $data['uf'];


        //Salvar
        $devedor->save();
        $endereco->save();
        

         return redirect()->route('debertor.index')
                ->with('success','Informações alteradas com Sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $devedor = Debertor::find($id);

        //verifica se tem titulos cadastrados para o devedor
        $titulo = Titulo::select('id')->where('debertor_id', $devedor->id)->get();
        if (count($titulo) > 0) {

            return redirect()->route('debertor.index')
                            ->withErrors('Erro: Titulo Cadastrado para esse Devedor');
        } else {
            //busca os emails do devedor
            $id_email = Email::select('id')->where('user_id', $devedor->id)->first();
            $email = Email::find($id_email->id);
            //busca os telefones do devedor
            $id_telefone = Telephone::select('id')->where('user_id', $devedor->id)->first();
            $telefone = Telephone::find($id_telefone->id);

            $email->delete();
            $telefone->delete();
            $devedor->delete();
            
            Session::flash('success', 'Cadastro excluido com sucesso!');
            return redirect()->route('debertor.index');
        }
    }
    
    protected function validator(array $data){
            
        return Validator::make($data, [
            
                    'creditor' => 'required',
                    'pessoa' => 'required',
                    'codigo' => 'required', 'integer',
                    'nome' => 'required', 'string', 'max:100',
                    'cpf' => 'required', 'min:11',
                    'rg' => 'required',
                    'numero' => 'required', 'integer',
                    'logadouro' => 'required',
                    'bairro' => 'required',
                    'email.*' => 'nullable|email',
                    'telefone.*' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
                   
        ]);
        
     
    }

    public function searchAll($data) {
        
        $query = Debertor::query();

        $fields = ( array_filter($data, function($value, $key) {
                    return $value != null; // retorna todos os valores que forem diferentes de null
                }, ARRAY_FILTER_USE_BOTH) );

        if (!empty($fields)) {
            Session::forget('warning');
            
            
            
            foreach ($fields as $value => $key) {
                
                if ($value == 'nome'){
                        $query->where($value, 'LIKE', '%' . $data[$value] . '%');
                }
                if ($value == 'codigo'){
                        $query->where('codigo',$data[$value] );
                }
                if ($value == 'cpf'){
                        $query->where('cpf',$data[$value] );
                }
                 if ($value == 'manager') {
                    $query->whereHas('gerente', function ($q) use($data, $value) {
                        $q->where('nome', 'LIKE', '%' . $data[$value] . '%');
                    });
                    
                   
                }
                if ($value == 'created_at') {

                    $date = explode('-', $key);

                    $startdate = $date[0];
                    $startdate = strtr($startdate, '/', '-');
                    $startdate = date('Y-m-d', strtotime($startdate)); // convet formato de data

                    $endDate = $date[1];
                    $endDate = strtr($endDate, '/', '-');
                    $endDate = date('Y-m-d', strtotime($endDate)); // convet formato de data


                    $query->whereBetween($value, [$startdate, $endDate])->get();
                    
                   
                }
            }



            $devedores = $query->paginate();
          
            if (count($devedores) > 0) {
                
                
                return $devedores;
            } else {
                return array();
            }
        }else{
            return array();
        }
    }
    


}
