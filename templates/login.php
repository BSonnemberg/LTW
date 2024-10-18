<?php
function login() { ?>


   <head>
      <link rel="icon" href="../images/logo.png">
      <title>Login</title>
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <link rel="stylesheet" href="../css/login.css">
      <meta charset="utf-8">
   </head>
   <body>
      <div class="wrapper">
      <form action="../actions/action_login.php" method="post" class="login-form">
          <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
          <h1>Login</h1>
          <div class="input_box">
            <input type="email" name="email" id="email" placeholder="email" required>
            <i class='bx bxs-user'></i>
          </div>  
          <div class="input_box">
            <input type="password" name="password" id="password" placeholder="password" required>
            <i class='bx bxs-lock-alt' ></i>
          </div> 
          <button type="submit" class="submit">Login</button>
          <div class="register_link">
            <p>Don't have an account? <a href="../pages/register.php">Register</a></p>
          </div>
        </form>
      </div>
   </body>
   <?php
} ?>