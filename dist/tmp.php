<?php require '../php/jf.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TMP</title>
</head>
<body style="background: grey">
   <?php if (field('is_docs_visible')) : ?>
      <h1>Docs</h1>
      <?= field('docs')['html']; ?>
   <?php endif; ?>
</body>
</html>
