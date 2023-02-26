<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class ManagerController extends Controller
{
    
    
   public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        
       
        $manager = Manager::paginate(5);
        
        $loggedID = Auth::id();
        return view('admin.manager.index',[
            'gerentes' => $manager,
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
     return view('admin.manager.create'); 
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
           return redirect()->route('gerente.create')
                   ->withErrors($validator)
                   ->withInput();
       }
       
        $manager = new Manager;
        $manager->nome = $data['nome'];
        $manager->email = $data['email'];
        $manager->telefone = $data['telefone'];
        $manager->save();

        return redirect()->route('gerente.index');
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

       $manager = Manager::find($id);
        if($manager){
            return view('admin.manager.edit',[
                'gerente' => $manager
            ]);  
        }
        return redirect()->route('manager.index');
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
        
        
         $manager = Manager::find($id);
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
        
         $manager->nome = $data['nome'];
         $manager->email = $data['email'];
         $manager->telefone = $data['telefone'];
         $manager->save();
         
         return redirect()->route('gerente.index')
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
            $manager = Manager::find($id);
            $manager->delete();
        }
        
        return redirect()->route('gerente.index')
        
                
                ->with('warning','Informações exluida com Sucesso!');
    }
       
    
    protected function validator(array $data) {
        return Validator::make($data, [
                    'nome' => ['required', 'string', 'max:100'],
                    'email' => ['required', 'string', 'email', 'max:200', 'unique:managers'],
                    
        ]);
    }

}
