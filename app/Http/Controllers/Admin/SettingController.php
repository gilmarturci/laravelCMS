<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
class SettingController extends Controller
{
   
    public function __construct()
    {
       $this->middleware('auth');
     
    }
    
       public function index()
    {
           $settings = [];
           $dbsettings = Setting::get();
         
           foreach ($dbsettings as $dbsetting){
               $dbsettings[$dbsetting['name']] = $dbsetting['content'];
           }
          return view('admin.settings.index',[
             'settings' => $dbsettings
          ]);  
           
        
    }
     public function save(Request $request)
    {
        $data = $request->only([
            'title',
            'subtitle',
            'email',
            'bgcolor',
            'textcolor'
        ]);
        $validator = $this->validator($data); 
        
        if($validator->fails()){
              return redirect()->route('settings')
                   ->withErrors($validator);
       }
       
       foreach ($data as $item => $value){
           Setting::where('name', $item)->update([
               'content' => $value
           ]);
       }
            
        return redirect()->route('settings')
                ->with('warning','Informações alteradas com Sucesso!');
        
     }
     
     
      protected function validator(array $data)
    {
         
         
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:100'],
            'subtitle' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users'],
            'bgcolor' => ['string', 'regex:/#[A-Z0-9]{6}/i'],
            'textcolor' => ['string', 'regex:/#[A-Z0-9]{6}/i']
            
        ]);
    }
}
