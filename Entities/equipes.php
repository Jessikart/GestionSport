<?php
/**
* @author Jean-Marie Pecatte jean-marie.pecatte@iut-tlse3.fr
* @copyright MMI Castres
*/

/**
* Définition d'une classe permettant de gérer une equipe
* en relation avec la base de données
*
*/
class Equipes {
        private $_id_equipe;
        private $_nom;
        private $_date_de_creation;
		private $_embleme;
		private $_entraineur;
		private $_victoires;
		private $_defaites;
		private $_ville;
        /**
		* contructeur : initialise l'equipe à partir d'un tableau de données
		* chaque case du tableau doit avoir comme indice le nom de la propriété
		* sans le $_
		*/
        public function __construct(array $donnees) {
            $this->hydrate($donnees);
        }
        /**
        * initialisation d'une equipe à partir d'un tableau de données 
        * [id_equipe][nom][date_de_cration][embleme][entraineur]
        */
        public function hydrate(array $donnees) {
			if (isset($donnees['id_equipe'])) { $this->_id_equipe = $donnees['id_equipe']; }
			if (isset($donnees['nom'])) { $this->_nom = $donnees['nom']; }
			if (isset($donnees['date_de_creation'])) { $this->_date_de_creation = $donnees['date_de_creation']; }
			if (isset($donnees['embleme'])) { $this->_embleme = $donnees['embleme']; }
			if (isset($donnees['entraineur'])) { $this->_entraineur = $donnees['entraineur']; }
			if (isset($donnees['victoires'])) { $this->_victoires = $donnees['victoires']; }
			if (isset($donnees['defaites'])) { $this->_defaites = $donnees['defaites']; }
			if (isset($donnees['ville'])) { $this->_ville = $donnees['ville']; }
        }            
        // GETTERS //
        public function id_equipe() { return $this->_id_equipe;}
		public function nom() { return $this->_nom;}
		public function date_de_creation() { return $this->_date_de_creation;}
		public function embleme() { return $this->_embleme;}
		public function entraineur() { return $this->_entraineur;}
		public function victoires() { return $this->_victoires;}
		public function defaites() { return $this->_defaites;}
		public function ville() { return $this->_ville;}
		
		// SETTERS //
        public function setId_equipe($id_equipe) { $this->_id_equipe = $id_equipe; }
        public function setNom($nom) { $this->_nom= $nom; }
		public function setDate_de_creation($date_de_creation) { $this->_date_de_creation = $date_de_creation; }
		public function setEmbleme($embleme) { $this->_embleme = $embleme; }
		public function setEntraineur($entraineur) { $this->_entraineur = $entraineur; }
	public function setVictoires($victoires) { $this->_victoires = $victoires; }
	public function setDefaites($defaites) { $this->_defaites = $defaites; }
	public function setVille($ville) { $this->_ville = $ville; }
    }


?>