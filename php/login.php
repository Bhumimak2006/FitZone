<?php

session_start();

require_once "db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../login.html");

    exit();

}


$email =
    trim($_POST["email"] ?? "");

$password =
    $_POST["password"] ?? "";


$stmt = mysqli_prepare(
    $conn,

    "SELECT
        id,
        name,
        email,
        password
     FROM members
     WHERE email = ?"
);


mysqli_stmt_bind_param(
    $stmt,
    "s",
    $email
);


mysqli_stmt_execute($stmt);


$result =
    mysqli_stmt_get_result($stmt);


$user =
    mysqli_fetch_assoc($result);


if (
    $user &&
    $user["password"] !== null &&
    password_verify(
        $password,
        $user["password"]
    )
) {

    $_SESSION["user_id"] =
        $user["id"];

    $_SESSION["user_name"] =
        $user["name"];

    $_SESSION["user_email"] =
        $user["email"];


    setcookie(
        "last_login",
        date("Y-m-d H:i:s"),
        time() + 86400
    );


    header(
        "Location: dashboard.php"
    );

    exit();

}


echo "Invalid email or password.";

?>