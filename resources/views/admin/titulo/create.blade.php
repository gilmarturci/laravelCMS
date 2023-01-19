
@extends('adminlte::page')
@section('title','Novo Titulo')

@section('content_header')

@endsection

@section('content')

<form method="POST" action="{{route('titulo.store')}}" enctype="multipart/form-data"> 
<br><h4>Cadastro de Titulo</h4><br>
 
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


                    <label class="col-sm-1 col-form-label ">Credor:</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="creditor[]" id="select-credor">
                            
                            @foreach($credores as $credor)
                            <option>{!! !empty($credor->nome) ? $credor->nome : 'Null' !!}</option>
                            @endforeach
                            
                            @if(old('creditor'))
                            @for( $i =0; $i < count(old('creditor')); $i++)
                            <option >{!! !empty(old('creditor')) ? old('creditor.'.$i) : '' !!}</option>
                            @endfor
                            @endif
                            
                            
                        </select>
                    </div>
                    <label class="col-sm-1 col-form-label">Nome:</label>
                    <div class="col-sm-4">
                        <div class="input-group mb-3" >
                            <div class="input-group-prepend">
                                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
                                        <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                        <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg></span>
                            </div>
                            <select class="form-control" name="nome[]"  id="select-devedor" >
                                @if(old('nome'))
                                @for( $i =0; $i < count(old('nome')); $i++)
                                <option >{!! !empty(old('nome')) ? old('nome.'.$i) : '' !!}</option>
                                @endfor
                                @endif
                                <option id="option-devedor"></option>
                            </select>
                        </div>
                    </div>
                    <label class="col-sm-1 col-form-label" >Cpf:</label>
                    <div class="col-sm-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-files-alt" viewBox="0 0 16 16">
                                        <path d="M11 0H3a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2 2 2 0 0 0 2-2V4a2 2 0 0 0-2-2 2 2 0 0 0-2-2zm2 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1V3zM2 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V2z"/>
                                    </svg></span>
                            </div>
                            @if(old('cpf'))
                            @for( $i =0; $i < count(old('cpf')); $i++)
                            <input  readonly class="form-control @error('cpf') is-invalid @enderror" name="cpf[]" value="{{ old('cpf.'.$i)}}" id="cpf">
                            @endfor
                           @else
                                <input  readonly class="form-control @error('cpf') is-invalid @enderror" name="cpf[]" id="cpf">
                            @endif
                                    </div>
                    </div>

                </div>

        </div>
      </div>

   

  
   <div class="card" id="Pesquisa">
        <div class="card-body">
            <table class="table table-hover tabela">
                <thead>

                    <tr>

                        <th >Vencimento</th>
                        <th >Valor</th>
                        <th >Contrato</th>
                        <th >Parcela</th>
                        <th >Dt.Geração</th>

                    </tr>
                </thead>

    
                <tbody class="body-titulo">

                     <tr class="info-titulo">
                        @if(old('cpf'))
                        @for( $i =0; $i < count(old('contrato')); $i++)
                        <td><input name="data-vencimento[]" type="date" class="form-control" value="{{ old('data-vencimento.'.$i)}}"></td>
                        <td><input name="valor[]"  id="moeda" type="text" class="form-control" placeholder="R$" value="{{ old('valor.'.$i)}}"> </td>
                        <td> <input name="contrato[]" type="number" class="form-control"  placeholder="Ctr"value="{{ old('contrato.'.$i)}}" ></td>
                        <td><input name="parcela[]" type="number" class="form-control"  placeholder="Pc" value="{{ old('parcela.'.$i)}}"> </td>
                        <td> <input name="data-geracao[]" type="date" class="form-control" value="{{ old('data-geracao.'.$i)}}"></td>
                        <td><button type="button" class="btn btn-block btn-dark btn-flat add-parcela">+</button></td>
                        <td><button type="button" class="btn btn-block btn-danger btn-flat del-parcela">-</button></td>
                         </tr>
                        @endfor
                            @else 
                            <td><input name="data-vencimento[]" type="date" class="form-control"></td>
                            <td><input name="valor[]"  id="moeda" type="text" class="form-control" placeholder="R$" > </td>
                            <td> <input name="contrato[]" type="number" class="form-control"  placeholder="Ctr" ></td>
                            <td><input name="parcela[]" type="number" class="form-control"  placeholder="Pc"> </td>
                            <td> <input name="data-geracao[]" type="date" class="form-control"></td>
                            <td><button type="button" class="btn btn-block btn-dark btn-flat add-parcela">+</button></td>
                            <td><button type="button" class="btn btn-block btn-danger btn-flat del-parcela">-</button></td>
                            </tr>
                            @endif
                  
                
                     
            
            </tbody>
     
</table>
         
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




