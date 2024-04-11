<?php

require("connect.php");

function getUserCount() {
    $query = "SELECT COUNT(*) FROM Users";
    $statement = $db->prepare($query);
    $statement->execute();
    $userCount = $statement->fetch();
    return $userCount;
}

function getTrainerCount() {
    $query = "SELECT COUNT(*) FROM trainers";
    $statement = $db->prepare($query);
    $statement->execute();
    $trainerCount = $statement->fetch();
    return $trainerCount;
}

function getClassCount() {
    $query = "SELECT COUNT(*) FROM classes";
    $statement = $db->prepare($query);
    $statement->execute();
    $classCount = $statement->fetch();
    return $classCount;
}

function editProile($db){
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'old_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(strlen($username) > 0 && strlen($email) > 0 && strlen($password) > 0 && strlen($role) > 0){
        $query = "UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':role', $role);
        $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        header("Location: admin_users.php");
        exit;
    }

}

function deleteProfile($db){
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "DELETE FROM users WHERE email = :email AND role != 'admin'";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();

    header("Location: admin_users.php");
    exit;
}

function changePassword($db){
    $newpassword = filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);

    $update = "UPDATE users SET password = :password WHERE email = :email";
    $statement = $db->prepare($update);
    $statement->bindValue(':password', $hashed_password);
    $statement->bindValue(':email', $email);
    $statement->execute();
    
    header("Location: admin_users.php");
    exit;
}

function searchUser($db){
    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM users WHERE username LIKE :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    return $statement;
}

function searchTrainer($db){
    $trainer_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM trainers WHERE trainer_id = :trainer_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':trainer_id', $trainer_id);
    $statement->execute();
    return $statement;

}

function searchClass($db){
    $class_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM classes WHERE class_id = :class_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':class_id', $class_id);
    $statement->execute();
    return $statement;
}

function editClasses($db){
    $class_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $class_name = filter_input(INPUT_POST, 'class_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $trainer_id = filter_input(INPUT_POST, 'trainer_id', FILTER_SANITIZE_NUMBER_INT);
    $schedule = filter_input(INPUT_POST, 'schedule', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    $max_capacity = filter_input(INPUT_POST, 'max_capacity', FILTER_SANITIZE_NUMBER_INT);

    if(strlen($class_name) > 0 && strlen($description) > 0 && strlen($max_capacity) > 0 && strlen($trainer_id) > 0 && strlen($category_id) > 0 && strlen($class_id) > 0){
        $query = "UPDATE classes SET class_name = :class_name, description = :description, trainer_id = :trainer_id, category_id = :category_id, schedule = :schedule, max_capacity = :max_capacity WHERE class_id = :class_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':class_name', $class_name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':trainer_id', $trainer_id);
        $statement->bindValue(':category_id', $category_id);
        $statement->bindValue(':schedule', $schedule);
        $statement->bindValue(':max_capacity', $max_capacity);
        $statement->bindValue(':class_id', $class_id, PDO::PARAM_INT);

        $statement->execute();

        header("Location: admin_class.php");
    }
}

function deleteClasses($db){
    //$class_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $class_id = $_POST['id'];
    $query = "DELETE FROM classes WHERE class_id = :class_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':class_id', $class_id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: admin_class.php?class_id = $class_id");
}


function editTrainers($db){
    $trainer_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(strlen($name) > 0 && strlen($bio) > 0){
        $query = "UPDATE trainers SET name = :name, bio = :bio WHERE trainer_id = :trainer_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':bio', $bio);
        $statement->bindValue(':trainer_id', $trainer_id, PDO::PARAM_INT);
        $statement->execute();

        header("Location: admin_trainer.php");
    }
}

function deleteTrainers($db){
    $trainer_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM trainers WHERE trainer_id = :trainer_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':trainer_id', $trainer_id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: admin_trainer.php");
}
?>