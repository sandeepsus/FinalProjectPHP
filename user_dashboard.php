<?php
session_start();
require("connect.php");

/**
 * A function to destroy the session, when user clicks on log out option.
 */
function destroySession()
{
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

if(isset($_GET['logout'])) {
    destroySession();
}

/**
 * A function to display user's profile
 */
function displayProfile($db)
{
    $username = "";
    $query = "SELECT username FROM users WHERE email = :email";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $_SESSION['email']);
    $statement->execute();
    $row = $statement->fetch();
    if ($row) {
        $username = $row['username'];
    }
    return $username;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winnipeg Fitness Hub</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <h1>Winnipeg Fitness Hub</h1>
        <nav>
            <section id="profile" >
                <h2 >Welcome, <?php echo displayProfile($db); ?>!</h2>
                <a href="user_dashboard.php?logout=true" >Log Out</a>
            </section>
             
            <section id="classes">
            <ul>
                <li><a href="#classes">Classes</a></li>
                <li><a href="#trainers">Trainers</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            </section>
        </nav>
    </header>
    <section id="classes">
        <h2>Classes</h2>
        <p>Explore our wide range of fitness classes tailored to suit your needs.</p>
        <a href="classes.php">View Classes</a>
    </section>

    <section id="trainers">
        <h2>Trainers</h2>
        <p>Meet our experienced and certified trainers dedicated to helping you achieve your fitness goals.</p>
        <a href="trainers.php">Meet Trainers</a>
    </section>

    <section id="contact">
        <h2>Contact Us</h2>
        <p>Have questions or need assistance? Reach out to us!</p>
        <a href="contact.php">Contact Us</a>
    </section>

    <footer>
         <p>&copy; 2024 Winnipeg Fitness Hub. All rights reserved.</p>
    </footer>
 </body>



