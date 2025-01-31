<?php
	
/**
* Définition d'une classe permettant de gérer les produits 
*   en relation avec la base de données	
*/
class MatchsManager
    {
        private $_db; // Instance de PDO - objet de connexion au SGBD
        
		/**
		* Constructeur = initialisation de la connexion vers le SGBD
		*/
        public function __construct($db) {
            $this->_db=$db;
        }

        /**
		* ajout d'un matchs dans la BD
		* @param matchs à ajouter
		* @return int true si l'ajout a bien eu lieu, false sinon
		*/
        public function add(matchs $matchs) {
            // calcul d'un nouveau code matchs non déja utilisé = Maximum + 1
			$stmt = $this->_db->prepare("SELECT MAX(id_matchs) AS MAXIMUM FROM matchs");
			$stmt->execute();
            $matchs->setId_matchs($stmt->fetchColumn()+1);
			
            // requete d'ajout dans la BD
			$req = "INSERT INTO matchs (id_matchs,nom_match,buts_marques_EH,buts_marques_EV,date_match,lieu,statut,equipe_hote,equipe_visiteuse,commentaire) VALUES (?,?,?,?,?,?,?,?,?,?)";
			$stmt = $this->_db->prepare($req);
			$res  = $stmt->execute(array($matchs->id_matchs(),$matchs->nom_match(),$matchs->buts_marques_EH(),$matchs->buts_marques_EV(),$matchs->date_match(),$matchs->lieu(),$matchs->statut(),$matchs->equipe_hote(),$matchs->equipe_visiteuse(),$matchs->commentaire()));	
			
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
            return $res;
        }
	
	
	public function getListA() {
			$equipes = array();
            $matchs = array();
			$req = "SELECT id_equipe, nom FROM equipes WHERE id_equipe NOT IN (SELECT equipe_hote FROM matchs UNION SELECT equipe_visiteuse FROM matchs)";
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
				/*var_dump($donnees);*/
				$equipes[] = new equipes($donnees);
            }
			return $equipes;
        }
	
	
        /**
		* nombre de matchs dans la base de données
		* @return int le nb de matchs
		*/
        public function count() {
            $stmt = $this->_db->prepare('SELECT COUNT(*) FROM matchs');
			$stmt->execute();
			return $stmt->fetchColumn();
        }
        /**
		* suppression d'un match dans la base de données
		* @param matchs 
		* @return boolean true si suppression, false sinon
		*/
        public function delete(matchs $matchs) : bool {
            $req = "DELETE FROM matchs WHERE id_matchs = ?";
			$stmt = $this->_db->prepare($req);
            return $stmt->execute(array($matchs->id_matchs()));
        }
        /**
		* recherche dans la BD d'un match à partir de son code
		* @param int $id_equipe
		* @return equipes 
		*/
		public function get($id_matchs) : Matchs {
            $req = 'SELECT id_matchs, nom_match, equipe_hote, equipe_visiteuse, buts_marques_EH, buts_marques_EV, lieu FROM matchs WHERE id_matchs=?';
			$stmt = $this->_db->prepare($req);
			$stmt->execute(array($id_matchs));
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			$matchs = new matchs($stmt->fetch());
            return $matchs;
        }
        /**
		* retourne l'ensemble des matchs présents dans la BD 
		* @return matchs[]
		*/		
        public function getList() {
            $matchs = array();
			$req = "SELECT id_matchs, nom_match, equipe_hote, equipe_visiteuse, buts_marques_EH, buts_marques_EV FROM matchs";
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
                $matchs[] = new matchs($donnees);
            }
            return $matchs;
        }
	
	
		public function getMatchsAvecEquipes() {
			 $matchs = array();
   			 $req = "
        SELECT 
            m.id_matchs, 
            m.nom_match, 
            m.buts_marques_EH, 
            m.buts_marques_EV, 
            eh.nom AS equipe_hote,
            ev.nom AS equipe_visiteuse,
			eh.embleme AS embleme_equipe_hote,
            ev.embleme AS embleme_equipe_visiteuse
        FROM matchs m
        JOIN equipes eh ON m.equipe_hote = eh.id_equipe
        JOIN equipes ev ON m.equipe_visiteuse = ev.id_equipe
		
    ";		
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
                $matchs[] = new matchs($donnees);
            }
            return $matchs;
        }

        /**
		* méthode de recherche de match dans la BD à partir des critères passés en paramètre
		* @param string $nom_match
		* @param string $periodeDebut
		* @param string $periodeFin
		* @return matchs[]
		*/
		
		public function search($butsMin, $periodeDebut, $periodeFin):array {
			$req = "SELECT id_matchs,buts_marques_EH,buts_marques_EV,equipe_hote,equipe_visiteuse,nom_match,commentaire,date_format(date_match,'%d/%c/%Y') as date_match,lieu,statut FROM matchs";
			
			$cond = '';
			
			if ($butsMin<>"") {
				if ($cond<>"") { 
					$cond .= " AND ";
				}
				$cond = $cond . " buts_marques_EH + buts_marques_EV >=" . $butsMin;
			}
			if ($periodeDebut<>"") {
				if ($cond<>"") {
					$cond .= " AND ";
				}
			 	$cond = $cond . " date_match >='" . $periodeDebut ."'";
			}
			if ($periodeFin<>"") {
				if ($cond<>"") {
					$cond .= " AND ";
				}
				$cond = $cond . " date_match <='" . $periodeFin."'";
			}
			if ($cond <>"")
			{ 	$req .= " WHERE " . $cond;
			}

            // execution de la requete				
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}
			$matchs = array();
			while ($donnees = $stmt->fetch())
            {
                $matchs[] = new matchs($donnees);
            }
            return $matchs;
		}
		
        /**
		* modification d'un matchs dans la BD
		* @param equipes
		* @return boolean 
		*/
        public function update(matchs $matchs) : bool
        {
            $req = "UPDATE matchs SET nom_match = :nom_match, "
					. "buts_marques_EH = :buts_marques_EH, "
					. "buts_marques_EV = :buts_marques_EV, "
					. "equipe_visiteuse  = :equipe_visiteuse, "
					. "equipe_hote  = :equipe_hote, "
					. "commentaire  = :commentaire, "
					. "date_match  = :date_match, "
					. "lieu  = :lieu, "
					. "statut  = :statut "
					. " WHERE id_matchs = :id_matchs";
		var_dump($matchs);

		$stmt = $this->_db->prepare($req);
		$stmt->execute(array(":nom_match" => $matchs->nom_match(),
							 	":buts_marques_EH" => $matchs->buts_marques_EH(),
							 	":buts_marques_EV" => $matchs->buts_marques_EV(),
								":equipe_visiteuse" => $matchs->equipe_visiteuse(),
								":equipe_hote" => $matchs->equipe_hote(),
								":commentaire" => $matchs->commentaire(),
								":date_match" => $matchs->date_match(),
								":lieu" => $matchs->lieu(),
							 	":statut" => $matchs->statut(),
							 	":id_matchs" => $matchs->id_matchs()));
		// pour debuguer les requêtes SQL
			$errorInfo = $stmt->errorInfo();
			if ($errorInfo[0] != 0) {
				print_r($errorInfo);
			}					 
		return $stmt->rowCount() > 0;
		
	}


// Gestion de la page d'accueil
// STATISTIQUES
		public function getMatchsAVenir() {
			$matchs = array();
			$req = "SELECT * FROM matchs WHERE date_match >= CURDATE() ORDER BY date_match ASC";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
			// recup des données
		while ($donnees = $stmt->fetch())
		{
			$matchs[] = new matchs($donnees);
		}
		return $matchs;
		}

		public function getStatistiques() {
			$matchs = array();
			$req = "SELECT equipe_hote, equipe_visiteuse, buts_marques_EH, buts_marques_EV FROM matchs";
			$stmt = $this->_db->prepare($req);
			$stmt->execute();
			// pour debuguer les requêtes SQL
		$errorInfo = $stmt->errorInfo();
		if ($errorInfo[0] != 0) {
			print_r($errorInfo);
		}
			// recup des données
		while ($donnees = $stmt->fetch())
		{
			$matchs[] = new matchs($donnees);
		}
		return $matchs;
		}

}

?>