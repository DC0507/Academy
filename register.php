<?php

include './config/db.php';

//Inicializa la variable message
$message = "";

//Evalua si el método de envío del formulario es POST (para prevenir que se acceda directamente)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Almacena los valores de los campos name, email y password en las respectivas variables
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    //Si alguno de los campos esta vacío, message almacena una advertencia 
    if (empty($name) || empty($email) || empty($password)) {
        $message = "Todos los campos son requeridos!";
    } else {
        //Cifra la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //Crea la consulta para insertar los valores en la tabla users
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
        //Agrega los valores de los párametros a la consulta
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        //Ejecuta la consulta
        if ($stmt->execute()) {
            //Si se ejecuta correctamente devuelve, message almacena un mensaje exitoso
            $message = "Registration successful.";
        } else {
            //Si falla, message almacena el error
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!--Incluye el contenido de header.php-->
<?php include './includes/header.php'; ?>

<!--Código del Formulario en HTML-->
<h2>Registro</h2>

<form action="" method="post">
    <label for="name">Nombre:</label><br>
    <input type="text" name="name" id="name"><br>
    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email"><br>
    <label for="password">Contraseña:</label><br>
    <input type="password" name="password" id="password"><br>
    <button type="submit">Registrar</button>
</form>

<p>
    <!--Imprime el contenido de message-->
    <?php echo $message; ?>
</p>

<!--Incluye el contenido de footer.php-->
<?php include './includes/footer.php'; ?>