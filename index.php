<?php
// Inclusion des classes nécessaires
require_once('Model/Connection.php');
require_once('Model/userManager.php');
require_once('Model/User.php');

// Créer une nouvelle instance de la classe Connection
$connection = new Connection();
$db = $connection->getDb();

// Vérifier si la connexion à la base de données a réussi
if ($db) {
    echo "Connexion réussie à la base de données.";
} else {
    echo "Erreur de connexion à la base de données.";
    exit;  // Arrêter l'exécution si la connexion échoue
}

// Créer une nouvelle instance de UserManager
$userManager = new UserManager($db);

// Initialiser une variable pour les erreurs
$errors = [];

// Traiter le formulaire de création
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $address = $_POST['address'] ?? '';
    $postalCode = $_POST['postalCode'] ?? '';
    $city = $_POST['city'] ?? '';
    
    // Validation des données (exemples basiques)
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $errors[] = 'Tous les champs obligatoires doivent être remplis.';
    }

    // Vérification de l'unicité de l'email
    $existingUser = $userManager->findByEmail($email);
    if ($existingUser) {
        $errors[] = 'L\'email existe déjà.';
    }

    // Si aucune erreur, on procède à la création du nouvel utilisateur
    if (empty($errors)) {
        // Hydrater un nouvel utilisateur
        $newUser = new User();
        $newUser->setFirstName($firstName);
        $newUser->setLastName($lastName);
        $newUser->setEmail($email);
        $newUser->setPassword($password); // Vous pouvez hasher le mot de passe ici si nécessaire
        $newUser->setAddress($address);
        $newUser->setPostalCode($postalCode);
        $newUser->setCity($city);

        // Insérer le nouvel utilisateur dans la base de données
        $userManager->create($newUser);
        echo "L'utilisateur a été créé avec succès !";
    } else {
        // Afficher les erreurs si présentes
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}

// Inclure le formulaire de création d'utilisateur
?>
<form method="POST" action="">
    <label for="firstName">Prénom:</label>
    <input type="text" name="firstName" id="firstName" required>
    
    <label for="lastName">Nom:</label>
    <input type="text" name="lastName" id="lastName" required>
    
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" id="password" required>
    
    <label for="address">Adresse:</label>
    <input type="text" name="address" id="address">
    
    <label for="postalCode">Code postal:</label>
    <input type="text" name="postalCode" id="postalCode">
    
    <label for="city">Ville:</label>
    <input type="text" name="city" id="city">
    
    <button type="submit">Créer l'utilisateur</button>
</form>
