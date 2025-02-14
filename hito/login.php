<?php 
ob_start(); // Inicia el almacenamiento en búfer de salida
session_start(); // Inicia la sesión para manejar usuarios
include('conexion.php'); // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Si se envió el formulario...
    $email = trim($_POST['email']); // Limpiamos el email de espacios extra
    $password = $_POST['password']; // Obtenemos la contraseña ingresada

    // Preparamos la consulta para buscar al usuario por su email
    $sql = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = $mysql->prepare($sql);
    $stmt->bind_param('s', $email); // 's' indica que es una cadena 
    $stmt->execute();
    $result = $stmt->get_result(); // Obtenemos el resultado de la consulta

    if ($result->num_rows > 0) { // Si encontró un usuario con ese email...
        $user_data = $result->fetch_assoc(); // Extraemos los datos del usuario

        // Verificamos que la contraseña ingresada coincida con la almacenada
        if (password_verify($password, $user_data['password'])) {
            // Si la contraseña es correcta, guardamos la sesión del usuario
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['username'] = $user_data['username'];  

            header("Location: tarea.php"); // Redirige a la página principal
            exit(); // Detiene la ejecución para evitar que siga corriendo el código
        } else {
            $error_message = "Correo o contraseña incorrectos."; // Mensaje de error si la contraseña está mal
        }
    } else {
        $error_message = "Correo o contraseña incorrectos."; // Mensaje de error si el usuario no existe
    }
}

ob_end_flush(); // Limpia el búfer de salida
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Configura los caracteres para que todo se vea bien -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que se vea bien en móviles -->
    <title>Iniciar Sesión</title> <!-- Título de la pestaña -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            border: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="form-container"> <!-- Contenedor para el formulario -->
        <h2>Iniciar Sesión</h2> <!-- Título -->
        <form method="POST"> <!-- Formulario que envía los datos por POST -->
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" class="btn">Iniciar sesión</button>
        </form>

        <?php if (isset($error_message)): ?> <!-- Si hay un error, lo mostramos -->
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <p>¿No tienes una cuenta? <a href="registro.php">Registrar</a></p> <!-- Link para registrarse -->
    </div>

</body>
</html>
