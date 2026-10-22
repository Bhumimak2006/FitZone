<?php

session_start();

require_once "db.php";


if (!isset($_SESSION["user_id"])) {

    header("Location: ../login.html");

    exit();

}


$userId =
    $_SESSION["user_id"];


$stmt = mysqli_prepare(
    $conn,

    "SELECT
        members.*,
        memberships.name AS membership_name,
        memberships.price
     FROM members

     LEFT JOIN memberships
     ON members.membership_id =
        memberships.id

     WHERE members.id = ?"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $userId
);


mysqli_stmt_execute($stmt);


$result =
    mysqli_stmt_get_result($stmt);


$member =
    mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Dashboard - FitZone</title>

    <link
        rel="stylesheet"
        href="../css/style.css">

</head>


<body>


<header class="header">

    <div class="logo">
        FIT<span>ZONE</span>
    </div>

    <nav>

        <a href="../index.html">
            Home
        </a>

        <a href="logout.php">
            Logout
        </a>

    </nav>

</header>


<section class="form-section">

    <h1>
        Welcome,
        <?= htmlspecialchars(
            $member["name"]
        ) ?>
    </h1>


    <p>
        Email:
        <?= htmlspecialchars(
            $member["email"]
        ) ?>
    </p>


    <p>
        Phone:
        <?= htmlspecialchars(
            $member["phone"]
        ) ?>
    </p>


    <p>
        Membership:
        <?= htmlspecialchars(
            $member["membership_name"]
        ) ?>
    </p>


    <p>
        Price:
        ₹<?= htmlspecialchars(
            $member["price"]
        ) ?>
    </p>


    <p>
        Fitness Goal:
        <?= htmlspecialchars(
            $member["goal"]
        ) ?>
    </p>


    <p>
        Start Date:
        <?= htmlspecialchars(
            $member["start_date"]
        ) ?>
    </p>


    <?php if (!empty($member["photo"])): ?>

        <img
            src="../uploads/
            <?= htmlspecialchars(
                $member["photo"]
            ) ?>"
            alt="Profile"
            width="150">

    <?php endif; ?>


</section>


</body>

</html>