<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
       
    }
    
      public function index()
    {
        //Identifica o ID do usuário Logado
        $loggedID = intval(Auth::id());
        
        //Busca no banco o usuario pelo ID
        $user = User::find($loggedID);
        
        if($user){
            
            return view('admin.profile.index',[
                'user' => $user,
            ]);
        }
        
        return redirect()->rote('painel');

    }
      public function save(Request $request) {
        
        $loggedID = intval(Auth::id());
        
        $user = User::find($loggedID);
        
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $validator = validator::make([
                    'name' => $data['name'],
                    'email' => $data['email'],
                        ],
                        [
                            'name' => ['required', 'string', 'max:100'],
                            'email' => ['required', 'string', 'email', 'max:200'],
        ]);

        //Alteração do nome
        $user->name = $data['name'];

        //Alteração do e-mail
        if ($user->email != $data['email']) {

            $hasEmail = User::where('email', $data['email'])->get(); //verifica se o Email já existe         
            if (count($hasEmail) === 0) {
                $user->email = $data['email'];
            } else {

                $validator->errors()->add('email', 'Este E-mail já está em uso');
            }
        }
        //Alteração da senha

        if (!empty($data['password'])) {
            if (strlen($data['password']) >= 4) {
                if ($data['password'] === $data['password_confirmation']) {
                    $user->password = Hash::make($data['password']);
                } else {
                    $validator->errors()->add('password', 'A senhas estão divirgentes');
                }
            } else {
                $validator->errors()->add('password', 'A senha deve conter no minimo 4 caracteres');
            }
        }

        if (count($validator->errors()) > 0) {

            return redirect()->route('profile', [
                        'user' => $loggedID
                    ])->withErrors($validator);
        }

        $user->save();
        
        
        return redirect()->route('profile')
            ->with('warning','Informações alteradas com Sucesso!');
        
    }
    

}
