
<?php 

  require_once('../database/user.class.php');
?>

<?php function makeProfile(User $user, $session, $db) { ?>
  <head>
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Just+Another+Hand&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
  </head>
  <body>
    <div class="container-profile">
      <div class="first-line">
        <h1>Perfil</h1>
        <?php if($session->getId() == $user->user_id) { ?>
          <a href="../actions/action_logout.php" class="icon-link"><i class='bx bx-log-out'></i></a>
        <?php } ?> 
      </div>
      <div class="box-profile">
        <div class="left-profile">
          <div class="first">
            <img src="<?= $user->photo ? htmlspecialchars($user->photo) : '../images/profile.jpg' ?>" alt="Profile Image" class="img_profile"/>
            <h1>@<?=$user->username ?></h1>
          </div>
          <div class="profile-field">
            <h1><?=$user->name?></h1>
            <div class="city-field">
              <i class='bx bxs-map'></i>
              <h4>Cidade:</h4>
              <p><?=$user->city?></p>
            </div>
            <div class="bio-field">
              <div class="bio-box">
                <p><?=$user->bio?></p>
              </div>
            </div>
          </div> 
        </div>
        <div class="right-profile">
          <?php if($session->getId() == $user->user_id) { ?>
            <button class="editbutton" onclick="location.href='../pages/editprofile.php';"><i class='bx bxs-pencil'></i>Edit Profile</button>
          <?php } else { ?>
            <?php $currentUser = User::getUserById($db, $session->getId()); ?>
            <?php if ($currentUser->admin == true && $user->admin == false) { ?>
              <form action="../actions/action_promoteAdmin.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user->user_id; ?>">
                <button type="submit" class="control-panel"><i class='bx bx-arrow-from-bottom'></i>Promover a admin</button>
              </form>  
            <?php } else { ?>
              <div class="whiteBox"></div>
            <?php } ?>  
          <?php } ?> 
          <?php if($user->admin == true) { ?>
            <?php if($user->user_id == $session->getId()) { ?>
              <button class="control-panel" onclick="location.href='../pages/controlPanel.php';"><i class='bx bx-slider-alt'></i>Painel de Controlo</button>
            <?php } else { ?>
              <h4>Admin</h4>
            <?php } ?>  
          <?php } ?>  
        </div>
      </div>
      
      
    </div>
  </body>

<?php } ?>
