<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HomePage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-5"></h1>
        <div class="container mt-3">
            <?php
            session_start();

            if(!isset($_SESSION['nome']) && !isset($_COOKIE['nome'])) {
                echo '<div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Attenzione!</h4>
                        <p>Non hai effettuato il login, verrai reindirizzato alla pagina di login tra 5 secondi.</p>
                        <hr>
                        <p class="mb-0">You successfully read this important alert message.</p>
                      </div>';
                header("refresh:5;url=register.php");
                exit;
            }

            if(isset($_SESSION['nome'])) {
                echo '<div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Ben fatto!</h4>
                        <p>Benvenuto ' . $_SESSION['nome'] . '</p>
                        <hr>
                        <p class="mb-0">You successfully read this important alert message.</p>
                      </div>';
            }
            ?>
            <form method="POST" action="home.php">
                <div class="mb-3">
                    <label for="cookie" class="form-label">Esegui il log out!</label>
                    <button type="submit" class="btn btn-primary">Logout</button>
                </div>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                session_destroy();
                echo '<div class="alert alert-info" role="alert">
                        Logout effettuato con successo! Verrai reindirizzato alla pagina di login tra 5 secondi.
                      </div>';
                header("refresh:5;url=register.php");
                exit;
            }
            ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
