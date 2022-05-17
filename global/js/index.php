<?php
   session_start();
   session_destroy();
   $redirectto='/phpcrudajax/login/login.php';
   header("Location:".$redirectto);
   die();