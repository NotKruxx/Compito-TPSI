<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <center>
            <h1>Crea un account</h1>
        </center>
        <div class="container">
            <form method="POST" action="register.php">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Indirizzo Email</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required>
                    <div id="emailMessaggio" class="form-text">Assicurati di inserire l'email corretta</div>
                </div>
                <div class="mb-3">
                    <label for="password1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password1" name="password1" required>
                </div>
                <div class="mb-3">
                    <label for="password2" class="form-label">Conferma Password</label>
                    <input type="password" class="form-control" id="password2" name="password2" required>
                    <div id="emailMessaggio" class="form-text">Assicurati di inserire la stessa password inserita nel campo precendente</div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="ricordati">
                    <label class="form-check-label" for="exampleCheck1">Ricordati le credenziali (durata 1 ora)</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <?php

    session_start(); 

    if ($_COOKIE && isset($_COOKIE['email'])) {
        echo "<div class='container'>";
        echo "<div class='alert alert-warning' role='alert'>
        In precedenza hai salvato le credenziali attraverso i cookie, verrai reindirizzato alla home tra 5 secondi
        </div>";
        echo "</div>";
        $_SESSION['nome'] = $_COOKIE['nome'];

        //https://www.w3docs.com/snippets/php/php-auto-refreshing-page.html

        header("refresh:5;url=home.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['nome'])) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            $ricordati = isset($_POST['ricordati']) ? 1 : 0;

            $password1_hash = hash('sha256', $password1);
            $password2_hash = hash('sha256', $password2);

            if ($password1_hash === $password2_hash) {
                
                include 'database.php';
                
                //controlla se l'email è già presente nel database
                
                $sql = "SELECT * FROM Utenti WHERE email = '$email'";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "<br>";
                    echo "<div class='container'>";
                    echo "<div class='alert alert-danger' role='alert'>L'email è già presente nel database, riprova con un altra email tra 5 secondi</div>";
                    echo "</div>";
                    header("refresh:5;url=register.php");
                    exit;
                }

                $sql = "INSERT INTO Utenti (nome, email, password) VALUES ('$nome', '$email', '$password1_hash')";
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                echo "<br>";
                echo "<div class='container'>";
                echo "<div class='alert alert-success' role='alert'>Le password coincidono, verrai reindirizzato alla home tra 5 secondi</div>";
                echo "</div>";
                if ($ricordati) {
                    setcookie("nome", $nome, time() + 3600, "/");
                }
                $_SESSION['nome'] = $nome;
                header("refresh:5;url=home.php");
                exit;
            } else {
                echo "<br>";
                echo "<div class='container'>";
                echo "<div class='alert alert-danger' role='alert'>Le password non coincidono, riprova tra 5 secondi</div>";
                echo "</div>";
                header("refresh:5;url=register.php");
                exit;
            }
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
