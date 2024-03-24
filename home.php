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
                header("refresh:5;url=login.php");
                exit;
            }

            if(isset($_SESSION['nome'])) {
                echo '<div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Ben fatto!</h4>
                        <p>Benvenuto ' . $_SESSION['nome'] . '</p>
                        <hr>
                        <p class="mb-0">You successfully read this important alert message.</p>
                      </div>';
                      //Stampa le informazioni della sessione e del cookie 
                echo '<div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Informazioni sessione e cookie</h4>
                        <p>Sessione: ' . session_id() . '</p>';
                if (isset($_COOKIE['nome'])) {
                    echo '<p>Cookie: ' . $_COOKIE['nome'] . '</p>';
                } else {
                    echo '<p>Cookie: Non presente</p>';
                }
                echo '</div>';
            }
            ?>
            <form method="POST" action="home.php">
                <div class="mb-3">
                    <label for="cookie" class="form-label">Esegui il log out!</label>
                    <button type="submit" class="btn btn-primary" name="logout">Logout</button>
                </div>
            </form>
            <form method="POST" action="home.php">
                <div class="mb-3">
                    <label for="cookie" class="form-label">Esegui il log out e cancella i cookie</label>
                    <button type="submit" class="btn btn-primary" name="cookie-logout">Logout e cancella cookie</button>
                </div>
            </form>

            <?php
            if(isset($_POST['logout'])) {
                echo '<div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Logout effettuato!</h4>
                        <p>Stai per essere reindirizzato alla pagina di login tra 5 secondi.</p>
                      </div>';
                session_destroy();
                header("refresh:5;url=login.php");
                exit;
            }

            if(isset($_POST['cookie-logout'])) {
                echo '<div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Logout effettuato!</h4>
                        <p>Stai per essere reindirizzato alla pagina di login tra 5 secondi.</p>
                      </div>';
                session_destroy();
                setcookie('nome', '', time() - 3600, '/');
                header("refresh:5;url=login.php");
                exit;
            }

            ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
