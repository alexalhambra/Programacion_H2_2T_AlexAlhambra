<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Esto es para que el navegador entienda bien los caracteres como las tildes y la "ñ" -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que la página se vea bien en móviles -->
    <title>Inicio</title> <!-- El título que aparece en la pestaña del navegador -->
    <style>
        /* Le damos estilo a la página */
        body {
            font-family: Arial, sans-serif; /* Fuente de texto */
            text-align: center; /* Todo el texto centrado */
            margin-top: 50px; /* Espacio arriba para que no esté pegado al borde */
        }
        .container {
            max-width: 400px; /* No queremos que sea muy ancha la caja */
            margin: 0 auto; /* Centra la caja en la pantalla */
            padding: 20px; /* Espacio dentro de la caja */
            border: 1px solid #ccc; /* Bordecito gris clarito */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombrilla suave para que se vea cool */
        }
        .btn {
            display: inline-block; /* Se comporta como bloque pero sin ocupar todo el ancho */
            padding: 10px 20px; /* Espacio dentro del botón */
            margin: 10px 0; /* Espacio entre los botones */
            background-color: #007bff; /* Azul bonito */
            color: white; /* Texto en blanco */
            text-decoration: none; /* Quitamos el subrayado de los enlaces */
            border-radius: 5px; /* Bordes redondeados */
            font-size: 16px; /* Tamaño del texto */
        }
        .btn:hover {
            background-color: #0056b3; /* Cambia a un azul más oscuro cuando pasas el mouse */
        }
    </style>
</head>
<body>

    <div class="container"> <!-- Contenedor principal -->
        <h2>Bienvenido a la Página</h2> <!-- Título principal -->
        <p>Por favor, elige una opción:</p> <!-- Un pequeño texto -->
        <a href="registro.php" class="btn">Registrar Usuario</a> <!-- Botón para registrarse -->
        <br> <!-- Salto de línea -->
        <a href="login.php" class="btn">Iniciar Sesión</a> <!-- Botón para iniciar sesión -->
    </div>

</body>
</html>
