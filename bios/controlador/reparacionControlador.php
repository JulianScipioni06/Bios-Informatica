<?php
require_once "../modelo/reparacion.php";
require_once "../modelo/cliente.php";
require_once "../modelo/equipo.php";

if (!isset($_SESSION)) {
  session_start();
}

class ReparacionControlador extends Reparacion
{
  public function listar()
  {
    $listadoReparacion = $this->buscarPendientes();
    $icl = new Cliente();
    $listadoClientes = $icl->buscar();
    $ieq = new Equipo();
    $listadoEquipos = $ieq->buscar();
    require "../vista/reparaciones/listar.php";
  }

  public function guardarInfoModelo($idCliente, $idEquipo, $fechaInicio, $detalle)
  {
    $this->idCliente = $idCliente;
    $this->idEquipo = $idEquipo;
    $this->fechaInicio = $fechaInicio;
    $this->detalle = $detalle;
    $this->insertar();
  }
}


function consultaCompleta()
{
  echo "<script>
      window.opener.postMessage('consultaCompleta', '*');
      window.close();
    </script>";
}



$ic = new ReparacionControlador();

if (isset($_GET["action"])) {
  if ($_GET["action"] == "listar") {
    $ic->listar();
  }
  if ($_GET["action"] == "terminar") {
    $ic->terminar($_GET["idReparacion"], $_GET["precio"]);
    consultaCompleta();
  }
  if ($_GET["action"] == "editar") {
    $ic->editar($_GET["idReparacion"], $_GET["idCliente"], $_GET["idEquipo"], $_GET["fecha"], $_GET["detalle"]);
    consultaCompleta();
  }
  if ($_GET["action"] == "insertar") {
    if (isset($_GET['idCliente']) && isset($_GET['idEquipo']) && isset($_GET['fechaInicio']) && isset($_GET['detalle'])) {
      $ic->guardarInfoModelo($_GET['idCliente'], $_GET['idEquipo'], $_GET['fechaInicio'], $_GET['detalle']);
			echo "<script>window.opener.location.reload(); window.close();</script>";
    }
    exit;
  }
	if ($_GET["action"] == "eliminar") {
    $ic->eliminar($_GET['idReparacion']);
    consultaCompleta();
  }
}


if (isset($_POST["action"])) {

}

