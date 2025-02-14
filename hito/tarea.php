<?php
session_start(); // Iniciamos la sesión

// Si el usuario no ha iniciado sesión, lo mandamos al login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('conexion.php'); // Conexión a la base de datos

$user_id = $_SESSION['user_id']; // Guardamos el ID del usuario en sesión

// Si se envía el formulario y hay una tarea, la guardamos en la BD
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']); // Limpiamos espacios extra en la tarea

    // Preparamos la consulta para insertar la nueva tarea
    $sqlInsert = "INSERT INTO tasks (user_id, task) VALUES (?, ?)";
    $stmtInsert = $mysql->prepare($sqlInsert);
    $stmtInsert->bind_param('is', $user_id, $task); 

    try {
        $stmtInsert->execute();
        $message = "Tarea agregada exitosamente."; // Mensaje de éxito
    } catch (mysqli_sql_exception $e) {
        $message = "Error al agregar la tarea: " . $e->getMessage(); // Mensaje de error si falla
    }
}

// Obtenemos todas las tareas del usuario ordenadas por fecha 
$sqlTasks = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
$stmtTasks = $mysql->prepare($sqlTasks);
$stmtTasks->bind_param('i', $user_id);  
$stmtTasks->execute();
$result = $stmtTasks->get_result(); 

$tasks = []; // Array para almacenar las tareas

while ($task = $result->fetch_assoc()) { // Recorremos los resultados
    $tasks[] = $task; // Guardamos cada tarea en el array
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tareas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .task-list {
            list-style-type: none;
            padding: 0;
        }
        .task-list li {
            padding: 10px;
            margin-bottom: 5px;
            background-color: #f4f4f4;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Mis Tareas</h1>

        <!-- Mostramos el mensaje si existe -->
        <?php if (isset($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para agregar una nueva tarea -->
        <div class="form-container">
            <h3>Agregar Nueva Tarea</h3>
            <form method="POST">
                <input type="text" name="task" placeholder="Escribe tu tarea" required>
                <button type="submit" class="btn">Agregar Tarea</button>
            </form>
        </div>

        <!-- Lista de tareas -->
        <h3>Tareas Pendientes</h3>
        <ul class="task-list">
            <?php if (count($tasks) > 0): ?> <!-- Si hay tareas, las mostramos -->
                <?php foreach ($tasks as $task): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($task['task']); ?></strong><br>
                        <small>Creada el: <?php echo date("d/m/Y H:i", strtotime($task['created_at'])); ?></small>
                    </li>
                <?php endforeach; ?>
            <?php else: ?> <!-- Si no hay tareas, mostramos un mensaje -->
                <p>No tienes tareas pendientes.</p>
            <?php endif; ?>
        </ul>

        <p><a href="cerrarsesion.php" class="btn">Cerrar sesión</a></p> <!-- Botón para cerrar sesión -->
    </div>

</body>
</html>
