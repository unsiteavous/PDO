<?php

final class Database
{
  private $DB;
  private $config;

  public function __construct()
  {
    $this->config = __DIR__ . '/../../config.php';
    require_once $this->config;

    try {
      $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
      $this->DB = new PDO($dsn, DB_USER, DB_PWD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $error) {
      echo "Erreur de connexion à la Base de Données : " . $error->getMessage();
    }
  }

  /**
   * Retourne la connexion BDD établie et l'objet PDO associé.
   */
  public function getDB(): PDO
  {
    return $this->DB;
  }

  /**
   * Initialisation de la Base de Données : installation des tables et mise à jour du fichier config.php
   * @return string message d'échec ou de réussite.
   */
  public function initialisationBDD(): string
  {

    // Vérifier si la base de données est vide
    if ($this->testExistenceTableFilms()) {
      return "La base de données semble déjà remplie.";
      die();
    }
    // Télécharger le fichier sql d'initialisation dans la BDD
    try {
      $sql = file_get_contents(__DIR__. "/../Migrations/cinema-remplie.sql");

      $this->DB->query($sql);
    // Mettre à jour le fichier config.php

      if($this->MiseAJourConfig()){
        return "installation de la Base de Données terminée !";
      }

    } catch(PDOException $erreur){
      return "impossible de remplir la Base de données : " . $erreur->getMessage();
    }
  }

  /**
   * Vérifie si la table Films existe déjà dans la BDD
   * @return bool
   */
  private function testExistenceTableFilms(): bool {
    $existant = $this->DB->query('SHOW TABLES FROM ' . DB_NAME . ' like \'films\'')->fetch();

    if ($existant !== false && $existant[0] == "films") {
      return true;
    } else {
      return false;
    }
  }


  private function MiseAJourConfig() : bool {

      $fconfig = fopen($this->config, 'w');

      $contenu = "<?php
      // lors de la mise en open source, remplacer les infos concernant la base de données.
      
      define('DB_HOST', '". DB_HOST ."');
      define('DB_NAME', '". DB_NAME ."');
      define('DB_USER', '". DB_USER ."');
      define('DB_PWD', '". DB_PWD ."');
      
      // Ne pas toucher :
      
      define('DB_INITIALIZED', TRUE);";
      

      if (fwrite($fconfig, $contenu)) {
        fclose($fconfig);
        return true;
      } else {
        return false;
      }
  }
}

