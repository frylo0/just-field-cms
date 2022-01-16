<?php require '__php/jf.php'; ?>

<html>
   
   <head>
      <title>Sending HTML email using PHP</title>
      <link rel="stylesheet" href="tmp.css">
   </head>
   
   <body>

      <?php // phpinfo(); ?>
      
      <?php
         if (array_key_exists('to', $_POST)) {
            $to = $_POST['to'];
            $subject = $_POST['subject'];
            
            $message = $_POST['message'];
            
            $header = "From:{$_POST['from']} \r\n";
            // $header .= "Cc:email1@gmail.com,email2@gmail.com,email3@gmail.com \r\n"; // another recipients visible
            // $header .= "Bcc:email1@gmail.com,email2@gmail.com,email3@gmail.com \r\n"; // another recipients hidden
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            
            $retval = mail ($to,$subject,$message,$header);
            
            if( $retval == true ) {
               echo "<strong style=\"color: green;\">Message sent successfully!!!</strong>";
            }else {
               echo "<strong style=\"color: red\">Message could not be sent...</strong>";
            }
         }
      ?>

      <!--<form action="./tmp.php" method="post">

         <input type="text" name="from" id="" placeholder="from"><br>
         <input type="text" name="to" id="" placeholder="to"><br>
         <input type="text" name="subject" id="" placeholder="subject"><br>
         <input type="text" name="message" id="" placeholder="message"><br>
         
         <input type="submit" value="send">

      </form>-->
      
      <?php
      // STOP: ADDING viewed and bought counters to all products

      $products_all = [];

      $root = $db->get_root()->walker;
      $products_all = array_merge($products_all,  $root->pages->consult->types('children')  );
      $products_all = array_merge($products_all,  $root->pages->consult->rating('children')  );
      $products_all = array_merge($products_all,  $root->pages->event('children')  );
      $products_all = array_merge($products_all,  $root->pages->shop('children')  );

      //foreach ($products_all as $product) {
      //   echo $product->key.': '.$product->name.'<br>';

      //   $field = $product->add_field($db->type_id('field'));
      //   $field->update('key', 'viewed_count');
      //   $field->update('name', 'Просмотрено');
      //   $field->update('value', '0');

      //   $field = $product->add_field($db->type_id('field'));
      //   $field->update('key', 'bought_count');
      //   $field->update('name', 'Куплено');
      //   $field->update('value', '0');

      //   echo $product->key.': '.$product->name.': success<br>';
      //}

      ?>
      
   </body>
</html>
