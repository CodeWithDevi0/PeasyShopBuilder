<?php
session_start(); // Start the session at the top

// Show message if it exists in session
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Remove it to avoid showing again
}

// Include your DB connection
$db_host = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_name = "peasy";
$db_port = 3306;

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name, $db_port);
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
		// Check if username already exists
		$checkUsernameStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
		$checkUsernameStmt->bind_param("s", $username);
		$checkUsernameStmt->execute();
		$checkUsernameStmt->store_result();

		// Now check email too (optional but good)
		$checkEmailStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
		$checkEmailStmt->bind_param("s", $email);
		$checkEmailStmt->execute();
		$checkEmailStmt->store_result();

		if ($checkUsernameStmt->num_rows > 0 && $checkEmailStmt->num_rows > 0) {
			$_SESSION['message'] = "<div class='popup-message error'> Both username and email already exist. Please choose different ones.</div>";
		} elseif ($checkUsernameStmt->num_rows > 0) {
			$_SESSION['message'] = "<div class='popup-message error'> Username already exists. Please choose a different one.</div>";
		} elseif ($checkEmailStmt->num_rows > 0) {
			$_SESSION['message'] = "<div class='popup-message error'> Email already exists. Please use a different one.</div>";
		} else {
			// Everything is unique, proceed to insert
			
					$stmt = $conn->prepare("INSERT INTO users (f_name, l_name, username, email, password) VALUES (?, ?, ?, ?, ?)");
					$stmt->bind_param("sssss", $firstname, $lastname, $username, $email, $password);
					$stmt->execute();
		
					$_SESSION['message'] = "<div class='popup-message success'> Account created successfully!</div>";
				}
			
			
	} catch (Exception $e) {
		$_SESSION['message'] = "<div class='popup-message error'> Error: " . $e->getMessage() . "</div>";
	}

    // Redirect to the same page to prevent resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="../register/create.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
	<title>Peasy Builder | Create an Account</title>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
	
<nav class="navbar navbar-expand-lg bg-success px-4 py-2">
  <div class="container-fluid">
    <!-- Logo and Brand -->
    <a class="navbar-brand d-flex align-items-center text-white" href="#">
      <img src="../../assets/nobg.png" alt="Logo" width="120" height="120" class="me-2">
      <strong>PEasy</strong>
    </a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Right Nav Icons -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="#"><i class="bi bi-bag fs-4"></i></a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white" href="#"><i class="bi bi-chat-left fs-4"></i></a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link text-white d-flex align-items-center" href="../signIn/login.php">
            <i class="bi bi-person-fill-exclamation fs-1 me-1"></i> <span>Login</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white d-flex align-items-center" href="../register/create.php">
            <i class="bi bi-person-exclamation fs-1 me-1"></i> <span>Register</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="auth-container">
    <div class="main" style="margin-bottom: 5%;">
        <!-- Popup message positioned at the top -->
        <?php if (!empty($message)): ?>
            <div class="popup-container">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <a class="mb-5" href="../signIn/login.php">
                <i class="bi bi-arrow-left-circle fs-1"></i>
            </a>

            <form action="" method="POST">
                <label for="chk" aria-hidden="true" class="fs-1">Sign up</label>

                <input type="text" name="firstname" placeholder="First Name" required />
                <input type="text" name="lastname" placeholder="Last Name" style="margin-top: 5%;" required />
                <input type="text" name="username" placeholder="Username" style="margin-top: 5%;" required />
                <input type="email" name="email" placeholder="Email Address" style="margin-top: 5%;" required />
                <input type="password" name="password" placeholder="Password" style="margin-top: 5%;" required />
                
                <button type="submit" style="color: #ffffff; margin-top: 5%; border-radius: 10px;">Create</button>
            </form>
        </div>
    </div>
</div>

    <script>
        // Optional JS to completely remove the message after 5s
        setTimeout(() => {
            const msg = document.querySelector('.popup-message');
            if (msg) msg.remove();
        }, 5000);
    </script>
</body>
</html>
