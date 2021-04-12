<?php
/*
// Sqlite connection to database
   class MyDB extends SQLite3 {
      function __construct() {
         $this->open('simplesmdr.db');
      }
   }
   $con = new MyDB();
   if(!$con) {
      echo $con->lastErrorMsg();
   }

   */
   $con = new PDO('sqlite:simplesmdr.db')
?>