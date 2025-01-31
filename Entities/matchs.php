<?php
/**
* @author Jean-Marie Pecatte jean-marie.pecatte@iut-tlse3.fr
* @copyright MMI Castres
*/

/**
* Définition d'une classe permettant de gérer un match
* en relation avec la base de données
*
*/
class Matchs {
        private $_id_matchs;
		private $_nom_match;
        private $_buts_marques_EH;
        private $_buts_marques_EV;
		private $_equipe_hote;
		private $_equipe_visiteuse;
		private $_embleme_equipe_hote;
   		private $_embleme_equipe_visiteuse;
		private $_commentaire;
		private $_date_match;
		private $_lieu;
		private $_statut;
        /**
		* contructeur : initialise le match à partir d'un tableau de données
		* chaque case du tableau doit avoir comme indice le nom de la propriété
		* sans le $_
		*/
        public function __construct(array $donnees) {
            $this->hydrate($donnees);
        }
        /**
        * initialisation d'un match à partir d'un tableau de données 
        * [id_matchs][buts_marques_EH][buts_marques_EV][equipe_hote][equipe_visiteuse]
        */
        public function hydrate(array $donnees) {
			if (isset($donnees['id_matchs'])) { $this->_id_matchs = $donnees['id_matchs']; }
			if (isset($donnees['nom_match'])) { $this->_nom_match = $donnees['nom_match']; }
			if (isset($donnees['buts_marques_EH'])) { $this->_buts_marques_EH = $donnees['buts_marques_EH']; }
			if (isset($donnees['buts_marques_EV'])) { $this->_buts_marques_EV = $donnees['buts_marques_EV']; }
			if (isset($donnees['equipe_hote'])) { $this->_equipe_hote = $donnees['equipe_hote']; }
			if (isset($donnees['equipe_visiteuse'])) { $this->_equipe_visiteuse = $donnees['equipe_visiteuse']; }
			if (isset($donnees['embleme_equipe_hote'])) { $this->_embleme_equipe_hote = $donnees['embleme_equipe_hote']; }
			if (isset($donnees['embleme_equipe_visiteuse'])) { $this->_embleme_equipe_visiteuse = $donnees['embleme_equipe_visiteuse']; }
			if (isset($donnees['commentaire'])) { $this->_commentaire = $donnees['commentaire']; }
			if (isset($donnees['date_match'])) { $this->_date_match = $donnees['date_match']; }
			if (isset($donnees['lieu'])) { $this->_lieu = $donnees['lieu']; }
			if (isset($donnees['statut'])) { $this->_statut = $donnees['statut']; }
        }  
	
        // GETTERS //
        public function id_matchs() { return $this->_id_matchs;}
		public function nom_match() { return $this->_nom_match;}
		public function buts_marques_EH() { return $this->_buts_marques_EH;}
		public function buts_marques_EV() { return $this->_buts_marques_EV;}
		public function equipe_hote() { return $this->_equipe_hote;}
		public function equipe_visiteuse() { return $this->_equipe_visiteuse;}
		public function embleme_equipe_visiteuse() { return $this->_embleme_equipe_visiteuse;}
		public function embleme_equipe_hote() { return $this->_embleme_equipe_hote;}
		public function commentaire() { return $this->_commentaire;}
		public function date_match() { return $this->_date_match;}
		public function lieu() { return $this->_lieu;}
		public function statut() { return $this->_statut;}

		// SETTERS //
        public function setId_matchs($id_matchs) { $this->_id_matchs = $id_matchs; }
		public function setNom_match($nom_match) { $this->_nom_match = $nom_match; }
        public function setButs_marques_EH($buts_marques_EH) { $this->_buts_marques_EH= $buts_marques_EH; }
		public function setButs_marques_EV($buts_marques_EV) { $this->_buts_marques_EV = $buts_marques_EV; }
		public function setEquipe_hote($equipe_hote) { $this->_equipe_hote = $equipe_hote; }
		public function setEquipe_visiteuse($equipe_visiteuse) { $this->_equipe_visiteuse = $equipe_visiteuse; }
		public function setEmbleme_equipe_hote($embleme_equipe_hote) { $this->_embleme_equipe_hote = $embleme_equipe_hote; }
		public function setEmbleme_equipe_visiteuse($embleme_equipe_visiteuse) { $this->_embleme_equipe_visiteuse = $embleme_equipe_visiteuse; }
		public function setCommentaire($commentaire) { $this->_commentaire = $commentaire; }
		public function setDate_match($date_match) { $this->_date_match = $date_match; }
		public function setLieu($lieu) { $this->_lieu = $lieu; }
		public function setStatut($statut) { $this->_statut = $statut; }
   
}


?>