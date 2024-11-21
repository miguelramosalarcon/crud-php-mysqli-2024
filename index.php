<?php
// Configuración de la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "crud_mysqli";

// Conexión a la base de datos
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
error_reporting(0);
// Inicializar variables
$id = $nombres = $email = $update = "";

// Crear registro
if (isset($_POST['create'])) {
    $nombres = $_POST['nombres'];
    $edad = $_POST['edad'];
    $distrito = $_POST['distrito'];
    $sql = "INSERT INTO usuarios (nombres,edad, distrito) VALUES ('$nombres', '$edad', '$distrito')";
    if ($conn->query($sql)) {
        echo '<script type="text/javascript">
        alert("Registro creado");
        window.location.href="index.php";
        </script>';
    } else {
        echo "Error: " . $conn->error;
    }
}

// Leer todos los registros para ser mostrados en una tabla
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

// Actualizar registro
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombres = $_POST['nombres'];
    $edad = $_POST['edad'];
    $distrito = $_POST['distrito'];
    $sql = "UPDATE usuarios SET nombres='$nombres', edad='$edad', distrito='$distrito' WHERE id=$id";
    if ($conn->query($sql)) {
        echo '<script type="text/javascript">
        alert("Registro actualizado");
        window.location.href="index.php";
        </script>';
    } else {
        echo "Error: " . $conn->error;
    }
}

// Eliminar registro
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM usuarios WHERE id=$id";
    if ($conn->query($sql)) {
        echo '<script type="text/javascript">
        alert("Registro eliminado");
        window.location.href="index.php";
        </script>';
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener datos para editar
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM usuarios WHERE id=$id";
    $result_edit = $conn->query($sql);
    if ($result_edit->num_rows == 1) {
        $row = $result_edit->fetch_assoc();
        $nombres = $row['nombres'];
        $edad = $row['edad'];
        $distrito = $row['distrito'];
        $update = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="CRUD,PHP, MYSQLi, MYSQL, Miguel Ramos"/>
    <meta name="author" content="Miguel Ramos Alarcon">
    <meta name="copyright" content="Miguel Ramos Alarcon" />
    <meta name="description" content="CRUD PHP con Mysqli y Mysql con estilos 2024">
    <link rel="stylesheet" href="styles.css">
    <title>CRUD PHP con MySQLi</title>
    
</head>
<body>
    <h1>CRUD PHP con MySQLi</h1>
    
    <div class="container">
        <h2>Agregar un usuario</h2>
        <form method="POST" action="index.php">
            <input type="hidden" name="id" value="<?= $id ?>">
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" value="<?= $nombres ?>" required>
            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" value="<?= $edad ?>" min="1" max="99" required>
            <label for="distrito">Distrito:</label>
            <input type="text" id="distrito" name="distrito" value="<?= $distrito ?>" required>
            <?php if ($update): ?>
                <button class="btn_actualizar" type="submit" name="update" class="btn btn_actualizar">Actualizar</button>
                <a class ="btn_cancelar" href="index.php">Cancelar</a>
            <?php else: ?>
                <button class="btn_crear" type="submit" name="create" class="btn btn_crear">Guardar</button>
            <?php endif; ?>
        </form>
    </div>
    
    <h2 class="subtitulo">Lista de usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Edad</th>
            <th>Distrito</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nombres'] ?></td>
                <td><?= $row['edad'] ?></td>
                <td><?= $row['distrito'] ?></td>
                <td>
                    <a class="btn_editar" href="index.php?edit=<?= $row['id'] ?>">Editar</a>
                    <a class="btn_eliminar" href="index.php?delete=<?= $row['id'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <footer>
        <p><a class="copy" href="https://github.com/miguelramosalarcon" target="_blank">&copy;Miguel A. Ramos Alarcon</a></p>
    </footer>
</body>
</html>

<?php
// Cerrar conexión con la BD
$conn->close();
?>
