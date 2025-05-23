<?php
session_start();
require_once '../../database/database.php'; // Use correct relative path

$message = '';
if (isset($_SESSION['login_message'])) {
    $message = $_SESSION['login_message'];
    unset($_SESSION['login_message']);
}

$conn = getDBConnection(); 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        
        $stmt = $conn->prepare("SELECT id, f_name, l_name, username, email, password FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result(); // 
        $user = $result->fetch_assoc();

        if ($user) {
            
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_firstname'] = $user['f_name']; 
            $_SESSION['user_lastname'] = $user['l_name']; 
            $_SESSION['user_username'] = $user['username']; 
            $_SESSION['user_email'] = $user['email']; 
            $_SESSION['user_id'] = $user['id']; // ✅ This is what your profile page needs


            header("Location: ../../user/index.php");
            exit();
        } else {
          $_SESSION['login_message'] = "Invalid email or password.";
            header("Location: login.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['login_message'] = "<div class='popup-message error'>Login error: " . $e->getMessage() . "</div>";
        header("Location: login.php");
        exit();
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Peasy Builder | Log In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="./login.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>


</head>


<body>

<?php if (!empty($message)): ?>
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <?= htmlspecialchars($message) ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="navbar"></div>

  <div class="container">



    <!-- <a class="mb-5" href="/Authentication/database.php"></a> -->

    <!-- <i class="bi bi-arrow-left-circle"></i> -->

    <form action="" method="POST">


      <h2>Login to PEasy</h2>

      <div class="textbox">
        <input type="text" name="email" required>
        <label>Enter your email</label>
      </div>

      <div class="textbox">
        <input type="password" name="password" required>
        <label>Enter your password</label>
      </div>

      <div class="forget">
        <label for="remember">
          <input type="checkbox" id="remember">
          <p class="remember">Remember me</p>
        </label>
      </div>

      <div class="forgot">
        <a href="/Authentication/forgot.php">Forgot password</a>
      </div>

      <input type="submit" id="butt" class="btn btn-success" value="Login">

      <div class="register">
        <p>Already have an account? <a href="../register/create.php">Create a new one</a></p>
      </div>
    </form>
  </div>


</body>

</html>

<script>
  window.addEventListener('DOMContentLoaded', (event) => {
    var toastEl = document.getElementById('liveToast');
    if (toastEl) {
      var toast = new bootstrap.Toast(toastEl);
      toast.show();
    }
  });
</script>