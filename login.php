<?php

require("connect.php");
session_start();
$user;

if(isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    // Select user based on email
    $user_login = "SELECT * FROM Users WHERE email = :email";
    $statement = $db->prepare($user_login);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $user = $statement->fetch();

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];

            if($user['role'] == "admin")
            {
                header("Location: admin_dashboard.php");
                exit;
            }
            elseif ($user['role'] == "user"){
                header("Location: user_dashboard.php");
                exit;
            }elseif($user['role'] == "trainer"){
                header("Location: trainer_dashboard.php");
                exit;
            }
            else{
                $message = "User not found";
            }
            
        } else {
            $message = "Wrong Password";
        }
    } else {
        $message = "User not found";
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <h1>Winnipeg Fitness Hub</h1>
        <nav>
            <ul>
                <li><a href="#classes">Classes</a></li>
                <li><a href="#trainers">Trainers</a></li>
                <li><a href="register.php">Registration</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <section id="login">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <?php if(!empty($user)):?>
        <p><?php echo $message; ?></p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2024 Winnipeg Fitness Hub. All rights reserved.</p>
    </footer>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>