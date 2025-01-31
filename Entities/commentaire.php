<?php
/** 
* définition de la classe Membre
*/
class Commentaires {
        private int $id_match;
		private int $idmembre;
		private string $contenu;
		private string $idcommentaire;
		
        // contructeur
        public function __construct(array $donnees) {
		// initialisation d'un produit à partir d'un tableau de données
			if (isset($donnees['id_match'])) { $this->_id_match = $donnees['id_match']; }
			if (isset($donnees['idmembre'])) { $this->_idmembre = $donnees['idmembre']; }
			if (isset($donnees['contenu'])) { $this->_contenu = $donnees['contenu']; }
			if (isset($donnees['idcommentaire'])) { $this->_idcommentaire = $donnees['idcommentaire']; }
			
        }           
        // GETTERS //
		public function id_match() { return $this->_id_match;}
		public function idmembre() { return $this->_idmembre;}
		public function contenu() { return $this->_contenu;}
		public function idcommentaire() { return $this->_idcommentaire;}
		
		// SETTERS //
		public function setidMatch( $id_match) { $this->_id_match = $id_match; }
        public function setIdMembre( $idmembre) { $this->_idmembre= $idmembre; }
		public function setContenu( $contenu) { $this->_contenu = $contenu; }
		public function setIdcommentaire($idcommentaire) { $this->_idcommentaire = $idcommentaire; }

    }

?>