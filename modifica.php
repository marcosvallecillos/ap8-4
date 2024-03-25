<?php

// Conectar a la base de datos y cargar la clase Tareas
require_once('clases/Connection.php');

class Modifica extends Connection{
    public function updateTarea($id, $titulo, $descripcion, $fecha_vencimiento) {
        $stmt = $this->conn->prepare("UPDATE tareas SET titulo=?, descripcion=?, fecha_vencimiento=? WHERE id=?");
        $stmt->bind_param("sssi", $titulo, $descripcion, $fecha_vencimiento, $id);
        $stmt->execute();
    
        // Redirigir a la pçágina de modificación después de la actualización
        header("Location: modifica.php?id=$id");
        exit();
    }
}

// Verificar si se ha enviado el formulario de modificación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    // Actualizar la tarea
    $tareas->updateTarea($id, $titulo, $descripcion, $fecha_vencimiento);
}

// Verificar si se ha enviado un ID de tarea a través de GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Obtener los detalles de la tarea seleccionada
    $datos = $tareas->getTaskDetails($id);
} 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Tarea</title>
</head>
<body>

<h2>Modificar Tarea</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label for="titulo">Título:</label><br>
    <input type="text" id="titulo" name="titulo" value="<?php echo $datos['titulo']; ?>"><br>
    <label for="descripcion">Descripción:</label><br>
    <textarea id="descripcion" name="descripcion"><?php echo $datos['descripcion']; ?></textarea><br>
    <label for="fecha_vencimiento">Fecha de Vencimiento:</label><br>
    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $datos['fecha_vencimiento']; ?>"><br>
    <input type="submit" value="Modificar">
</form>

</body>
</html>
