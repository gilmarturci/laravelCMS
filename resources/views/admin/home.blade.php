
@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title','Painel')
@section('content_header')
<h1>Desk Board </h1>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>150</h3>
                <p>Visitantes</p>
            </div>
            <div class="icon">
                <i class="far fa-fw fa-eye"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>



<div class="row">
    <section class="col-lg-6 connectedSortable ui-sortable">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Páginas mais visitadas
                </h3>          
            </div>
             <div class="card-body">
                <canvas id="pie-chart"></canvas>
            </div>
        </div>
    </section>
</div>

<script>
    window.onload = function(){
     let ctx = document.getElementById("pie-chart").getContext('2d');
     window.pagePie = new Chart(ctx,{
        type: 'pie',
        data: {
            labels: {!!$pageLabels!!},
            datasets: [{
                label: "Population (millions)",
                backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                data: {{$pageValues}}   
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Predicted world population (millions) in 2050'
            }
        }
    });
    }
</script>

@endsection