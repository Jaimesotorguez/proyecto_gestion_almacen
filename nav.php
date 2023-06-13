<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="https://logisticstrack.es/">Mi Empresa de Transporte</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="https://logisticstrack.es/">Inicio</a>
      </li>
      <?php if($_SESSION['user_role'] == 'admin'): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navAlmacenDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Almacen
            </a>
            <div class="dropdown-menu" aria-labelledby="navAlmacenDropdown">
              <a class="dropdown-item" href="alta_pedido_almacen.php">Alta pedido</a>
              <a class="dropdown-item" href="alta_albaran.php">Alta albaran</a>
              <a class="dropdown-item" href="listado_pedidos.php">Listado pedidos</a>
              <a class="dropdown-item" href="inventario.php">Inventario almacén</a>
              <a class="dropdown-item" href="buscar_pedido.php">Consultar pedido</a>
            </div>
          </li>
      
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navClientesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Clientes
            </a>
            <div class="dropdown-menu" aria-labelledby="navClientesDropdown">
              <a class="dropdown-item" href="alta_cliente.php">Alta cliente</a>
              <a class="dropdown-item" href="listado_clientes.php">Listado de clientes</a>
              <a class="dropdown-item" href="buscar_cliente.php">Consultar cliente</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navServiciosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Servicios
            </a>
            <div class="dropdown-menu" aria-labelledby="navServiciosDropdown">
              <a class="dropdown-item" href="alta_servicios.php">Alta servicio</a>
              <a class="dropdown-item" href="asignar_servicio.php">Alta precio</a>
              <a class="dropdown-item" href="listado_servicios.php">Listado de servicios</a>
              <a class="dropdown-item" href="listado_precios.php">Listado de precios</a>
              <a class="dropdown-item" href="buscar_servicio.php">Consultar servicios</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navRutasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Rutas
            </a>
            <div class="dropdown-menu" aria-labelledby="navRutasDropdown">
              <a class="dropdown-item" href="alta_ruta.php">Alta ruta</a>
              <a class="dropdown-item" href="alta_vehiculo.php">Alta vehículo</a>
              <a class="dropdown-item" href="alta_transportista.php">Alta transportista</a>
              <a class="dropdown-item" href="listado_rutas.php">Listado rutas</a>
              <a class="dropdown-item" href="listado_vehiculos.php">Listado vehiculos</a>
              <a class="dropdown-item" href="listado_transportistas.php">Listado trasportistas</a>
              <a class="dropdown-item" href="bbuscar_ruta.php">Consultar ruta</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navIncidenciasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Incidencias
            </a>
            <div class="dropdown-menu" aria-labelledby="navIncidenciasDropdown">
              <a class="dropdown-item" href="alta_incidencia.php">Alta incidencia</a>
              <a class="dropdown-item" href="listado_incidencias.php">Listado incidencias</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navFacturasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Facturas
            </a>
            <div class="dropdown-menu" aria-labelledby="navFacturasDropdown">
              <a class="dropdown-item" href="cliente_a_facturar.php">Alta factura</a>
              <a class="dropdown-item" href="listado_facturas.php">Listado facturas</a>
              <a class="dropdown-item" href="listado_pedidos_pendientes_facturar.php">Estado facturación de pedidos</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navLiquidacionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Liquidacion
            </a>
            <div class="dropdown-menu" aria-labelledby="navLiquidacionDropdown">
              <a class="dropdown-item" href="alta_liquidacion.php">Alta liquidacion</a>
              <a class="dropdown-item" href="listado_liquidaciones.php">Listado liquidacion</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navCajaDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Caja
            </a>
            <div class="dropdown-menu" aria-labelledby="navCajaDropdown">
              <a class="dropdown-item" href="alta_salida_caja.php">Registrar salida</a>
              <a class="dropdown-item" href="listado_movimientos_caja.php">Movimientos de caja</a>
              <a class="dropdown-item" href="listado_caja_clientes.php">Caja clientes</a>
            </div>
          </li>
      <?php endif; ?>
      
      <?php if($_SESSION['user_role'] == 'cliente'): ?>
      
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navAlmacenDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Almacen
            </a>
            <div class="dropdown-menu" aria-labelledby="navAlmacenDropdown">
              <a class="dropdown-item" href="listado_pedidos.php">Listado pedidos</a>
              <a class="dropdown-item" href="buscar_pedido.php">Consultar pedido</a>
            </div>
        </li>
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navClientesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Clientes
            </a>
            <div class="dropdown-menu" aria-labelledby="navClientesDropdown">
              <a class="dropdown-item" href="buscar_cliente.php">Consultar cliente</a>
            </div>
        </li>
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navCajaDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Caja
            </a>
            <div class="dropdown-menu" aria-labelledby="navCajaDropdown">
              <a class="dropdown-item" href="listado_movimientos_caja.php">Movimientos de caja</a>
            </div>
        </li>
          
          
      
      <?php endif; ?>
    </ul>
  </div>
</nav>
