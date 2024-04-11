<?php
require("connect.php");

if($_POST && !empty($_POST['class_name']) && !empty($_POST['class_description']) && !empty($_POST['trainer_id']) && !empty($_POST['category_id']) && !empty($_POST['schedule']) && !empty($_POST['max_capacity'])) {
    $class_name = filter_input(INPUT_POST, 'class_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $class_description = filter_input(INPUT_POST, 'class_description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $trainer_id = filter_input(INPUT_POST, 'trainer_id', FILTER_SANITIZE_NUMBER_INT);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    $schedule = filter_input(INPUT_POST, 'schedule', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $max_capacity = filter_input(INPUT_POST, 'max_capacity', FILTER_SANITIZE_NUMBER_INT);

    $query = "INSERT INTO classes (class_name, description, trainer_id, category_id, schedule, max_capacity) VALUES (:class_name, :class_description
    , :trainer_id, :category_id, :schedule, :max_capacity)";
    $statement = $db->prepare($query);

    $statement->bindValue(':class_name', $class_name);
    $statement->bindValue(':class_description', $class_description);
    $statement->bindValue(':trainer_id', $trainer_id);
    $statement->bindValue(':category_id', $category_id);
    $statement->bindValue(':schedule', $schedule);
    $statement->bindValue(':max_capacity', $max_capacity);

    if($statement->execute()) {
        header("Location: admin_dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="add_class.css">
    <title>Add New Class</title>
</head>
<body>
    <header>
        <h1>Winnipeg Fitness Hub</h1>
    </header>
    <section id="New Class" class="tabcontent">
        <div>
            <fieldset>
             <legend>Add New Class</legend>
                <form class="create-class" action="admin_add_class.php" method="POST">
                    <label for="class_name">Class Name</label>
                    <input type="text" id="class_name" name="class_name" placeholder="Class Name" required>

                    <label for="class_description">Class Description </label>
                    <textarea id="class_description" name="class_description" placeholder="Write something.." style="height:200px" required></textarea>

                    <label for="trainer_id">Trainer ID</label>
                    <input type="number" id="trainer_id" name="trainer_id" placeholder="Trainer ID" required>

                    <label for="category_id">Category ID</label>
                    <input type="number" id="category_id" name="category_id" placeholder="Category ID" required>

                    <label for="schedule">Schedule</label>
                    <input type="datetime-local" id="schedule" name="schedule" placeholder="Schedule" required>

                    <label for="max_capacity">Max Capacity</label>
                    <input type="number" id="max_capacity" name="max_capacity" placeholder="Max Capacity" required>

                    <input type="submit" value="Submit">
                </form>
            </fieldset>
        </div>
    </section>
    <script src ="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>


