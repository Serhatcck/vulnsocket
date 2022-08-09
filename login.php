<?php
session_start();

if (isset($_SESSION['userId'])) {
    header("location:index.php");
    exit();
}
//admin@admin.com
//1.()$2ccca
require('database.php');
require('helper.php');

if ($_POST) {
    $userEmail = htmlspecialchars($_POST['usermail']);
    $userPassword = $_POST['user_password'];
    $passwd =  hash('sha256', $userPassword);

    $emailQuery = $conn->prepare("Select * from users where user_email = ? and password = ?");
    $emailQuery->execute(array($userEmail, $passwd));
    $user = $emailQuery->fetch();
    if (!empty($user)) {
        $_SESSION = [
            'userId' => $user['id'],
            'userEmail' => $user['user_email'],
            'is_admin' => $user['is_admin']
        ];
        save_sesion($conn);
        header("location:index.php");
        exit();
    } else {
        $error = "Error Occured!";
    }
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
    <div class="container">
        <h2>Login</h2>
        <?php
        if (isset($error)) { ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php }
        ?>
        <form method="POST" id="login_form">
            <div class="form-group">
                <label for="username">User email</label>
                <input type="text" class="form-control" name="usermail" id="usermail">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">User Password</label>
                <input type="password" class="form-control" name="user_password" id="user_password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="register.php" class="btn btn-primary">Register</a>
        </form>
    </div>
</body>

</html>