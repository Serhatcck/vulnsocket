<?php
session_start();
if(isset($_SESSION['userId'])){
    header("location:index.php");
    exit();
}
require('database.php');
require('helper.php');
if ($_POST) {
    $userEmail = htmlspecialchars($_POST['usermail']);

    $emailQuery = $conn->prepare("Select * from users where user_email = ? LIMIT 1;");
    $emailQuery->execute(array($userEmail));
    $registeredUser = $emailQuery->fetchAll();
    //print_r($registeredUser);
    
    if (empty($registeredUser)) {
        $userName = htmlspecialchars($_POST['username']);
        $userLastname = htmlspecialchars($_POST['user_lastname']);
        $userPassword = $_POST['user_password'];

        $passwd =  hash('sha256', $userPassword);

        $query = $conn->prepare("INSERT INTO users SET
                            user_email = ?,
                            user_name = ?,
                            user_surname = ?,
                            password = ?,
                            is_admin = 0");

        $insert = $query->execute(array(
            $userEmail, $userName, $userLastname, $passwd
        ));

        if ($insert) {
            $last_id = $conn->lastInsertId();
            $_SESSION = [
                'userId' => $last_id,
                'userEmail' => $userEmail
            ];
            save_sesion($conn);
            header("location:index.php");
            exit();
        } else {
            $error = "Error occured!";
        }
    } else {
        $error = "Error occured!";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <?php
        if (isset($error)) { ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">User email</label>
                <input type="text" class="form-control" name="usermail">
            </div>
            <div class="form-group">
                <label for="username">User name</label>
                <input type="text" class="form-control" name="username">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">User Last Name</label>
                <input type="text" class="form-control" name="user_lastname">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">User Password</label>
                <input type="password" class="form-control" name="user_password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>