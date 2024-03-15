<?php

class Film
{
  private $Id, $Nom, $UrlAffiche, $LienTrailer, $Resume, $Duree, $DateSortie, $IdClassificationAgePublic;


  public function __construct(array $data = array())
  {
    $this->hydrate($data);
  }

  private function hydrate(array $data): void
  {
    foreach ($data as $key => $value) {
      $parts = explode('_', $key);
      $setter = 'set';
      foreach ($parts as $part) {
        $setter .= ucfirst(strtolower($part));
      }

      $this->$setter($value);
    }
  }


  /**
   * Get the value of Id
   */
  public function getId(): int
  {
    return $this->Id;
  }

  /**
   * Set the value of Id
   *
   */
  public function setId(int $Id)
  {
    $this->Id = $Id;
  }

  /**
   * Get the value of Nom
   */
  public function getNom(): string
  {
    return $this->Nom;
  }

  /**
   * Set the value of Nom
   *
   */
  public function setNom(string $Nom)
  {
    $this->Nom = $Nom;
  }

  /**
   * Get the value of UrlAffiche
   */
  public function getUrlAffiche(): string
  {
    return $this->UrlAffiche;
  }

  /**
   * Set the value of UrlAffiche
   *
   */
  public function setUrlAffiche(string $UrlAffiche)
  {
    $this->UrlAffiche = $UrlAffiche;
  }

  /**
   * Get the value of LienTrailer
   */
  public function getLienTrailer(): string
  {
    return $this->LienTrailer;
  }

  /**
   * Set the value of LienTrailer
   *
   */
  public function setLienTrailer(string $LienTrailer)
  {
    $this->LienTrailer = $LienTrailer;
  }

  /**
   * Get the value of Resume
   */
  public function getResume(): string
  {
    return $this->Resume;
  }

  /**
   * Set the value of Resume
   *
   */
  public function setResume(string $Resume)
  {
    $this->Resume = $Resume;
  }

  /**
   * Get the value of Duree
   */
  public function getDuree(): string
  {
    return $this->Duree;
  }

  /**
   * Set the value of Duree
   *
   */
  public function setDuree(string $Duree)
  {
    $this->Duree = $Duree;
  }

  /**
   * Get the value of DateSortie
   */
  public function getDateSortie(): string
  {
    return $this->DateSortie;
  }

  /**
   * Set the value of DateSortie
   *
   */
  public function setDateSortie(string $DateSortie)
  {
    $this->DateSortie = $DateSortie;
  }

  /**
   * Get the value of IdClassificationAgePublic
   */
  public function getIdClassificationAgePublic(): int
  {
    return $this->IdClassificationAgePublic;
  }

  /**
   * Set the value of IdClassificationAgePublic
   *
   */
  public function setIdClassificationAgePublic(int $IdClassificationAgePublic)
  {
    $this->IdClassificationAgePublic = $IdClassificationAgePublic;
  }

  public function __set($name, $value)
  {
    $this->hydrate([$name => $value]);
  }

  public function __serialize(): array
  {
    $class = new \ReflectionClass(get_class($this));

    $ObjToArray = [];
    foreach ($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $methode) {
      $nomMethode = $methode->getName();
      if (strpos($nomMethode, 'get') === 0) {
        // Vérifie si le nom de la méthode commence par 'get'
        $ObjToArray[$nomMethode] = $this->$nomMethode();
      }
    }
    return $ObjToArray;
  }

  public function __unserialize(array $data): void
  {
    $this->hydrate($data);
  }
}
