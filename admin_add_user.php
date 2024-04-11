<?php
 require("connect.php");

 if($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['role'])){
     $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
     $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

     $query = "INSERT INTO Users (username, email, password, role) VALUES (:username, :email, :password, :role)";
     $statement = $db->prepare($query);

     $statement->bindValue(':username', $username);
     $statement->bindValue(':email', $email);
     $statement->bindValue(':password', $hashed_password);
     $statement->bindValue(':role', $role);

     if($statement->execute())
     {
         header("Location: admin_dashboard.php");
         exit;
     }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <section id="New User" class="tabcontent">
        <div>
            <fieldset>
                <legend>Add New User</legend>
                <form class="create-user" action="admin_add_user.php" method="POST">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>

                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="user">User</option>
                        <option value="trainer">Trainer</option>
                    </select>

                    <input type="submit" value="Submit">
                </form>
            </fieldset>
        </div>
                
    </section>
</body>

