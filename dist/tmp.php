<?php
require '../php/__load.php';
$db = new JustField\DB($orm);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TMP</title>
</head>
<body style="background: grey">
   <?= $db->at_path('docs')->value['html']; ?>
</body>
</html>
