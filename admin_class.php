<?php

require("functions.php");

$query = "SELECT classes.class_id, classes.class_name, classes.description, trainers.name, categories.category_name ,schedule, max_capacity
FROM classes 
JOIN trainers ON classes.trainer_id = trainers.trainer_id 
JOIN categories ON classes.category_id = categories.category_id ORDER BY classes.class_id ";
$statement = $db->prepare($query);
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Class</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_trainers.css">
</head>
<body>
<header>
    <h1>Winnipeg Fitness Hub</h1>
    <nav>
        <section id="profile" >
            <a href="admin_class.php?logout=true" >Log Out</a>
        </section>
    </nav>
</header>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <a href="admin_add_class.php" class="link-primary">Add New Class</a>
        <form action="admin_class.php" method="post" class="position-relative">
            <?php if($statement -> rowCount() > 0) : ?>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Class Name</th>
                            <th>Class Description</th>
                            <th>Class Trainer</th>
                            <th>schedule</th>
                            <th>Catagory</th>
                            <th>Max Capacity</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $statement->fetch()) : ?>
                            <tr>
                                <td><?= $row['class_name'] ?></td>
                                <td><?= $row['description'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['schedule'] ?></td>
                                <td><?= $row['category_name'] ?></td>
                                <td><?= $row['max_capacity'] ?></td>
                                <td><a href="edit_classes.php?id=<?= $row['class_id'] ?>" class="link-primary">Edit</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No classes found</p>
            <?php endif ?>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>
</body>
</html>
