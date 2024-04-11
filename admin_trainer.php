<?php

require("functions.php");   

$query = "SELECT * FROM trainers";
$statement = $db->prepare($query);
$statement->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Trainer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_trainers.css">
</head>
<body>
<header>
    <h1>Winnipeg Fitness Hub</h1>
    <nav>
        <section id="profile" >
            <a href="admin_trainer.php?logout=true" >Log Out</a>
        </section>
    </nav>
</header>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <a href="admin_add_trainer.php" class="link-primary">Add New Trainer</a>
        <form action="admin_trainer.php" method="post" class="position-relative">
            <?php if($statement -> rowCount() > 0) : ?>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Trainer Name</th>
                            <th>Trainer Bio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $statement->fetch()) : ?>
                            <tr>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['bio'] ?></td>
                                <td><a href="edit_trainer.php?id=<?= $row['trainer_id'] ?>" class="link-primary">Edit</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No trainers found</p>
            <?php endif ?>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>
</body>
</html>