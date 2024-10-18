<?php function makeControlPanel() { ?>
  <head>
    <title>Painel de controlo</title>
    <link rel="stylesheet" href="../css/controlPanel.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Just+Another+Hand&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
  </head>
  <body>
    <div class="container-controlPanel">
      <h1>Painel de Controlo</h1>
      <div class="box-controlPanel">
        <h2>Add Menu</h2>
        <form action="../actions/action_addCategory.php" method="post">
          <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
          <label for="category">Category:</label>
          <input type="text" name="category" id="category" placeholder="Category">
          <input type="submit" value="Submit">
        </form>
        <form action="../actions/action_addSize.php" method="post">
          <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
          <label for="size">Size:</label>
          <input type="text" name="size" id="size" placeholder="Size">
          <input type="submit" value="Submit">
        </form>
        <form action="../actions/action_addCondition.php" method="post">
          <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
          <label for="condition">Condition:</label>
          <input type="text" name="condition" id="condition" placeholder="Condition">
          <input type="submit" value="Submit">
        </form>
      </div>
    </div>
  </body>
<?php } ?>