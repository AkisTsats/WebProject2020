<?php

include('functions.php');
include('admin_helper.php');

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HARamata</title>
  <link rel="stylesheet" type="text/css" href="css/custom.css">
  <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
</head>

<body>
  <div class="wrapper">
    <div class="wrapper-body">
      <?php include("includes/header.php"); ?>
      <div class="header">
        <table>
          <thead>
            <th>Filename</th>
            <th>Uploaded in</th>
          </thead>
          <tbody>
            <?php for ( $i = 0; $i < $rep; $i++) : ?>
                <tr>
                  <td><a href="api_getFile.php/?filename=<?= $file ?>.json"><?= $files[$i] ?></a></td>
                  <td><?php echo $times[$i] ?></td>
                </tr>
              <?php endfor; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>