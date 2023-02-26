
@extends('adminlte::page')
@section('title','Credor')

@section('content')

@if (session('warning'))
<br>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
        </svg></strong> {{ session('warning') }}
</div>
   
@endif
<br>
    <div class="card" id="pesquisa">
     <div class="card-body">
         <table class="table table-hover">
            <thead>
            <h4 class="text-center">Lista de Credores</h4>
            <tr>

                
                <th >Nome</th>
                <th >Cnpj</th>
                <th >Telefone</th>
                 <th >Ações</th>
                <th ></th>
            </tr>
        </thead>


       
       @foreach($credores as $credor)
            <tbody>
                <tr>

                    <td>{{$credor->nome}}</td>
                    <td>{{$credor->cnpj}}</td>
                    <td>{{$credor->telefone}}</td>
                    <td>
                        <a href="{{route('credor.edit',['credor'=> $credor->id])}}" class="btn btn-sm btn-info"> Editar </a>
                        @if($loggedID != $credor->id)
                        <form class="d-inline" method="POST" action="{{route('credor.destroy',['credor'=> $credor->id])}}" onsubmit="return confirm('Tem certeza que deja excluir este usuário?')">
                            @method('DELETE')
                            @csrf
                            <button  class="btn btn-sm btn-danger">Excluir</button>
                             
                        </form>
                       @endif
                    </td>

                </tr>

            </tbody>
        @endforeach
          <a type="button" class="btn btn-primary mb-2" href="{{route('credor.create')}}">Adicionar Novo</a>
</table>
         
     </div>
</div>

 
       {{ $credores->links() }}  
 
@endsection