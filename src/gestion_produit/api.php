<?php

use Rayan\Tp2Test\gestion_produit\UserManager;

require_once 'UserManager.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$userManager = new UserManager();

try {
    if ($method === 'POST' && isset($_POST['name'], $_POST['email'])) {
        $userManager->addUser($_POST['name'], $_POST['email']);
        echo json_encode(["message" => "Utilisateur ajouté avec succès"]);
    } elseif ($method === 'GET') {
        echo json_encode($userManager->getUsers());
    } elseif ($method === 'DELETE' && isset($_GET['id'])) {
        $userManager->removeUser($_GET['id']);
        echo json_encode(["message" => "Utilisateur supprimé"]);
    } elseif ($method === 'PUT') {
        parse_str(file_get_contents("php://input"), $_PUT);
        if (isset($_PUT['id'], $_PUT['name'], $_PUT['email'])) {
            $userManager->updateUser($_PUT['id'], $_PUT['name'], $_PUT['email']);
            echo json_encode(["message" => "Utilisateur mis à jour"]);
        }
    } else {
        throw new Exception("Requête invalide.");
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
