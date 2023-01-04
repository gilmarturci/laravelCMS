<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    
     public function __construct()
    {
       $this->middleware('auth');
    }
    
    
    public function index()
    {
        
        $pagePie = [
             'Teste 1 ' => 100,
             'Teste 2 ' => 200,
             'Teste 3 ' => 300,
             'Teste 4 ' => 400,
        ];
                
        $pageLabels = json_encode(array_keys($pagePie));
        $pageValues = json_encode(array_values($pagePie));
        
        return view('admin.home',[
            'pageLabels' => $pageLabels,
            'pageValues' => $pageValues
        ]);
    }
}
