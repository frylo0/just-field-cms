<?php require '../php/jf.php'; ?>

<html>
   
   <head>
      <title>Sending HTML email using PHP</title>
   </head>
   
   <body>
      
      <?php
         if (array_key_exists('to', $_POST)) {
            $to = $_POST['to'];
            $subject = $_POST['subject'];
            
            $message = $_POST['message'];
            
            $header = "From:{$_POST['from']} \r\n";
            $header .= "Cc:afgh@somedomain.com \r\n";
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

      <form action="./tmp.php" method="post">

         <input type="text" name="from" id="" placeholder="from"><br>
         <input type="text" name="to" id="" placeholder="to"><br>
         <input type="text" name="subject" id="" placeholder="subject"><br>
         <input type="text" name="message" id="" placeholder="message"><br>
         
         <input type="submit" value="send">

      </form>
      
   </body>
</html>