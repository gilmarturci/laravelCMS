
@extends('adminlte::page')
@section('title','Novo Devedor')

@section('content_header')

@endsection

@section('content')

<form method="POST" action="{{route('debertor.store')}}"> 
<br><h4>Cadastro de Devedor</h4><br>
 
                @csrf

    @if($errors->any())  
    <div class="alert alert-warning">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>   
   @endif
   
   @if (session('warning'))
   <br>
       <div class="alert alert-warning   alert-dismissible" role="alert">
           <button type="button" class="close" data-dismiss="alert">
               <i class="fa fa-times"></i>
           </button>
           <strong><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                   <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
               </svg></strong> {{ session('warning') }}
       </div>
       @endif
        @if (session('success'))
   <br>
       <div class="alert alert-success   alert-dismissible" role="alert">
           <button type="button" class="close" data-dismiss="alert">
               <i class="fa fa-times"></i>
           </button>
           <strong><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                   <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
               </svg></strong> {{ session('success') }}
       </div>
       @endif

       <button id="showDadosPessoais" type="button" class="btn btn-block btn-danger btn-xs">Dados Cadastral </button></br>
    
    <div class="card" >
        <div class="card-body" id='DadosPessoais'>
           
                <div class="form-group row">

                    <label class="col-sm-1 col-form-label">Gerente:</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="manager" ">
                            <option >{!! !empty(old('manager')) ? old('manager') : '' !!}</option>
                            @foreach($gerentes as $gerente)
                            <option>{!! !empty($gerente->nome) ? $gerente->nome : 'Null' !!}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="col-sm-1 col-form-label">Credor:</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="creditor" >
                            <option >{!! !empty(old('creditor')) ? old('creditor') : '' !!}</option>
                            @foreach($credores as $credor)
                            <option>{!! !empty($credor->nome) ? $credor->nome : 'Null' !!}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="col-sm-1 col-form-label">Categoria</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="category" >
                              <option >{!! !empty(old('category')) ? old('category') : '' !!}</option>
                            @foreach($categorias as $categoria)
                            <option>{!! !empty($categoria->categoria) ? $categoria->categoria : 'Null' !!}</option>
                            @endforeach
                        </select>
                    </div>


                    <label class="col-sm-1 col-form-label">Pessoa:</label>
                    <div class="col-sm-1">
                        <select class="form-control" name="pessoa">
                            <option >{!! !empty(old('pessoa')) ? old('pessoa') : '' !!}</option>
                            @foreach($pessoas as $pessoa)
                            <option>{!! !empty($pessoa->tipo) ? $pessoa->tipo : 'Null' !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label">Código:</label>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upc-scan" viewBox="0 0 16 16">
                                        <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5zM3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-7zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7z"/>
                                    </svg></span>
                            </div>
                            <input type="number" class="form-control @error('name') is-invalid @enderror" name="codigo" value="{{old('codigo')}}">
                        </div>
                    </div>
                    <label class="col-sm-1 col-form-label">Nome:</label>
                    <div class="col-sm-7">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
                                        <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                        <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg></span>
                            </div>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="nome" value="{{old('nome')}}">
                        </div>
                    </div>
                </div>
       
               <div class="form-group row">
                   <label class="col-sm-1 col-form-label">Cpf:</label>
                   <div class="col-sm-4">
                      <div class="input-group mb-3">
                           <div class="input-group-prepend">
                               <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-files-alt" viewBox="0 0 16 16">
                                       <path d="M11 0H3a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2 2 2 0 0 0 2-2V4a2 2 0 0 0-2-2 2 2 0 0 0-2-2zm2 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1V3zM2 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V2z"/>
                                   </svg></span>
                           </div>
                          <input  class="form-control @error('name') is-invalid @enderror" name="cpf" value="{{old('cpf')}}" id="cpf">
                       </div>
                   </div>
              
                   <label class="col-sm-1 col-form-label">RG:</label>
                   <div class="col-sm-5">
                       <div class="input-group mb-3">
                           <div class="input-group-prepend">
                               <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-video2" viewBox="0 0 16 16">
                                       <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                       <path d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2ZM1 3a1 1 0 0 1 1-1h2v2H1V3Zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3H5Zm-4-2h3v2H2a1 1 0 0 1-1-1v-1Zm3-1H1V8h3v2Zm0-3H1V5h3v2Z"/>
                                   </svg></span>
                           </div>
                           <input class="form-control @error('name') is-invalid @enderror" name="rg" value="{{old('rg')}}" id="rg" >
                       </div>
                   </div>
               </div>


          
       </div>
   </div>
   
  
    
    
    <button id="showEndereco" type="button" class="btn btn-block btn-danger btn-xs">Endereço </button></br>
    
<div class="card" >
    <div class="card-body collapse in" id='enderecocollapse'>
        <div class="form-group row">
            <label class="col-sm-1 col-form-label">Cep:</label>
            <div class="col-sm-2">
                <div class="input-group mb-3">
                    <input  type="text" class="form-control @error('name') is-invalid @enderror" name="cep" value="{{old('cep')}}" id="cep">
                </div>
            </div>
            <label class="col-sm-1 col-form-label">Endereço:</label>
            <div class="col-sm-5">
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="logadouro" value="{{old('logadouro')}}" id="logadouro">
                </div>
            </div>
             <label class="col-sm-1 col-form-label">UF:</label>
            <div class="col-sm-1">
                      <div class="input-group mb-3">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="uf" value="{{old('uf')}}" id="uf">
                        </div>
            </div>
        </div>
                 <div class="form-group row">
                      <label class="col-sm-1 col-form-label">Bairro:</label>
                   <div class="col-sm-3">
                      <div class="input-group mb-3">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="bairro" value="{{old('bairro')}}" id="bairro">
                        </div>
                   </div>
                   <label class="col-sm-1 col-form-label">Cidade:</label>
                   <div class="col-sm-3">
                      <div class="input-group mb-3">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="cidade" value="{{old('cidade')}}" id="cidade">
                        </div>
                   </div>
                    <label class="col-sm-1 col-form-label">Numero:</label>
                   <div class="col-sm-2">
                      <div class="input-group mb-3">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" name="numero" value="{{old('numero')}}">
                        </div>
                   </div>
                   
               </div>
                
            </div>
        </div>

  
   <button id="showEmail" type="button" class="btn btn-block btn-danger btn-xs">Email </button></br>

    <div class="card" >
        <div class="card-body collapse in" id='emailcollapse'>
            <div class="form-group row">
                

                @if(old('email'))
                <div class="col-sm-12">
                    <div class="input-group mb-3" id="email">
                        <button id="novoEmail" type="button" class="btn btn-block btn-dark btn-flat">+</button>
                    </div>
                </div>
                @for( $i =0; $i < count(old('email')); $i++) 
                <div class="col-sm-12 align-items-center" >
                    <div class="input-group mb-3" >
                        <input type="" class="form-control @error('name') is-invalid @enderror " name="email[]" value="{{ old('email.'.$i)}}">
                    </div>
                </div> 

                @endfor

                @else
                <label class="col-sm-1 col-form-label">Email</label>
                <div class="col-sm-8">
                    <div class="input-group mb-3" id="email">
                        <input type="text" class="form-control @error('name') is-invalid @enderror " name="email[]" value="">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="input-group mb-3" id="email">
                        <button id="novoEmail" type="button" class="btn btn-block btn-dark btn-flat">+</button>
                    </div>
                </div>

                @endif
               
            </div>
        </div>
    </div>
    
           <button id="showFone" type="button" class="btn btn-block btn-danger btn-xs">Telefone </button></br>
     <div class="card" >
        <div class="card-body collapse in" id='telefonecollapse'>
            <div class="form-group row">
                

                @if(old('telefone'))
                <div class="col-sm-12">
                    <div class="input-group mb-3" id="fone">
                        <button id="novoFone" type="button" class="btn btn-block btn-dark btn-flat">+</button>
                    </div>
                </div>
                @for( $i =0; $i < count(old('telefone')); $i++) 
                <div class="col-sm-12 align-items-center" >
                    <div class="input-group mb-3" >
                        <input id='fixo' type="" class="form-control @error('name') is-invalid @enderror " name="telefone[]" value="{{ old('telefone.'.$i)}}">
                    </div>
                </div> 

                @endfor

                @else
               <label class="col-sm-1 col-form-label">Fone</label>
                <div class="col-sm-8">
                    <div class="input-group mb-3" id="fone">
                        <input type="fone" class="form-control @error('name') is-invalid @enderror " name="telefone[]" id="celular">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="input-group mb-3">
                        <button id="novoFone" type="button" class="btn btn-block btn-dark btn-flat">+</button>
                    </div>
                </div>

                @endif
               
            </div>
        </div>
    </div>
         

               <div class="col-md-12 text-center">
                   <button type="submit" class="btn btn-outline-success">Salvar</button><br><br>
               </div>
 </form>

<script src="{{asset('/assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
<script src="{{asset('vendor/jquery/script.js')}}"></script>
<script src="{{asset('vendor/jquery/jquery.mask.js')}}"></script>


@endsection




