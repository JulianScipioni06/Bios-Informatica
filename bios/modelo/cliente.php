<?php
require_once "../bd/conexion.php";

class Cliente
{
  protected $idCliente;
  protected $nombreApellido;
  protected $telefono;



  public function insertar()
  {
    $ic = new Conexion();
    $sql = "INSERT INTO clientes(nombreApellido, telefono) VALUES (?,?)";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $this->nombreApellido);
    $stmt->bindParam(2, $this->telefono);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Cliente insertado correctamente.";
    } else {
      $_SESSION['action'] = "Error al insertar el cliente: " . $stmt->errorInfo()[2];
    }
  }

  public function editar($idCliente, $nombreApellido, $telefono)
  {
    $ic = new Conexion();
    $sql = "UPDATE clientes SET nombreApellido = ?, telefono = ? WHERE idCliente = ?";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $nombreApellido);
    $stmt->bindParam(2, $telefono);
    $stmt->bindParam(3, $idCliente);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Cliente editado correctamente.";
    } else {
      $_SESSION['action'] = "Error al editar el cliente: " . $stmt->errorInfo()[2];
    }
  }

  public function editarReparacion($idReparacion, $idCliente, $idEquipo, $fechaInicio, $fechaEntrega, $precio, $detalle)
  {
    $ic = new Conexion();
    $sql = "UPDATE reparaciones SET idCliente=?, idEquipo=?, fechaInicio=?, fechaEntrega=?, precio=?, detalle=? WHERE idReparacion = ?";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $idCliente);
    $stmt->bindParam(2, $idEquipo);
    $stmt->bindParam(3, $fechaInicio);
    $stmt->bindParam(4, $fechaEntrega);
    $stmt->bindParam(5, $precio);
    $stmt->bindParam(6, $detalle);
    $stmt->bindParam(7, $idReparacion);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Reparacion editada correctamente.";
    } else {
      $_SESSION['action'] = "Error al editar la reparacion: " . $stmt->errorInfo()[2];
    }
  }

  public function buscar()
  {
    $ic = new Conexion();
    $sql = "SELECT * FROM clientes";
    $query = $ic->db->prepare($sql);
    $query->execute();
    $numrows = $query->rowCount();

    if ($numrows > 0) {
      $objetoConsulta = $query->fetchAll(PDO::FETCH_OBJ);
    } else {
      $objetoConsulta = null;
    }
    return $objetoConsulta;
  }

  public function buscarPorId($idCliente)
  {
    $ic = new Conexion();
    $sql = "SELECT * FROM clientes WHERE idCliente = '$idCliente'";
    $query = $ic->db->prepare($sql);
    $query->execute();
    $numrows = $query->rowCount();

    if ($numrows > 0) {
      $objetoConsulta = $query->fetchAll((PDO::FETCH_OBJ));
    } else {
      $objetoConsulta = null;
    }
    return $objetoConsulta;
  }

  public function buscarPorNombre($nombreApellido)
  {
    $ic = new Conexion();
    $sql = "SELECT * FROM clientes WHERE nombreApellido = '$nombreApellido'";
    $query = $ic->db->prepare($sql);
    $query->execute();
    $numrows = $query->rowCount();

    if ($numrows > 0) {
      $objetoConsulta = $query->fetchAll((PDO::FETCH_OBJ));
    } else {
      $objetoConsulta = null;
    }
    return $objetoConsulta;
  }

  public function buscarHistorial()
  {
    $ic = new Conexion();
    $sql = "SELECT r.*, c.nombreApellido, e.nombre as equipo
    FROM reparaciones AS r
    INNER JOIN clientes AS c ON c.idCliente = r.idCliente
    INNER JOIN equipos AS e ON e.idEquipo = r.idEquipo
    WHERE fechaEntrega IS NOT NULL
    AND completada =! 0
    AND precio IS NOT NULL";
    $query = $ic->db->prepare($sql);

    $query->execute();
    $numrows = $query->rowCount();
    if ($numrows > 0) {
      $objetoConsulta = $query->fetchAll(PDO::FETCH_OBJ);
    } else {
      $objetoConsulta = null;
    }
    return $objetoConsulta;
  }

  public function eliminar($idCliente)
  {
    $ic = new Conexion();
    $sql = "DELETE FROM clientes WHERE idCliente = ?";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $idCliente);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Cliente eliminado correctamente.";
    } else {
      $_SESSION['action'] = "Error al eliminar el cliente: " . $stmt->errorInfo()[2];
    }
  }

}