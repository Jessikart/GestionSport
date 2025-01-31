<?php
include "Entities/equipes.php";
include "Models/equipesManager.php";
/**
* Définition d'une classe permettant de gérer les produits 
*   en relation avec la base de données	
*/
class EquipesController {
	private $equipesManager; // instance du manager
    private $twig; 

	/**
	* Constructeur = initialisation de la connexion vers le SGBD et du moteur de template
	*/
	public function __construct($db,$twig) {
		$this->equipesManager = new EquipesManager($db);
        $this->twig = $twig;
	}
        
	/**
	* liste de tous les equipes
	* @param aucun
	* @return rien
	*/
	public function listeEquipes() {
		// récupérer la liste des equipes
		$equipes = $this->equipesManager->getList();
		// affichage en utilisant la vue
		echo $this->twig->render('listeequipes.html.twig', array('equipes' => $equipes,'acces' =>$_SESSION['acces']));
	}
	public function listeEquipe() {
		// récupérer la liste des equipes
		$equipes = $this->equipesManager->getList();
		// affichage en utilisant la vue
		echo $this->twig->render('listeequipe.html.twig', array('equipes' => $equipes,'acces' =>$_SESSION['acces']));
	}

	/**
	* formulaire ajout
	* @param aucun
	* @return rien
	*/
	public function formAjoutEquipes() {
 	echo $this->twig->render('ajoutequipe.html.twig',array('acces' =>$_SESSION['acces']));
	}

	/**
	* ajout dans la BD d'une equipe à partir du form
	* @param aucun
	* @return rien
	*/
	public function ajoutEquipes() {
		// création d'une nouvelle equipes
		$equipes = new equipes ($_POST);
		// ajout de l'équipe dans la base de données
		$ok = $this->equipesManager->add($equipes);
		// le message d'état 
		if ($ok) { $message = "equipe ajouté"; }
		else { $message = "pb lors de l'ajout"; }
		// affichage du message
		echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'],'message' => $message));
	}
	
	/**
	* form de choix de l'equipe à supprimer
	* @param aucun
	* @return rien
	*/
	public function choixSuppEquipe() {
		$equipes = $this->equipesManager->getList();
		//$equipes = $this->equipesManager->getListMembre($_SESSION['idmembre']);
		echo $this->twig->render('choixsupp.html.twig', array("equipes" => $equipes,'acces' =>$_SESSION['acces']));
	}
	
	/**
	* suppression dans la BD d'une equipe à partir de l'id choisi dans le form précédent
	* @param aucun
	* @return rien
	*/
	public function suppEquipe() {
		// suppression d'une nouvelle equipe
		$equipes = new equipes($_POST);
		// stockage dans la BD
		$ok = $this->equipesManager->delete($equipes);
		if ($ok) { $message = "Equipe supprimé "; }
		else { $message = "Problème lors de la suppression"; }
		// affichage du message
		echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'],'message' => $message));
	}
	
	/**
	* form de choix de l'equipe à modifier
	* @param aucun
	* @return rien
	*/
	public function choixModEquipes() {
		$equipes = $this->equipesManager->getList();
		echo $this->twig->render('choixmodequipe.html.twig', array("equipes" => $equipes,'acces' =>$_SESSION['acces']));
	}
	
	/**
	* form de saisi des nouvelles valeurs de l'equipe à modifier
	* @param aucun
	* @return rien
	*/
	public function saisieModEquipe() {
		$equipes =  $this->equipesManager->get($_POST["id_equipe"]);
		echo $this->twig->render('saisiemodequipe.html.twig',array("equipes" => $equipes,'acces' =>$_SESSION['acces']));
	}
	
	/**
	* modification dans la BD d'un equipe à partir des données du form précédent
	* @param aucun
	* @return rien
	*/
	public function modEquipe() {
		$equipes =  new equipes($_POST);
		$ok = $this->equipesManager->update($equipes);
		if ($ok) { $message = "Equipe modifié avec succès"; }
		else { $message = "Oupps! Modification échouer"; }
		// affichage du message
		echo $this->twig->render('index.html.twig',array('acces' =>$_SESSION['acces'],'message' => $message));
	}
	
	/**
	* form de saisie des criteres de recherche
	* @param aucun
	* @return rien
	*/

	public function formRechercheEquipes() {
        echo $this->twig->render('rechercheequipe.html.twig',array('acces' =>$_SESSION['acces'])); // viewer
	}

	/**
	* recherche dans la BD d'equipe à partir des données du form précédent
	* @param aucun
	* @return rien
	*/
	
	public function rechercheEquipes() {
	// récupérer la liste des equipes
	 $nom = $_POST['nom'] ?? null;
   	 $victoiresMin = $_POST['victoires_min'] ?? null;
	
	$resultats = $this->equipesManager->search($nom, $victoiresMin);
	// affichage en utilisant la vue
	echo $this->twig->render('resultatsequipe.html.twig', ['resultats' => $resultats,'acces' =>$_SESSION['acces'] ]);
    }
	
}