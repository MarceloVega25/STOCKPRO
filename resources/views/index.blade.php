@extends('layouts.admin')

@section('content')

<div class="content" style="margin: 20px" >
  <h1>¡¡Bienvenido!!</h1>
  <br>

  <div class="row">
    <div class="col-lg-3">
      <!-- small box -->
      <div class="small-box bg-primary" style="height: 160px">
        <div class="inner">
          <?php $contador_de_producto = 0; ?>
          @foreach ($productos as $producto)
          <?php $contador_de_producto = $contador_de_producto + 1;?>            
          @endforeach
          <h3><?=$contador_de_producto;?></h3>

          <p>Productos</p>
        </div>
        <div class="icon">
          <i class="bi bi-person-badge"></i>
        </div>
        <a href="{{ url('productos') }}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3">
      <!-- small box -->
      <div class="small-box bg-success" style="height: 160px">
        <div class="inner">
          <?php $contador_de_proveedor = 0; ?>
          @foreach ($proveedores as $proveedor)
          <?php $contador_de_proveedor = $contador_de_proveedor + 1;?>            
          @endforeach
          <h3><?=$contador_de_proveedor;?></h3>

          <p>Proveedores</p>
        </div>
        <div class="icon">
          <i class="bi bi-file-earmark-person-fill"></i>
        </div>
        <a href="{{ url('proveedores') }}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3">
      <!-- small box -->
      <div class="small-box bg-warning" style="height: 160px">
        <div class="inner">
          <?php $contador_de_reparto = 0; ?>
          @foreach ($repartos as $reparto)
          <?php $contador_de_reparto = $contador_de_reparto + 1;?>            
          @endforeach
          <h3><?=$contador_de_reparto;?></h3>

          <p>Repartos</p>
        </div>
        <div class="icon">
          <i class="bi bi-people"></i>
        </div>
        <a href="{{ url('repartos') }}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3">
      <!-- small box -->
      <div class="small-box bg-secondary" style="height: 160px">
        <div class="inner">
          <?php $contador_de_vehiculo = 0; ?>
          @foreach ($vehiculos as $vehiculo)
          <?php $contador_de_vehiculo = $contador_de_vehiculo + 1;?>            
          @endforeach
          <h3><?=$contador_de_vehiculo;?></h3>

          <p>Vehículos</p>
        </div>
        <div class="icon">
          <i class="bi bi-person-rolodex"></i>
        </div>
        <a href="{{ url('vehiculos') }}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3">
      <!-- small box -->
      <div class="small-box bg-danger" style="height: 160px">
        <div class="inner">
          <?php $contador_de_vendedor = 0; ?>
          @foreach ($vendedores as $vendedor)
          <?php $contador_de_vendedor = $contador_de_vendedor + 1;?>            
          @endforeach
          <h3><?=$contador_de_vendedor;?></h3>

          <p>Vendedores</p>
        </div>
        <div class="icon">
          <i class="bi bi-person-fill-check"></i>
        </div>
        <a href="{{ url('vendedores') }}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3">
      <!-- small box -->
      <div class="small-box bg-info" style="height: 160px">
        <div class="inner">
          <?php $contador_de_categoria = 0; ?>
          @foreach ($categorias as $categoria)
          <?php $contador_de_categoria = $contador_de_categoria + 1;?>            
          @endforeach
          <h3><?=$contador_de_categoria;?></h3>

          <p>Categorías</p>
        </div>
        <div class="icon">
          <i class="bi bi-journal-text"></i>
        </div>
        <a href="{{ url('categorias') }}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3">
      <!-- small box -->
      <div class="small-box bg-orange" style="height: 160px">
        <div class="inner">
          <?php $contador_de_compra = 0; ?>
          @foreach ($compras as $compra)
          <?php $contador_de_compra = $contador_de_compra + 1;?>            
          @endforeach
          <h3><?=$contador_de_compra;?></h3>

          <p>Compras</p>
        </div>
        <div class="icon">
          <i class="bi bi-clipboard2-check"></i>
        </div>
        <a href="{{ url('compras') }}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
@role('admin|carga')
     <!-- ./col -->
     <div class="col-lg-3">
      <!-- small box -->
      <div class="small-box bg-dark" style="height: 160px">
        <div class="inner">
          <?php $contador_de_informe = 0; ?>
          @foreach ($informes as $informe)
          <?php $contador_de_informe = $contador_de_informe + 1;?>            
          @endforeach
          <h3><?=$contador_de_informe;?></h3>

          <p>Informes</p>
        </div>
        <div class="icon">
          <i class="bi bi-person-workspace"></i>
        </div>
        <a href="{{ route('informes.historico') }}" class="small-box-footer" style="margin-top: 20px">Más información <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
@endrole
  </div>

  </div>

@endsection