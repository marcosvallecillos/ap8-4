<?php
require_once('clases/Connection.php');

class nueva extends Connection {
    public function addTarea($titulo, $descripcion, $fecha_vencimiento) {
        $fecha_creacion = date('Y-m-d'); // Obtiene la fecha actual
        
        $stmt = $this->conn->prepare("INSERT INTO tareas (titulo, descripcion, fecha_creacion, fecha_vencimiento) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $titulo, $descripcion, $fecha_creacion, $fecha_vencimiento);
        $stmt->execute();
        header("Location: lista.html");
        exit();
    }
}