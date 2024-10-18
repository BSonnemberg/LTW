<?php function homePage() { ?>
  <head>
    <title>Binted</title>
    <link rel="stylesheet" href="../css/homepage.css" />
    <script
      src="https://kit.fontawesome.com/24ad015d00.js"
      crossorigin="anonymous"
    ></script>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Just+Another+Hand&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
  </head>
  <body>
    <section class="ad_images">
      <article id="clothes_article">
        <img src="../images/clothes.jpg" alt="" />
        <a href="../pages/productsByCategory.php?category=Roupa">
          <h3>ROUPA ></h3>
          <h2>Encontre o seu outfit</h2>
        </a>
      </article>
      <article id="house_article">
        <img src="../images/house.jpg" alt="" />
        <a href="../pages/productsByCategory.php?category=Mobília">
          <h3>MOBÍLIA ></h3>
          <h2>A sua casa merece o melhor</h2>
        </a>
      </article>
      <article id="entertainment_article">
        <img src="../images/gaming.jpg" alt="" />
        <a href="../../pages/productsByCategory.php?category=Entretenimento">
          <h3>ENTRETENIMENTO ></h3>
          <h2>Ache diversas formas de diversão</h2>
        </a>
      </article>
    </section>
  </body>
<?php } ?>
