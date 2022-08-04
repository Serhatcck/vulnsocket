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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" >
    <script src="assets/javascript/jquery.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="text-white">About</h4>
                        <p class="text-muted">Vulnerable WebSocket Application.</p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4 class="text-white">Contact</h4>
                        <ul class="list-unstyled">
                            <li><a href="https://www.linkedin.com/in/serhatcck/" target="_blank" class="text-white">Linkedin</a></li>
                            <li><a href="https://github.com/Serhatcck" target="_blank" class="text-white">Github</a></li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">

                    <strong>WebSocket</strong>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <a href="logout.php"  class="navbar-brand d-flex align-items-center">LogOut</a>
            

        </div>
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                    </div>
                                    <small class="text-muted">9 mins</small>
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