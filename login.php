<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagina di Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <center>
        <h1>Esegui il login</h1>
      </center>
        <form action="login.php" method="post">
          <div class="mb-3">
            <label for="email" class="form-label">email</label>
            <input type="email" class="form-control" id="email" name="email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="ricordati" name="ricordati" value="1">
                    <label class="form-check-label" for="ricordati">Ricordati le credenziali (durata 1 ora)</label>
                </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>

<?php
session_start();

if ($_COOKIE && isset($_COOKIE['nome'])) {
    echo "<div class='container'>";
    echo "<div class='alert alert-warning' role='alert'>
    Hai già effettuato l'accesso in precedenza, verrai reindirizzato alla home tra 5 secondi
    </div>";
    echo "</div>";
    $_SESSION['nome'] = $_COOKIE['nome'];
    header("refresh:5;url=home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $ricordati = isset($_POST['ricordati']) ? $_POST['ricordati'] : 0;

        $password_hash = hash('sha256', $password);

        include 'database.php';

        $sql = "SELECT * FROM Utenti WHERE email = '$email' AND password = '$password_hash'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['nome'] = $row['nome'];
            echo "<br>";
            echo "<div class='container'>";
            echo "<div class='alert alert-success' role='alert'>Accesso effettuato con successo, verrai reindirizzato alla home tra 5 secondi</div>";
            echo "</div>";
            if ($ricordati == 1) {
                setcookie("nome", $row['nome'], time() + 3600, "/");
            }
            header("refresh:5;url=home.php");
            exit;
        } else {
            echo "<br>";
            echo "<div class='container'>";
            echo "<div class='alert alert-danger' role='alert'>Email o password errate, riprova tra 5 secondi</div>";
            echo "</div>";
            header("refresh:5;url=login.php");
            exit;
        }
    }
}
?>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      </div>
  </body>
</html>
