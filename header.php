
<?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) { ?>
    <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
            <a href="/vulnsocket" class="navbar-brand d-flex align-items-center">

                <strong>Welcome Admin!</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
<?php } else { ?>

    <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
            <a href="/vulnsocket" class="navbar-brand d-flex align-items-center">

                <strong>WebSocket - CSWSH</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
<?php } ?>
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