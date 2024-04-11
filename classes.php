<?php

session_start();
require("connect.php"); 

$query = "SELECT classes.class_name, classes.description, trainers.name, categories.category_name ,schedule, max_capacity
          FROM classes 
          JOIN trainers ON classes.trainer_id = trainers.trainer_id 
          JOIN categories ON classes.category_id = categories.category_id";

          if(isset($_POST['sortbutton'])) {
              $sort = $_POST['sort'];
              $query .= " ORDER BY $sort";
          }
          if(isset($_POST['searchbutton'])) {
              $search = $_POST['search'];
              $query .= " WHERE class_name LIKE '%$search%' OR description LIKE '%$search%' OR name LIKE '%$search%' OR category_name LIKE '%$search%' OR schedule LIKE '%$search%' OR max_capacity LIKE '%$search%'";
          }
$statement = $db -> prepare($query);
$statement -> execute();



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




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winnipeg Fitness Hub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="userclasses.css">
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
    <form action="#" method="post">
        <Select name="sort">
            <option value="class_name">Class Name</option>
            <option value="description">Description</option>
            <option value="name">Trainer Name</option>
            <option value="schedule">Schedule</option>
            <option value="category_name">Category Name</option>
            <option value="max_capacity">Max Capacity</option>
        </Select>
        <button name= "sortbutton">Sort</button>
    </form>
    <form action="#" method="post">
        <input type="text" name="search" placeholder="Search">
        <button name="searchbutton">Search</button>
    </form>
    <section id="classes">
        
        <h2>Classes</h2>
        <p>Explore our wide range of fitness classes tailored to suit your needs.</p>
        <table>
            <tr>
                <th>Class Name</th>
                <th>Description</th>
                <th>Trainer Name</th>
                <th>Schedule</th>
                <th>Category Name</th>
                <th>Max Capacity</th>
            </tr>
            <?php while($row = $statement->fetch()) : ?>
                <tr>
                    <td><?= $row['class_name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['schedule'] ?></td>
                    <td><?= $row['category_name'] ?></td>
                    <td><?= $row['max_capacity'] ?></td>
                </tr>
            <?php endwhile ?>
        </table>
    </section>
 
    <footer>
        <p>&copy; 2024 Winnipeg Fitness Hub. All rights reserved.</p>
    </footer>
</body>
            
