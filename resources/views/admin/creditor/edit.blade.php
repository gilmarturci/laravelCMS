
@extends('adminlte::page')
@section('title','Editar Credor')

@section('content_header')

@endsection

@section('content')


<br><h4>Editar Credor</h4><br>

    @if($errors->any())  
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>   
   @endif
   
   
   <div class="card">
       <div class="card-body">
           <form method="POST" action="{{route('credor.update',['credor'=>$credor->id])}}"> 
               @method('PUT')
               @csrf

               <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Nome:</label>
                   <div class="col-sm-6">
                       <div class="input-group mb-3">
                           <div class="input-group-prepend">
                               <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-video2" viewBox="0 0 16 16">
                                       <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                       <path d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2ZM1 3a1 1 0 0 1 1-1h2v2H1V3Zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3H5Zm-4-2h3v2H2a1 1 0 0 1-1-1v-1Zm3-1H1V8h3v2Zm0-3H1V5h3v2Z"/>
                                   </svg></span>
                           </div>
                           <input type="text" class="form-control @error('name') is-invalid @enderror" name="nome" value="{{$credor->nome}}">
                       </div>
                   </div>
               </div>
               <div class="form-group row">
                   <label class="col-sm-2 col-form-label">E-mail:</label>
                   <div class="col-sm-6">
                       <div class="input-group mb-3">
                           <div class="input-group-prepend">
                               <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                       <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                   </svg></span>
                           </div>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$credor->email}}">
                       </div>
                   </div>
               </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Telefone:</label>
                   <div class="col-sm-6">
                       <div class="input-group mb-3">
                           <div class="input-group-prepend">
                               <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                       <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                   </svg></span>
                           </div>
                           <input type="tel" class="form-control @error('email') is-invalid @enderror" name="telefone" value="{{$credor->telefone}}">
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

