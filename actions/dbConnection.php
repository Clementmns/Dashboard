<?php
try {
   $db = new PDO('mysql:host=localhost;dbname=omnes', 'root', '');
} catch (Exception $e) {

   die('Erreur : ' . $e->getMessage());
}
