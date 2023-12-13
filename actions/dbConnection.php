<?php
try {
   $db = new PDO('mysql:host=localhost;dbname=omnescle_sae303', 'root', '');
} catch (Exception $e) {

   die('Erreur : ' . $e->getMessage());
}
