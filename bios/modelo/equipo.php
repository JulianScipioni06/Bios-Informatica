<?php
require_once "../bd/conexion.php";

class Equipo
{
  protected $idEquipo;
  protected $nombre;



  public function insertar()
  {
    $ic = new Conexion();
    $sql = "INSERT INTO equipos(nombre) VALUES (?)";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $this->nombre);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Equipo insertado correctamente.";
    } else {
      $_SESSION['action'] = "Error al insertar el equipo: " . $stmt->errorInfo()[2];
    }
  }

  public function editar($idEquipo, $nombre)
  {
    $ic = new Conexion();
    $sql = "UPDATE equipo SET nombre = ? WHERE idEquipo = ?";
    $stmt = $ic->db->prepare($sql);
    $stmt->bindParam(1, $nombre);
    $stmt->bindParam(2, $idEquipo);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Equipo editado correctamente.";
    } else {
      $_SESSION['action'] = "Error al editar el equipo: " . $stmt->errorInfo()[2];
    }
  }

  public function buscar()
  {
    $ic = new Conexion();
    $sql = "SELECT * FROM equipos";
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

  public function buscarPorId($idEquipo)
  {
    $ic = new Conexion();
    $sql = "SELECT * FROM equipos WHERE idEquipo = '$idEquipo'";
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

  public function buscarPorNombre($nombre)
  {
    $ic = new Conexion();
    $sql = "SELECT * FROM equipos WHERE nombre = '$nombre'";
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

  public function eliminar($idEquipo) // ??????????????????
  {
    $ic = new conexion();
    $sql = "DELETE FROM equipos WHERE idEquipo = '$idEquipo' ";
    $stmt = $ic->db->prepare($sql);

    if ($stmt->execute()) {
      $_SESSION['action'] = "Equipo elminado correctamente.";
    } else {
      $_SESSION['action'] = "Error al eliminar el equipo: " . $stmt->errorInfo()[2];
    }
  }
}