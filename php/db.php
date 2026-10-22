
<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "fitzone"
);

if (!$conn) {
    die("Database connection failed.");
}

mysqli_set_charset($conn, "utf8mb4");

?>
