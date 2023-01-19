
@extends('adminlte::page')
@section('title','Pesquisa Títulos')

@section('content')

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
<br>
     <h4 class="text-center">Pesquisa de Titulos</h4>
    
  <form method="GET" action="{{route('titulo.index')}}"> 
            @csrf   
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">Título</h3>
        </div>
        
        
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                    <input type="text" name="contrato" class="form-control" placeholder="titulo">
                </div>
                  <div class="col-1">
                    <div class="form-group">
                        <select class="form-control" name="status" >
                            <option value="">St.</option>
                            <option>A</option>
                            <option>P</option>
                            <option>C</option>
                            <option>S</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <input type="text" name="codigo" class="form-control" placeholder="Cod Devedor">
                </div>
                <div class="col-3">
                    <input type="text" name="cpf" class="form-control" placeholder="Cpf/Cnpj">
                </div>
                <div class="col-4">
                    
                   <div class="input-group ">
                        <div class="input-group-prepend" >
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                    <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                                    <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                            </span>
                        </div>
                       <input type="text" class="form-control " id="calendario"  name="vencimento" placeholder="Data Vencimento">
                    </div>

                </div>
                
            </div> 
            <div class="row">
                <div class="col-3">
                    <div class="form-group" >
                        <label></label>
                        <input type="text" name="nome" class="form-control" placeholder="Nome devedor">
                    </div>
                </div>
                 <div class="col-1">
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="negociacao" >
                            <option value="">ST.</option>
                            <option>N</option>
                            <option>O</option>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="creditor" >
                            <option value="">TP</option>
                            @foreach($credores as $credor)
                            <option>{!! !empty($credor->nome) ? $credor->nome : 'Null' !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
          
                <div class="col-2">
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="category" >
                            <option value="">Categoria</option>
                            @foreach($categorias as $categoria)
                            <option>{!! !empty($categoria->categoria) ? $categoria->categoria : 'Null' !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-4">
                    <label></label>
                   <div class="input-group ">
                        <div class="input-group-prepend" >
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                    <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                                    <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                            </span>
                        </div>
                       <input type="text" class="form-control " id="calendario"  name="data_geracao" placeholder="Data Cadastro">
                    </div>

                </div>
                
            </div>  
          

            <div class="row">

                <div class="col-2">
                    <button name="1" type="submit" class="btn btn-block btn-outline-primary btn-sm" href=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>Pesquisar</button>
                </div>
                <div class="col-2">
                    <a type="button" class="btn btn-block btn-outline-primary btn-sm" href="{{route('titulo.create')}}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                        </svg>Novo</a>
                </div>
                 <div class="col-2">
                    <a type="button" class="btn btn-block btn-outline-primary btn-sm del-titulo"  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        </svg>Excluir</a>
                </div>
            </div>  
        </div>
    </div> 
        

</form>

     <div class="card" id="Pesquisa" >
        <div class="card-body">
            <table class="table table-hover">
                <thead>
    
                    <tr>

                <th ><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">&nbsp;</th>       
                <th >Credor</th>
                <th>Cod.Dev</th>
                <th >Nome</th>
                <th >Título</th>
                <th >Parc.</th>
                <th >Dt.Venc</th>
                <th >Vl.Original</th>
                <th >DataPagamento</th>
                <th >Valor.Pg</th>
                <th >St.</th>
                <th >T/N</th>
                <th ></th>
            </tr>
        </thead>

       @foreach($titulos as $titulo)
       @php
       $credor = $titulo->credor;
       $titulo = $titulo;
       $devedor = $titulo->devedor;
       @endphp
       
            <tbody>
                <tr>

                    <td><input class="form-check-input check-titulo" type="checkbox" value="" id="check-titulo"></td>
                    <td> {!! !empty($credor->nome) ? $credor->nome : 'Null' !!}</td>
                    <td id='codigo'> {!! !empty($devedor->codigo) ? $devedor->codigo : 'Null' !!}</td>
                    <td> {!! !empty($devedor->nome) ? $devedor->nome : 'Null' !!}</td>
                    <td id='contrato'> {!! !empty($titulo->contrato) ? $titulo->contrato : 'Null' !!}</td>
                    <td class="parcela"> {!! !empty($titulo->parcela) ? $titulo->parcela : 'Null' !!}</td>
                    <td>{{ date( 'd/m/Y' , strtotime($titulo->vencimento))}}</td>   
                    <td> {{'R$ '.number_format($titulo->valor, 2, ',', '.') }}  </td>
                    <td>{{$titulo->data_pgto ? date('d/m/Y', strtotime($titulo->data_pgto)) : ''}}</td> 
                    <td> {{'R$ '.number_format($titulo->valor_pgto, 2, ',', '.') }}  </td>
                    <td> {!! !empty($titulo->status) ? $titulo->status : 'Null' !!}</td>
                    <td> {!! !empty($titulo->tipo_negociacao) ? $titulo->tipo_negociacao : 'Null' !!}</td>
                </tr>

            </tbody>
        
      @endforeach
</table>
            
     </div>
</div>
         @if(!empty($titulos))
         
         {{ $titulos->appends([
             'contrato' => $contrato,
             'codigo' => $codigo,
             'cpf' => $cpf,
             'data_pgto' => $data_pgto,
             'nome' => $nome,
             'creditor' => $creditor,
             'category' => $category,
             'data_geracao' => $data_geracao,
             'status' => $status,
             'negociacao' => $negociacao,
                 ])->links() }}
         @endif
    
     
     
<script src="{{asset('/assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="{{asset('vendor/jquery/calendario.js')}}"></script>
<script src="{{asset('vendor/jquery/script.js')}}"></script>



@endsection