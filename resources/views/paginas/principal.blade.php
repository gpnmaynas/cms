@extends('plantilla')

@section('content')

<div class="content-wrapper" style="min-height: 247px;">

    <section class="content-header">

        <div class="container-fluid">

            <div class="bd-example">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                  </ol>
                  <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                      <img class="d-block w-100" data-src="holder.js/900x300?auto=yes&amp;bg=777&amp;fg=555&amp;text=First slide" alt="First slide [900x300]" src="{{url('/')}}/vistas/img/slide1.jpg" data-holder-rendered="true">
                      <div class="carousel-caption d-none d-md-block">
                        <h3>GPN Asignaciones</h3>
                        <p>Registrar las asignaciones para GPN.</p>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" data-src="holder.js/900x300?auto=yes&amp;bg=666&amp;fg=444&amp;text=Second slide" alt="Second slide [900x300]" src="{{url('/')}}/vistas/img/slide2.jpg" data-holder-rendered="true">
                      <div class="carousel-caption d-none d-md-block">
                        <h3>GPN Caja Maynas</h3>
                        <p>Gestión de Procesos de Negocios</p>
                      </div>
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
              
        </div><!-- /.container-fluid -->

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3></h3>
      
                      <p>Avances</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ url("/avances") }}" class="small-box-footer">Disponible <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3></h3>
      
                      <p>Documentos</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ url("/documentos") }}" class="small-box-footer">Disponible <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                    <div class="inner">
                      <h3></h3>
      
                      <p>Observaciones</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ url("/observaciones") }}" class="small-box-footer">Disponible <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-dislabled">
                    <div class="inner">
                      <h3></h3>
      
                      <p>Mi Perfil</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">No Disponible <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
              </div>

        </div>

    </section>
    <!-- /.content -->
</div>


@endsection
