<?php
include "Entities/matchs.php";
include "Models/matchsManager.php";
include "Models/commentairesManager.php";
/**
* Définition d'une classe permettant de gérer les matchs
*   en relation avec la base de données	
*/
class MatchsController {
	private $matchsManager; // instance du manager
	private $commentairesManager;
    private $twig; 

	/**
	* Constructeur = initialisation de la connexion vers le SGBD et du moteur de template
	*/
	public function __construct($db,$twig) {
		$this->matchsManager = new MatchsManager($db);
		$this->commentairesManager = new CommentairesManager($db);
        $this->twig = $twig;
	}
        
	/**
	* liste de tous les matchs
	* @param aucun
	* @return rien
	*/
	public function listeMatchs() {
		// récupérer la liste des matchs
		$matchs = $this->matchsManager->getList();
		$commentaires = $this->commentairesManager->getList();

		// affichage en utilisant la vue
		echo $this->twig->render('listematchs.html.twig', array('matchs' => $matchs,'commentaires'=>$commentaires,'acces' =>$_SESSION['acces']));
	}
	//public function listeMatch() {
		// récupérer la liste des matchs
		//$matchs = $this->matchsManager->getList();
		// affichage en utilisant la vue
		//echo $this->twig->render('listematch.html.twig', array('matchs' => $matchs));
//	}
	
	public function afficherMatchs() {
    $matchs = $this->matchsManager->getMatchsAvecEquipes();

    // Envoie les matchs à Twig
  		echo $this->twig->render('listematch.html.twig', array('matchs' => $matchs,'acces' =>$_SESSION['acces']));
}

	/**
	* formulaire ajout
	* @param aucun
	* @return rien
	*/
	public function formAjoutMatchs() {
	$equipes = $this->matchsManager->getListA();
 	echo $this->twig->render('ajoutmatch.html.twig',array("equipes" => $equipes,'acces' =>$_SESSION['acces']));
	}

	/**
	* ajout dans la BD d'un match à partir du form
	* @param aucun
	* @return rien
	*/
	public function ajoutMatchs() {
		// création d'un nouveau match
		$matchs = new matchs ($_POST);
		// ajout du match dans la base de données
		$ok = $this->matchsManager->add($matchs);
		// le message d'état 
		if ($ok) { $message = "match ajouté"; }
		else { $message = "pb lors de l'ajout"; }
		// affichage du message
		echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'],'message' => $message));
	}
	
	/**
	* ajout dans la BD d'un commentaire à partir du form
	* @param aucun
	* @return rien
	*/
	public function ajoutCom() {
		// création d'un nouveau commentaire
		$commentaires = new Commentaires(array('id_match' => $_POST["id_matchs"],'idmembre' => $_SESSION['id'],'contenu' => $_POST["commentaires"][0],'idcommentaire' => 0));
		// ajout du match dans la base de données
		$ok = $this->commentairesManager->add($commentaires);
		// le message d'état 
		if ($ok) { $message = "Commentaire ajouté"; }
		else { $message = "	Echec! Problème lors de l'ajout"; }
		// affichage du message
		echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'],'message' => $message));
	}
	
	/**
	* form de choix du matchs à supprimer
	* @param aucun
	* @return rien
	*/
	public function choixSuppMatchs() {
		$matchs = $this->matchsManager->getList();
		echo $this->twig->render('choixsuppmatch.html.twig', array("matchs" => $matchs,'acces' =>$_SESSION['acces']));
	}
	
	/**
	* suppression dans la BD d'une equipe à partir de l'id choisi dans le form précédent
	* @param aucun
	* @return rien
	*/
	public function suppMatchs() {
		// suppression d'un nouvel itinéraire
		$matchs = new matchs($_POST);
		// stockage dans la BD
		$ok = $this->matchsManager->delete($matchs);
		if ($ok) { $message = "Match supprimé "; }
		else { $message = "Oupps! Echec"; }
		// affichage du message
		echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'],'message' => $message));
	}
	
	/**
	* form de choix de l'iti à modifier
	* @param aucun
	* @return rien
	*/
	public function choixModMatchs() {
		$matchs = $this->matchsManager->getList();
		echo $this->twig->render('choixmodmatchs.html.twig', array("matchs" => $matchs,'acces' =>$_SESSION['acces']));
	}
	
	/**
	* form de saisi des nouvelles valeurs de l'equipe à modifier
	* @param aucun
	* @return rien
	*/
	public function saisieModMatchs() {
		$matchs =  $this->matchsManager->get($_POST["id_matchs"]);
		echo $this->twig->render('saisiemodmatch.html.twig', array("matchs" => $matchs,'acces' =>$_SESSION['acces']));
	}
	
	/**
	* modification dans la BD d'un match à partir des données du form précédent
	* @param aucun
	* @return rien
	*/
	public function modMatchs() {
		$matchs =  new matchs($_POST);
		$ok = $this->matchsManager->update($matchs);
		if ($ok) { $message = "matchs modifié avec succès"; }
		else { $message = "probleme lors de la modification"; }
		// affichage du message
		echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'],'message' => $message));
	}
	
	public function formRechercheMatchs() {
        echo $this->twig->render('recherchematch.html.twig',array('acces' =>$_SESSION['acces'])); // viewer
	}

	/**
	* recherche dans la BD de produits à partir des données du form précédent
	* @param aucun
	* @return rien
	*/
	public function rechercheMatchs() {
	// récupérer la liste des equipes
	$butsMin = $_POST['buts_min'] ?? null;
    $periodeDebut = $_POST['periode_debut'] ?? null;
    $periodeFin = $_POST['periode_fin'] ?? null;
	var_dump($butsMin,$periodeDebut,$periodeFin);

		$resultats = $this->matchsManager->search($butsMin, $periodeDebut, $periodeFin);
		// affichage en utilisant la vue
		echo $this->twig->render('resultatsmatch.html.twig', array('resultats' => $resultats,'acces' =>$_SESSION['acces']));
		}
	
//STATISTIQUE DES MATCHS
	
    public function index() {
		
        $matchsAVenir = $this->matchsManager->getMatchsAVenir();
		
        $statistiques = $this->matchsManager->getStatistiques();

        echo $this->twig->render('stat.html.twig', array(
            'matchs' => $matchsAVenir,
            'stats' => $statistiques,'acces' =>$_SESSION['acces']));
    }
}