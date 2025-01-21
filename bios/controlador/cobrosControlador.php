<?php
require_once "../modelo/reparacion.php";
require_once "../modelo/cliente.php";
require_once "../modelo/equipo.php";

if (!isset($_SESSION)) {
  session_start();
}

class CobrosControlador extends Reparacion
{
  public function listar()
  {
    $listadoReparacion = $this->buscarCobros();
    $icl = new Cliente();
    $listadoClientes = $icl->buscar();
    $ieq = new Equipo();
    $listadoEquipos = $ieq->buscar();
    require "../vista/cobros/listar.php";
  }
}


function consultaCompleta()
{
  echo "<script>
      window.opener.postMessage('consultaCompleta', '*');
      window.close();
    </script>";
}



$ic = new CobrosControlador();

if (isset($_GET["action"])) {
  if ($_GET["action"] == "listar") {
    $ic->listar();
  }
  if ($_GET["action"] == "cobrar") {
    $ic->cobrar($_GET["idReparacion"], $_GET["fechaEntrega"], $_GET["precio"]);
    consultaCompleta();
  }
  if ($_GET["action"] == "editar") {
    $ic->editarCobro($_GET["idReparacion"],  $_GET["idCliente"], $_GET["idEquipo"], $_GET["fechaInicio"], $_GET["precio"], $_GET["detalle"]);
    consultaCompleta();
  }
}
if (isset($_POST["action"])) {
  if ($_POST["action"] == "") {

  }
}


