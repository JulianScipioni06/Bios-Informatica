<?php
require_once "../bd/conexion.php";

class Reparacion
{
  protected $idReparacion;
  protected $idCliente;
  protected $idEquipo;
  protected $fechaInicio;
  protected $fechaEntregada;
  protected $precio;
  protected $detalle;
  protected $completada;


  public function insertar()
  {
    $ic = new Conexion();
    $sql = "INSERT INTO reparaciones(idCliente, idEquipo, fechaInicio, detalle) VALUES (?,?,?,?)";

    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $this->idCliente);
    $stmt->bindParam(2, $this->idEquipo);
    $stmt->bindParam(3, $this->fechaInicio);
    $stmt->bindParam(4, $this->detalle);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Reparacion insertada correctamente.";
    } else {
      $_SESSION['action'] = "Error al insertar la reparacion: " . $stmt->errorInfo()[2];
    }
  }

  public function editar($idReparacion, $idCliente, $idEquipo, $fechaInicio, $detalle)
  {
    $ic = new Conexion();
    $sql = "UPDATE reparaciones SET idCliente=?, idEquipo=?, fechaInicio=?, detalle=? WHERE idReparacion = ?";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $idCliente);
    $stmt->bindParam(2, $idEquipo);
    $stmt->bindParam(3, $fechaInicio);
    $stmt->bindParam(4, $detalle);
    $stmt->bindParam(5, $idReparacion);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Reparacion editada correctamente.";
    } else {
      $_SESSION['action'] = "Error al editar la reparacion: " . $stmt->errorInfo()[2];
    }
  }

  public function editarCobro($idReparacion, $idCliente, $idEquipo, $fechaInicio, $precio, $detalle)
  {
    $ic = new Conexion();
    $sql = "UPDATE reparaciones SET idCliente=?, idEquipo=?, fechaInicio=?, precio=?, detalle=? WHERE idReparacion = ?";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $idCliente);
    $stmt->bindParam(2, $idEquipo);
    $stmt->bindParam(3, $fechaInicio);
    $stmt->bindParam(4, $precio);
    $stmt->bindParam(5, $detalle);
    $stmt->bindParam(6, $idReparacion);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Reparacion editado correctamente.";
    } else {
      $_SESSION['action'] = "Error al editar el reparacion: " . $stmt->errorInfo()[2];
    }
  }

  public function terminar($idReparacion, $precio)
  {
    $ic = new Conexion();
    $sql = "UPDATE reparaciones SET precio=?, completada=1 WHERE idReparacion = ?";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $precio);
    $stmt->bindParam(2, $idReparacion);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Reparacion terminada correctamente.";
    } else {
      $_SESSION['action'] = "Error al terminar la reparacion: " . $stmt->errorInfo()[2];
    }
  }

  public function cobrar($idReparacion, $fechaEntrega, $precio)
  {
    $ic = new Conexion();
    $sql = "UPDATE reparaciones SET fechaEntrega=?, precio=? WHERE idReparacion = ?";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $fechaEntrega);
    $stmt->bindParam(2, $precio);
    $stmt->bindParam(3, $idReparacion);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Reparacion cobrada correctamente.";
    } else {
      $_SESSION['action'] = "Error al cobrar la reparacion: " . $stmt->errorInfo()[2];
    }
  }

  public function buscarPendientes()
  {
    $ic = new Conexion();
    $sql = "SELECT r.*, c.nombreApellido, e.nombre as equipo
    FROM reparaciones AS r
    INNER JOIN clientes AS c ON c.idCliente = r.idCliente
    INNER JOIN equipos AS e ON e.idEquipo = r.idEquipo
    WHERE completada = 0;";
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

  public function buscarCobros()
  {
    $ic = new Conexion();
    $sql = "SELECT r.*, c.nombreApellido, e.nombre as equipo
    FROM reparaciones AS r
    INNER JOIN clientes AS c ON c.idCliente = r.idCliente
    INNER JOIN equipos AS e ON e.idEquipo = r.idEquipo
    WHERE fechaEntrega IS NULL and precio IS NOT NULL;";
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

  public function buscarPorId($idReparacion)
  {
    $ic = new Conexion();
    $sql = "SELECT * FROM reparaciones WHERE idReparacion = '$idReparacion'";
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

  public function eliminar($idReparacion)
  {
    $ic = new Conexion();
    $sql = "DELETE FROM reparaciones WHERE idReparacion = ?";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $idReparacion);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Reparacion eliminado correctamente.";
    } else {
      $_SESSION['action'] = "Error al eliminar el reparacion: " . $stmt->errorInfo()[2];
    }
  }
}