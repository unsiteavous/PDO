<?php
// On lance l'autoload
require_once __DIR__."/autoload.php";

// Vérification que la base de données est bien existante
require_once __DIR__ . "/../config.php";

if (DB_INITIALIZED == FALSE ) {
  $db = new Database();
  echo $db->initialisationBDD();
}