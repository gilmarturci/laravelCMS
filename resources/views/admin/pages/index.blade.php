
@extends('adminlte::page')
@section('title','Páginas')

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
 <div class="card">
     <div class="card-body">
         <table class="table table-hover">
            <thead>
            <h4 class="text-center">Lista de Páginas</h4>
            <tr>

                <th >ID</th>
                <th >Título</th>
                <th width="300">Ações</th>
                
            </tr>
        </thead>


       
       @foreach($pages as $page)
            <tbody>
                <tr>

                    <td>{{$page->id}}</td>
                    <td>{{$page->title}}</td>
                    <td>
                        <a href="" target="_blank" class="btn btn-sm btn-success"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg></a>
                        <a href="{{route('pages.edit',['page'=> $page->id])}}" class="btn btn-sm btn-info"> Editar </a>
                       
                        <form class="d-inline" method="POST" action="{{route('pages.destroy',['page'=> $page->id])}}" onsubmit="return confirm('Tem certeza que deja excluir esta página?')">
                            @method('DELETE')
                            @csrf
                            <button  class="btn btn-sm btn-danger">Excluir</button>
                             
                        </form>
                    
                    </td>

                </tr>

            </tbody>
        @endforeach
          <a type="button" class="btn btn-primary mb-2" href="{{route('pages.create')}}">Adicionar Novo</a>
</table>
         
     </div>
</div>


   {{ $pages->links() }}       
    
@endsection