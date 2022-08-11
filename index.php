<?php
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (!isset($_SESSION['userId'])) {
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socket</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/javascript/jquery.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <?php include('header.php'); ?>

    </header>
    <main role="main">

        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Exploiting WebSocket Vulnerabilities</h1>
                <p class="lead text-muted">There are some websocket vulnerabilities you can test on this page.</p>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header">
                                <h5>Cross-Site WebSocket Hijacking (CSWSH)</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">This section contains the CSWSH vulnerability. After exploiting this vulnerability, user information can be obtained.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a type="button" href="cswsh.php" class="btn btn-sm btn-outline-secondary">Hack!</a>
                                        <a type="button" href="cswsh_secure.php" class="btn btn-sm btn-outline-secondary">Secure!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header">
                                <h5>XSS</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">This section contains the XSS vulnerability.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="xss.php" type="button" class="btn btn-sm btn-outline-secondary">Hack!</a>
                                        <a href="xss_secure.php" type="button" class="btn btn-sm btn-outline-secondary">Secure!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>

    </main>
</body>

</html>