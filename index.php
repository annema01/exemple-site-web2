<?php

// ************************************************
// Démarrage de la session. Ainsi, on peut
// utiliser les variables de session partout dans
// l'application.
// ************************************************

session_start();

// ************************************************
// Importation des fichiers nécessaires
// ************************************************

require 'utils/utils.php';
require 'utils/televersementUtils.php';
require 'utils/telechargementUtils.php';
require 'controleur/controleur.php';
require 'controleur/controleurTest.php';
require 'controleur/controleurLivre.php';
require 'controleur/controleurPage.php';
require 'controleur/controleurUtilisateur.php';

// ************************************************
// Vous n'avez rien à modifier dans le try catch
// ************************************************

try {
	// .htaccess envoie toutes les requêtes à index.php sauf pour ce qui est dans le dossier public (js, css, image, etc.).
	// Si la requête n'a pas été faite à index.php, on redirige vers index.php.
	if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) !== 0) {
		$redirigerVers = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
		header('Location: ' . $redirigerVers);
		return;
	}

	switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET':
			gererRequetesGet();
			break;
		case 'POST':
			if (!isset($_GET['methode'])) {
				throw new Exception('404 : Veuillez spécifier la méthode');
			}
			switch (strtoupper($_GET['methode'])) {
				case "POST":
					gererRequetesPost();
					break;
				case "PUT":
					gererRequetesPut();
					break;
				case "DELETE":
					gererRequetesDelete();
					break;
				default:
					throw new Exception('404 : Méthode non supportée');
			}
			break;
		default:
			throw new Exception('404 : Méthode non supportée');
	}
} catch (PDOException $ex) {
	$msgErreur = $ex->getMessage();
	require 'vue/erreur.php';
} catch (Exception $ex) {
	$msgErreur = $ex->getMessage();
	require 'vue/erreur.php';
}

// ************************************************
// Ajoutez vos routes dans les functions suivantes :
// ************************************************

function gererRequetesGet()
{
	if (!isset($_GET['ressource'])) {
		return afficherPageDefaut();
	}

	switch ($_GET['ressource']) {
		case '/':
			afficherAccueil();
			break;
		case '/livres':
			afficherLivres();
			break;
		case '/livres/{id}':
			afficherLivreParId();
			break;
		case '/livres/{id}/couverture':
			telechargerCouvertureLivreParId();
			break;
		case '/pages/{id}':
			telechargerPagesParId();
			break;
		case '/utilisateurs/moi/livres':
			afficherLivresUtilisateurConnecte();
			break;
		case '/publier-livre':
			afficherPublierLivre();
			break;
		case '/connexion':
			afficherConnexion();
			break;
		case '/inscription':
			afficherInscription();
			break;
		case '/deconnexion':
			deconnecterUtilisateur();
			break;
		case '/test':
			afficherFormulaireTest();
			break;
		default:
			throw new Exception('404 : La page que vous recherchez n\'existe pas');
	}
}

function gererRequetesPost()
{
	switch ($_GET['ressource']) {
		case '/inscription':
			inscrireUtilisateur();
			break;
		case '/connexion':
			connecterUtilisateur();
			break;
		case '/livres':
			ajouterLivre();
			break;
		case '/test':
		ajouterTest();
			break;
		default:
			throw new Exception('404 : Impossible d\'ajouter ce type de ressource');
	}
}

function gererRequetesPut()
{
	switch ($_GET['ressource']) {
		default:
			throw new Exception('404 : Impossible de modifier ce type de ressource');
	}
}

function gererRequetesDelete()
{
	switch ($_GET['ressource']) {
		default:
			throw new Exception('404 : Impossible de supprimer ce type de ressource');
	}
}
