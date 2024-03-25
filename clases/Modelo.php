<?php
echo "hola";
require_once('Connection.php');
class Modelo extends Connection{
    
    public function importar() {
            $fichero='tareas.csv';
            $query = "INSERT INTO tareas (id,titulo, descripcion, fecha_creacion, fecha_vencimiento) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $csvFile = fopen($fichero, "r");

            if ($csvFile !== false) {
                while (($data = fgetcsv($csvFile)) !== false) {
                    $fecha_creacion = date('Y-m-d', strtotime ($data[2]));
                    $fecha_vencimiento = date('Y-m-d', strtotime ($data[3]));
                    
                    $stmt->bind_param("issss", $data[0], $data[1], $data[2], $fecha_creacion, $fecha_vencimiento,);
                    $stmt->execute();
                }
                fclose($csvFile);
            }
        }
    
    public function deleteList() {
        $query = "DELETE FROM tareas";
        $result = $this->conn->query($query);
        return $result;
    }
    
    public function init() {
        $deleteSuccess = $this->deleteList();
        if ($deleteSuccess) {
            return $this->importar();
        } else {
            return false;
        }
    }


    public function getAllTasks() {
        $query = "SELECT * FROM tareas";
        $result = $this->conn->query($query);
        $tareas = array();
        if ($result->num_rows > 0 ){
            while(){
        return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        }
    }

    public function showAllTasks() {
        $tasks = $this->getAllTasks();
        
        if (!empty($tasks)) {
            echo '<table>';
            echo '<tr><th>ID</th>
            <th>Título</th>
            <th>Fecha de Creacion</th>
            <th>Fecha de Vencimiento</th>
            </tr>';

            foreach ($tasks as $task) {
                $id = $task['id'];
                $titulo = $task['titulo'];
                $fecha_creacion = date('d/m/Y', strtotime($task['fecha_creacion']));
                $fecha_vencimiento = date('d/m/Y', strtotime($task['fecha_vencimiento']));
                echo "<tr><td>$id</td><td<a href='detalle.html?id=$id'>$titulo</a></td><td>$fecha_creacion</td><td>$fecha_vencimiento</td><td><a href='modifica.php?id=$id'>Modificar</a></td></tr>";
            }
            echo '</table>';
        }
    }

}
?>