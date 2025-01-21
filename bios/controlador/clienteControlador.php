<?php
require_once "../modelo/cliente.php";
require_once "../modelo/equipo.php";

if (!isset($_SESSION)) {
	session_start();
}

class ClienteControlador extends Cliente
{
	public function listar()
	{
		$listadoClientes = $this->buscar();
		$listadoHistorial = $this->buscarHistorial();
		$iEquipo = new Equipo();
		$listadoEquipos = $iEquipo->buscar();
		require "../vista/clientes/listar.php";
	}

	public function guardarInfoModelo($nombreApellido, $telefono)
	{
		$this->nombreApellido = $nombreApellido;
		$this->telefono = $telefono;
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


$ic = new ClienteControlador();

if (isset($_GET["action"])) {
	if ($_GET["action"] == "listar") {
		$ic->listar();
	}

	if ($_GET["action"] == "insertar") {
		if (isset($_GET['nombreApellido']) && isset($_GET['telefono'])) {
			$ic->guardarInfoModelo($_GET['nombreApellido'], $_GET['telefono']);
			echo "<script>window.opener.location.reload(); window.close();</script>";
		}
		exit;
	}

	if ($_GET["action"] == "insertarIndirecto") {
		if (isset($_GET['nombreApellido']) && isset($_GET['telefono'])) {
			$ic->guardarInfoModelo($_GET['nombreApellido'], $_GET['telefono']);
			echo "<script>
				window.opener.postMessage(
        { type: 'consultaCompleta', payload: " . $ic->buscarPorNombre($_GET['nombreApellido'])->idCliente . " },
        'https://tecnicapuan.edu.ar'
    );
				window.close();
			</script>";
		}
		exit;
	}

	if ($_GET["action"] == "editar") {
		$ic->editar($_GET["idCliente"], $_GET["nombreApellido"], $_GET["telefono"]);
		consultaCompleta();
	}

	if ($_GET["action"] == "editarReparacion") {
		$ic->editarReparacion($_GET["idReparacion"], $_GET["idCliente"], $_GET["idEquipo"], $_GET["fechaInicio"], $_GET["fechaEntrega"], $_GET["precio"], $_GET["detalle"]);
		consultaCompleta();
	}

	if ($_GET["action"] == "eliminar") {
		$ic->eliminar($_GET['idCliente']);
		consultaCompleta();
	}
}

if (isset($_POST["action"])) {

}
