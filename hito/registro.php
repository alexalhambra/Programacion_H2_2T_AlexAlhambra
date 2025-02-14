<?php
include('conexion.php'); // Se conecta a la base de datos

// Si el usuario envió el formulario 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Guardamos los datos del usuario
    $username = trim($_POST['username']); // Limpiamos espacios extra
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Verificamos si el email ya existe en la BD
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $mysql->prepare($sql);
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        // Si el correo ya está registrado, mostramos mensaje en rojo
        $mensaje = "<p style='color: red;'>El correo electrónico ya está registrado. Intenta con otro.</p>";
    } else {
        // Si no existe, encriptamos la contraseña para más seguridad
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertamos el nuevo usuario en la BD
        $sqlInsert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmtInsert = $mysql->prepare($sqlInsert);

        try {
            $stmtInsert->execute([$username, $email, $hashedPassword]);
            $mensaje = "<p style='color: green;'>Usuario registrado exitosamente. <a href='login.php'>Iniciar sesión</a></p>";
        } catch (PDOException $e) {
            $mensaje = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Para que las tildes y la ñ se vean bien -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Adaptabilidad a móviles -->
    <title>Registrar Usuario</title> <!-- Nombre que aparece en la pestaña -->
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
    </style>
</head>
<body>

    <div class="form-container"> <!-- Contenedor del formulario -->
        <h2>Registro de Usuario</h2> <!-- Título -->
        
        <?php if (isset($mensaje)) echo $mensaje; ?> <!-- Mostramos mensaje si hay -->

        <form method="POST"> <!-- Formulario para registro -->
            <input type="text" name="username" placeholder="Nombre de usuario" required> 
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" class="btn">Registrar</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>
    </div>

</body>
</html>
