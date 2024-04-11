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

$query = "SELECT * FROM trainers";
$statement = $db -> prepare($query);
$statement -> execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winnipeg Fitness Hub</title>
    <link rel="stylesheet" href="classes.css">
</head>
<body>
    <header>
        <h1>Winnipeg Fitness Hub</h1>
        <nav>
            <section id="profile" >
                <a href="user_dashboard.php?logout=true" >Log Out</a>
            </section>
        </nav>
    </header>
    <section id="trainers">
        <h2>Trainers</h2>
        <p>Meet our experienced and certified trainers dedicated to helping you achieve your fitness goals.</p>
        <table>
            <tr>
                <th>name</th>
                <th>Bio</th>
            </tr>
            <?php while($row = $statement->fetch()) : ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['bio']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>
    <footer>
        <p>&copy; 2024 Winnipeg Fitness Hub. All rights reserved.</p>
    </footer>