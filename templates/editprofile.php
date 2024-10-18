<?php 
  declare(strict_types = 1); 

  require_once('../database/user.class.php');
?>

<?php function editProfile(User $user) { ?>
  <head>
    <title>Profile</title>
    <link rel="stylesheet" href="../css/editprofile.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Just+Another+Hand&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
  </head>
  <body>
    <div class="container-edit">
      <form action="../actions/action_editProfile.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
        <h1>Definições</h1>
        <div class="box-inputs">
          <h2>Perfil</h2>
          <div class="input-field">
            <label for="photo">Foto de Perfil</label>
            <input type="file" name="photo" id="photo">
          </div>
          <div class="input-field">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" placeholder="Name" value="<?php echo $user->name; ?>">
          </div>
          <div class="input-field">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $user->username; ?>">
          </div>
          <div class="input-field">
            <label for="city">Cidade</label>
            <input type="text" name="city" id="city" placeholder="Cidade" value="<?php echo $user->city; ?>">
          </div>
          <div class="input-field">
            <label for="bio">Biografia</label>
            <textarea placeholder="Conta-nos algo sobre ti..." maxlength="100" name="bio" id="bio"><?php echo $user->bio; ?></textarea>
          </div>
        </div>
        <div class="box-inputs">
          <h2>Dados Pessoais</h2>
          <div class="input-field">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" value="<?php echo htmlspecialchars($user->email); ?>">
          </div>
          <div class="input-field">
            <label for="phone">Telemóvel</label>
            <input type="phone" name="phone" id="phone" placeholder="Phone" value="<?php echo htmlspecialchars($user->phone); ?>">
          </div>
        </div>
        <div class="box-inputs">
          <h2>Password</h2>
          <div class="input-field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password">
          </div>
          <div class="input-field">
            <label for="confirm-password">Confirm password</label>
            <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password">
          </div>
        </div>
        <button class="saveEdit" type="submit">Guardar</button>
      </form>
    </div>
  </body>

<?php } ?>


