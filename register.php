<?php

session_start();

require("connect.php");


if(isset($_POST['register'])) {
    if(!empty($_POST['username']) && !empty($_POST['email'])  && !empty($_POST['password'])) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role  = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);      
    

        //Validate password
        $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($password !== $confirm_password) {
            $error_message = "Passwords do not match. Try entering correct Password.";
        }
        else{
            // Check if email already exists in database
            $query = "SELECT email FROM Users WHERE email = :email";

            // Prepare the query
            $statement = $db -> prepare($query);

            // Bind the values
            $statement -> bindValue(":email", $email);
            $statement -> execute();
            $existing_user = $statement -> fetch();

            if($existing_user){
                $error_message = "Email already exists. Please use a different email address.";
            }
            else {
                // Build the parameterized SQL query and bind to the above sanitized values.
                $user = "INSERT INTO Users (username, email, password, role) VALUES(:username, :email, :password, :role)";
        
                $statement = $db->prepare($user);
       
        
                // Bind values to the parameters
                $statement->bindValue(':username', $username);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':password', $hashed_password);
                $statement->bindValue(':role', $role);
       
        
                $statement->execute();
        
                // Immediately log the user in after registration
                $_SESSION['user_id'] = $db->lastInsertId();
                $_SESSION['username'] = $username;
        
                // Redirect to the login page
                header("Location: login.php");
                exit;
            }
        }

    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
    <div class="header">
        <h2>Register</h2>
    </div>
    <form method="post" action="register.php">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>
        </div>
        <div class="input-group">
            <label>Role</label>
            <select name="role" required>

                <option value="user">User</option>
                <option value="trainer">Trainer</option>
            </select>
        <div class="input-group">
            <button type="submit" class="btn" name="register">Register</button>
        </div>
        <p>
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>