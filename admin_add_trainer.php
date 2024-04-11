<?php

require("connect.php");

if($_POST && !empty($_POST['name']) && !empty($_POST['bio'])){
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO trainers (name, bio) VALUES (:name, :bio)";
    $statement = $db->prepare($query);

    $statement->bindValue(':name', $name);
    $statement->bindValue(':bio', $bio);

    if($statement->execute())
    {
        header("Location: trainers.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Trainer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="add_trainer.css">
</head>
<body>
    <header>
        <h1>Winnipeg Fitness Hub</h1>
    </header>
    <section id="New Trainer" class="tabcontent">
        <div>
            <fieldset>
                <legend>Add New Trainer</legend>
                <form class="create-trainer" action="admin_add_trainer.php" method="POST">
                    <label for="name">Trainer Name</label>
                    <input type="text" id="name" name="name" placeholder="Trainer Name" required>

                    <label for="bio">Trainer Bio</label>
                    <textarea id="bio" name="bio" placeholder="Write something.." style="height:200px" required></textarea>

                    <input type="submit" value="Submit">
                </form>
            </fieldset>
        </div>
        <script src ="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    
    </section>
</body>
