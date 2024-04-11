<?php
require("functions.php");

$class = "";
$description = "";
$trainer_id = "";
$category_id = "";
$schedule = "";
$max_capacity = "";
$classNotFound = false;

if(isset($_GET['id'])){
    $statement = searchClass($db);
    if($row = $statement->fetch()){
        $class = $row['class_name'];
        $description = $row['description'];
        $trainer_id = $row['trainer_id'];
        $category_id = $row['category_id'];
        $schedule = $row['schedule'];
        $max_capacity = $row['max_capacity'];
    } else {
        $classNotFound = true;
    }
}

if(isset($_POST['update'])){
    editClasses($db);
} elseif(isset($_POST['delete'])){
    deleteClasses($db);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Class</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="edit_classes.css">
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
    <section id="classes">
        <h2>Edit Class</h2>
        <form action="edit_classes.php" method="POST">
            <fieldset>
                <legend>Edit Class</legend>
                <?php if ($classNotFound): ?>
                    <p class="message p-3 mb-2 bg-info-subtle text-info-emphasis bg-opacity-10 border border-info border-start-0 rounded-end">Class not found.</p>
                <?php else: ?>
                    <input type="text" name="id" id="id" value="<?php echo $id; ?>" hidden>
                    <label for="class_name">Class Name</label>
                    <input type="text" id="class_name" name="class_name" size="50" value="<?= $class ?>" required>

                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Write something.." style="height:200px" required><?= $description ?></textarea>

                    <label for="trainer_id">Trainer ID</label>
                    <input type="number" id="trainer_id" name="trainer_id" size="50" value="<?= $trainer_id ?>" required>

                    <label for="category_id">Category ID</label>
                    <input type="number" id="category_id" name="category_id" size="50" value="<?= $category_id ?>" required>

                    <label for="schedule">Schedule</label>
                    <input type="datetime-local" id="schedule" name="schedule" size="50" value="<?= $schedule ?>" required>

                    <label for="max_capacity">Max Capacity</label>
                    <input type="text" id="max_capacity" name="max_capacity" size="50" value="<?= $max_capacity ?>" required>

                    <input type="submit" name="update" value="Update">
                    <input type="submit" name="delete" value="Delete">
                <?php endif ?>
            </fieldset>
        </form>
    </section>
</body>
</html>
