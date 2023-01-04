
@extends('adminlte::page')
@section('title','Novo Página')

@section('content_header')

@endsection

@section('content')


<br><h4>Cadastro nova Página</h4><br>

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
           <form method="POST" action="{{route('pages.store')}}"> 
               @csrf

               <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Título:</label>
                   <div class="col-sm-6">
                       <div class="input-group mb-3">
                           <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{old('title')}}">
                       </div>
                   </div>
               </div>
              
               <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Corpo:</label>
                   <div class="col-sm-9">
                       <div class="input-group mb-3">
                           <textArea name="body" class="form-control bodyfield"> {{old('body')}}  </textArea>
                                  </div>
                             </div>
                           </div>


               <div class="col-md-10 text-center">
                   <button type="submit" class="btn btn-outline-success">Cadastrar</button>
               </div>

           </form>
       </div>
   </div>
     <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
   <script>
       tinymce.execCommand('mceRemoveControl',true,'editor_id');
       </script>
   <script>
       
   tinymce.init({
       selector:'textarea.bodyfield',  
       height:300,
       menubar:false,
       plugins:['link', 'table', 'image', 'autoresize', 'lists'],
       toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustiy | table | link image |bullist numlist',
       content_css:[
          '{{asset('assets/css/content.css')}}'
       ],
       images_upload_url:'{{route('imageupload')}}',
       images_upload_credentials:true,
       convert_urls:false
   });
   
   </script>

@endsection

