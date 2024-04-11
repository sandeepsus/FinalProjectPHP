<?php

require("functions.php");

$trainer = "";
$bio = "";
$trainerNotFound = false; 
if(isset($_GET['id'])) {
    $statement = searchTrainer($db);
    // Check if any rows are returned
    if ($row = $statement->fetch()) {
        $id = $row['trainer_id'];
        $trainer = $row['name'];
        $bio = $row['bio'];
    } else {
        // No users found in the database with the entered user ID
        $trainerNotFound = true;
    }
}

if (isset($_POST['update'])) {
    editTrainers($db);
} elseif (isset($_POST['delete'])) {
    deleteTrainers($db);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trainer</title>
    <link rel="stylesheet" href="edit_trainer.css">
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
    <section id="trainers">
        <h2>Edit Trainer</h2>
        <form action="edit_trainer.php" method="POST">
            <fieldset>
                <legend>Edit Trainer</legend>
                <?php if ($trainerNotFound): ?>
                    <p class="message p-3 mb-2 bg-info-subtle text-info-emphasis bg-opacity-10 border border-info border-start-0 rounded-end">Trainer not found.</p>
                <?php else: ?>
                    <input type="text" name="id" id="id" value="<?php echo $id; ?>" hidden>
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" size="50" value="<?= $trainer ?>" required>

                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" placeholder="Write something.." style="height:200px" required><?= $bio ?></textarea>

                    <input type="submit" name="update" value="Update">
                    <input type="submit" name="delete" value="Delete" >
                <?php endif; ?>
            </fieldset>
        </form>
    </section>
</body>
</html>