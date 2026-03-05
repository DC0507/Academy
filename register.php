<?php

include './config/db.php';

//Inicializa la variable message
$message = "";

//Si el método de envío del formulario es POST
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

        if ($stmt->execute()) {
            $message = "Registration successful.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<?php include './includes/header.php'; ?>

<h2>Registro</h2>

<form action="" method="post">
    <label for="name">Nombre:</label><br>
    <input type="text" name="name" id="name">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email">
    <label for="password">contraseña:</label>
    <input type="password" name="password" id="password">
    <button type="submit">Registrar</button>
</form>

<p>
    <?php echo $message; ?>
</p>

<?php include './includes/footer.php'; ?>