<?php
function register() { ?>

   <head>
      <link rel="icon" href="../images/logo.png">
      <title>Register</title>
      <link rel="stylesheet" href="/css/register.css">
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Just+Another+Hand&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');
      </style>
   </head>
   <body>
      <div class = "wrapper">
      <form action="../actions/action_register.php" method="post" class="signup-form">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <h1>Registration</h1>
            <div class="input_box">
              <div class="input_field">
                <input type="text" name="name" id="name" placeholder="Full Name" required> 
                <i class='bx bxs-user'></i>
              </div>
              <div class="input_field">
                <input type="text" name="username" id="username" placeholder="Username" required> 
                <i class='bx bxs-user'></i>
              </div>
            </div>

            <div class="input_box">
              <div class="input_field">
                <input type="email" name="email" id="email" placeholder="Email" required> 
                <i class='bx bx-envelope'></i>
              </div>
              <div class="input_field">
                <input type="phone" name="phone" id="phone" placeholder="Phone" required>
                <i class='bx bxs-phone'></i> 
              </div>
            </div>

            <div class="input_box">
              <div class="input_field">
                <input type="password" name="password" id="password" placeholder="Password" required> 
                <i class='bx bxs-lock-alt' ></i>
              </div>
              <div class="input_field">
                <input type="password" name= "password2" id= "password2" placeholder="Confirm Password" required> 
                <i class='bx bxs-lock-alt' ></i>
              </div>
            </div>
            
            <button type="submit" class="btn">
              Register
            </button>
        </form>
      </div>
   </body>
   <?php
} ?>