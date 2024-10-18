

<?php function productsByCategory(string $category) { ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria: <?= htmlspecialchars($category) ?></title>
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>
    <div class="container-searchResults">
        <h1>Categoria: <?= htmlspecialchars($category) ?></h1>
        
    </div>
</body>
<?php } ?>