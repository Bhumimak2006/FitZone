
<?php

session_start();
require_once "db.php";

// Only allow form submission
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../register.html");
    exit();
}

// Get form data
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$phone = trim($_POST["phone"] ?? "");
$age = (int)($_POST["age"] ?? 0);
$gender = trim($_POST["gender"] ?? "");
$membership = trim($_POST["membership"] ?? "");
$goal = trim($_POST["goal"] ?? "");
$start_date = trim($_POST["start_date"] ?? "");
$message = trim($_POST["message"] ?? "");

// Validate required fields
if (
    $name === "" ||
    $email === "" ||
    $phone === "" ||
    $age <= 0 ||
    $password === ""
) {
    die("Please fill all required fields.");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

// Validate password
if (strlen($password) < 8) {
    die("Password must be at least 8 characters.");
}

// Validate phone number
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    die("Phone number must contain exactly 10 digits.");
}

// Find membership ID
$stmt = mysqli_prepare(
    $conn,
    "SELECT id FROM memberships WHERE name = ?"
);

mysqli_stmt_bind_param($stmt, "s", $membership);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    die("Invalid membership plan. Please select a valid plan.");
}

$membership_id = (int)$row["id"];

// Handle optional profile photo
$photoName = "";

if (
    isset($_FILES["photo"]) &&
    $_FILES["photo"]["error"] !== UPLOAD_ERR_NO_FILE
) {
    if ($_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
        die("Photo upload failed.");
    }

    $allowedTypes = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    $fileType = mime_content_type($_FILES["photo"]["tmp_name"]);

    if (!isset($allowedTypes[$fileType])) {
        die("Only JPG, PNG and WEBP images are allowed.");
    }

    // Create uploads folder if it does not exist
    $uploadDirectory = __DIR__ . "/../uploads/";

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true);
    }

    $photoName = bin2hex(random_bytes(16))
        . "." . $allowedTypes[$fileType];

    $uploadPath = $uploadDirectory . $photoName;

    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $uploadPath)) {
        die("Could not save the uploaded photo.");
    }
}

// Hash password before saving
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insert registration data
$sql = "INSERT INTO members
    (name, email, password, phone, age, gender,
     membership_id, goal, start_date, photo, message)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Could not prepare registration.");
}

mysqli_stmt_bind_param(
    $stmt,
    "ssssisissss",
    $name,
    $email,
    $passwordHash,
    $phone,
    $age,
    $gender,
    $membership_id,
    $goal,
    $start_date,
    $photoName,
    $message
);

// Execute registration
if (mysqli_stmt_execute($stmt)) {
    $_SESSION["registered_email"] = $email;

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Registration Successful - FitZone</title>
        <link rel='stylesheet' href='../css/style.css'>
    </head>
    <body>
        <section class='form-section'>
            <h1>Registration Successful!</h1>
            <p>Welcome to FitZone, "
            . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') .
            ".</p>
            <p>Your details have been saved.</p>
            <a href='../login.html' class='btn'>Login Now</a>
            <a href='../index.html' class='btn'>Go Home</a>
        </section>
    </body>
    </html>";
    exit();
}

// Handle duplicate email or other database errors
if (mysqli_errno($conn) === 1062) {
    echo "This email is already registered. Please use another email or login.";
} else {
    echo "Registration failed. Please check your database table and try again.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
