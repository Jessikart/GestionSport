<?php
	
/**
* Définition d'une classe permettant de gérer les produits 
*   en relation avec la base de données	
*/
	class CommentairesManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/**
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }

        /**
		* ajout d'un commentaire dans la BD
		* @param commentaire à ajouter
		* @return int true si l'ajout a bien eu lieu, false sinon
		*/
        public function add(commentaires $commentaires) {
            // calcul d'un nouveau code commentaire non déja utilisé = Maximum + 1
			$stmt = $this->_db->prepare("SELECT MAX(idcommentaire) AS MAXIMUM FROM commentaires");
			$stmt->execute();
            $commentaires->setIdcommentaire($stmt->fetchColumn()+1);
			
            // requete d'ajout dans la BD
			$req = "INSERT INTO commentaires (idcommentaire,idmembre,contenu,id_match) VALUES (?,?,?,?)";
			$stmt = $this->_db->prepare($req);
			$res  = $stmt->execute(array($commentaires->idcommentaire(),$commentaires->idmembre(),$commentaires->contenu(),$commentaires->id_match()));	
			
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
            return $res;
        }
	
	
	
        /**
		* nombre de matchs dans la base de données
		* @return int le nb de matchs
		*/
        public function count() {
            $stmt = $this->_db->prepare('SELECT COUNT(*) FROM commentaires');
			$stmt->execute();
			return $stmt->fetchColumn();
        }
        /**
		* suppression d'un commentaire dans la base de données
		* @param commentaire 
		* @return boolean true si suppression, false sinon
		*/
        public function delete(commentaires $commentaires) : bool {
            $req = "DELETE FROM commentaire WHERE idcommentaire = ?";
			$stmt = $this->_db->prepare($req);
            return $stmt->execute(array($commentaires->idcommentaire()));
        }
        /**
		* recherche dans la BD d'un match à partir de son code
		* @param int $id_equipe
		* @return equipes 
		*/
		public function get($idcommentaire) : Commentaires {
            $req = 'SELECT idcommentaire, idmembre, id_match, contenu FROM commentaires WHERE idcommentaire=?';
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array($idcommentaire));
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			$commentaires = new commentaires($stmt->fetch());
            return $commentaires;
        }
        /**
		* retourne l'ensemble des matchs présents dans la BD 
		* @return matchs[]
		*/		
        public function getList() {
            $matchs = array();
			$req = "SELECT idcommentaire, idmembre, id_match, contenu FROM commentaires";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			// récup des données
            while ($donnees = $stmt->fetch())
            {
                $commentaires[] = new Commentaires($donnees);
            }
            return $commentaires;
        }
	

      
	}


?>