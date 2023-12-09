<?php

class Contact {

          private $id;
          private $nom;
          private $prenom;
          private $categorie;

          private $host = 'localhost';
          private $dbname = 'contact-book';
          private $username = 'root';
          private $password = '';
          protected $db;

          function __construct()
          {
               $this->db = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
               $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
               $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
               $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
          }

          // GETTERS et SETTERS

          public function get_id() {
               return $this->id;
          }

          public function set_id(int $id) {
               $this->id = $id;
          }

          public function get_nom() {
               return $this->nom;
          }

          public function set_nom(string $nom) {
               $this->nom = $nom;
          }

          public function get_prenom() {
               return $this->prenom;
          }

          public function set_prenom(string $prenom) {
               $this->prenom = $prenom;
          }
          
          public function get_categorie() {
               return $this->categorie;
          }

          public function set_categorie(string $categorie) {
               $this->categorie = $categorie;
          }

          // les Méthodes de gestion de contact

          public function add_contact() {
               $query = $this->db->prepare("INSERT INTO contact(nom, prenom, categorie)
               VALUES(:nom, :prenom, :categorie)");
               $query->execute(array(
                    'nom' => $this->nom,
                    'prenom' => $this->prenom,
                    'categorie' => $this->categorie,
               ));

               return 1;
          }

          public function update_contact() {
               $query = $this->db->prepare("UPDATE contact SET nom=:nom, prenom=:prenom, categorie=:categorie WHERE id=:id");
               $query->execute(array(
                    'nom' => $this->nom,
                    'prenom' => $this->prenom,
                    'categorie' => $this->categorie,
                    'id' => $this->id,
               ));

               return 1;
          }

          public function get_contact() {
               $query = $this->db->prepare('SELECT * FROM contact WHERE id=?');
               $query->execute(array($this->id));

               return $query->fetch();
          }

          public function get_contacts() {
               $query = $this->db->query('SELECT * FROM contact ORDER BY id DESC');

               return $query->fetchAll();
          }
}