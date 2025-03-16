- [Sessions PHP](#sessions-php)
- [Authentification](#authentification)

# Sessions PHP

La session PHP est une variable qui est **conservée entre les pages** et spécifique à **CHAQUE UTILISATEUR**.

Pour y accéder, on doit d'abord utiliser:

```php
session_start();
```

Puisque c'est souvent nécessaire, on l'ajoutera à notre fichier d'initialisation (ex: init.php).

On peut ensuite utiliser la variable `$_SESSION` comme un tableau associatif et son contenu sera sauvegarder automatiquement.

```php
$_SESSION["username"] = "Cassandra";
```

Il est souvent pratique de vérifier si l'information existe avant de l'utiliser.

```php
if (isset($_SESSION["username"])) {

}
```

# Authentification

Pour créer un système de connexion, on devra utiliser deux fonctions natives de PHP.

## password_hash
[password_hash](https://www.php.net/manual/en/function.password-hash.php) permet d'encrypter un mot de passe afin de pouvoir le sauvegarder dans la base de données en toute sécurité.

```php
// chat
$mdp_creation = $_POST["mdp"];

// $2y$10$pVT0QlKJIpsl7ttfD37cyuRz7pulMf99EHvL.JtJHAQPwTW4lWiJm
$mdp_encrypte = password_hash($mdp_creation, PASSWORD_DEFAULT);
```

<span style="color: red; font-weight: bold;">EN AUCUN CAS LES MOTS DE PASSES DOIVENT ÊTRE SAUVEGARDER EN CLAIR (sans encryption) DANS UNE BDD.</span>

## password_verify
[password_verify](https://www.php.net/manual/en/function.password-verify.php) permet de vérifier si un mot de passe entré par l'utilisateur corresponds bien avec celui encrypté dans la base de données

```php
$utilisateur = selectById("utilisateur", 1); // Une entrée d'utilisateur

$mdp_login = $_POST["mdp"]; // chat
$mdp_user = $utilisateur["mdp"]; // $2y$10....  (La colonne mdp)

if (password_verify($mdp_login, $mdp_user)) {
    // Valide
} else {
    // Non valide
}

