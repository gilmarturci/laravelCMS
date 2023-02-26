<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\Category;
use App\Models\Pessoa;
use App\Models\Creditor;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class CreditorController extends Controller
{
    
    
   public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $creditor = Creditor::paginate(5);
        
        $loggedID = Auth::id();
        return view('admin.creditor.index',[
            'credores' => $creditor,
            'loggedID' => $loggedID
            
        ]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $gerentes = Manager::all();
        $categorias = Category::all();
        $pessoas = Pessoa::all();
        $credores = Creditor::all();

          return view('admin.creditor.create', [
            'gerentes' => $gerentes,
            'pessoas' => $pessoas,
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
    public function store(Request $request)
    {
        
         
        $data = $request->only([
            'nome',
            'email',
            'telefone'
           
        ]);
        
    
        $validator = $this->validator($data);
        
 
        if($validator->fails()){
           return redirect()->route('credor.create')
                   ->withErrors($validator)
                   ->withInput();
       }
       
        $creditor = new Creditor;
        $creditor->nome = $data['nome'];
        $creditor->email = $data['email'];
        $creditor->telefone = $data['telefone'];
        $creditor->save();

        return redirect()->route('credor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

       $creditor = Creditor::find($id);
        if($creditor){
            return view('admin.creditor.edit',[
                'credor' => $creditor
            ]);  
        }
        return redirect()->route('creditor.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        
         $creditor = Creditor::find($id);
        $data = $request->only([
            'nome',
            'email',
            'telefone'
            
        ]);
        
        
     
         $validator = validator::make([
                    'nome' => $data['nome'],
                    'email' => $data['email'],
                        ],
                        [
                            'nome' => ['required', 'string', 'max:100'],
                            'email' => ['required', 'string', 'email', 'max:200'],
                ]);
        
         $creditor->nome = $data['nome'];
         $creditor->email = $data['email'];
         $creditor->telefone = $data['telefone'];
         $creditor->save();
         
         return redirect()->route('credor.index')
                ->with('warning','Informações alteradas com Sucesso!');
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedID = Auth::id();
        
        if( $loggedID != $id){
            $creditor = Creditor::find($id);
            $creditor->delete();
        }
        
        return redirect()->route('credor.index')
        
                
                ->with('warning','Informações exluida com Sucesso!');
    }
       
    
    protected function validator(array $data) {
        return Validator::make($data, [
                    'nome' => ['required', 'string', 'max:100'],
                    'email' => ['required', 'string', 'email', 'max:200', 'unique:creditors'],
                    
        ]);
    }

}
