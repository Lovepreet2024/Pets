<?php

session_start();


if (!isset($_SESSION['username'])) {

    header("location: login.php");
    exit;
}
?>


<?php
include 'dbinfo.php';


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_Pet'])) {

    $title = sanitize_input($_POST['Pet_title']);
    $content = sanitize_input($_POST['Pet_content']);
    $image_url = isset($_POST['Pet_image_url']) ? sanitize_input($_POST['Pet_image_url']) : ''; 


    $sql = "INSERT INTO Pets (title, content, image_url) VALUES ('$title', '$content', '$image_url')";

    if ($conn->query($sql) === TRUE) {
        echo "Pet added successfully";
    
        header("Location: pet-index.php");
        exit();
    } else {
        echo "Error adding Pet: " . $conn->error;
    }
}

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$conn->close();
?>