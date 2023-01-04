
@extends('adminlte::page')
@section('title','Configuração Site')

@section('content_header')
<h1>Painel de Controle </h1>
@endsection

@section('content')

@if($errors->any())  
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>   
@endif

@if (session('warning'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
        </svg></strong> {{ session('warning') }}
</div>
@endif
   
   <div class="card">
       <div class="card-body">
           <form method="POST" action="{{route('settings.save')}}"> 
               @method('PUT')
               @csrf

               <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Titulo:</label>
                   <div class="col-sm-6">
                       <div class="input-group mb-3">
                           <input type="text" class="form-control" name="title" value="{{$settings['title']}}">
                       </div>
                   </div>
               </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Sub Titulo:</label>
                   <div class="col-sm-6">
                       <div class="input-group mb-3">
                           <input type="text" class="form-control" name="subtitle" value="{{$settings['subtitle']}}">
                       </div>
                   </div>
               </div>
               <div class="form-group row">
                   <label class="col-sm-2 col-form-label">E-mail:</label>
                   <div class="col-sm-6">
                       <div class="input-group mb-3">
                           <input type="email" class="form-control" name="email" value="{{$settings['email']}}">
                       </div>
                   </div>
               </div>

             <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Cor do Fundo:</label>
                   <div class="col-sm-1">
                       <div class="input-group mb-3">
                           <input type="color" class="form-control" name="bgcolor" value="{{$settings['bgcolor']}}">
                       </div>
                   </div>
               </div>
               <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Cor do Texto:</label>
                    <div class="col-sm-1">
                       <div class="input-group mb-3">
                           <input type="color" class="form-control" name="textcolor" value="{{$settings['textcolor']}}">
                       </div>
                   </div>
               </div>

               <div class="col-md-10 text-center">
                   <button type="submit" class="btn btn-outline-success">Salvar</button>
               </div>

           </form>
       </div>
   </div>
    
@endsection