# Bibliothéque de citations

Application web développée avec **Symfony** permettant de gérer une collection de citations.

## Fonctionnalités

- Afficher la liste de toutes les citations
- Consulter le détail d'une citation
- Ajouter une nouvelle citation
- Modifier une citation existante
- Supprimer une citation (avec confirmation)
- Marquer une citation comme favorite
- Noter la popularité d'une citation de 0 à 5 étoiles

Chaque citation contient : le texte, l'auteur, la source (facultative), la catégorie, la langue, la popularité, le statut favori et la date d'ajout.

---

## Prérequis

Avant de commencer, il faut avoir installé sur sa machine :

| Outil | Version | Lien |
|-------|---------|------|
| PHP | 8.2 ou plus | https://www.php.net/downloads |
| Composer | 2.x | https://getcomposer.org/download/ |
| MySQL ou MariaDB | — | inclus dans WAMP, XAMPP, MAMP ou Laragon |
| Git | — | https://git-scm.com/downloads |
| Symfony CLI *(facultatif)* | — | https://symfony.com/download |

Pour vérifier que tout est bien installé, lancer dans un terminal :

```bash
php -v
composer -V
git --version
```

---

## Installation

### 1. Récupérer le projet

```bash
git clone https://github.com/Skyoroma/Biblioth-que-citations-exo-S37.git
cd Biblioth-que-citations-exo-S37
```

### 2. Installer les dépendances

```bash
composer install
```

Cette commande télécharge toutes les librairies du projet dans le dossier `vendor/`.

### 3. Configurer la base de données

Créer un fichier `.env.local` à la racine du projet (au même niveau que le fichier `.env`) et y ajouter la ligne de connexion à la base de données :

```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/citations?serverVersion=8.0.32&charset=utf8mb4"
```

À adapter selon sa configuration :

- `root` : le nom d'utilisateur MySQL
- après les `:` : le mot de passe (vide ici, ce qui est le cas par défaut avec WAMP et XAMPP ; avec MAMP, c'est souvent `root`)
- `3306` : le port MySQL
- `citations` : le nom de la base de données qui va être créée
- `serverVersion` : la version de MySQL. Pour MariaDB, utiliser par exemple `serverVersion=10.11.2-MariaDB`

> Le fichier `.env.local` n'est pas envoyé sur Git : chacun peut donc y mettre ses propres identifiants sans risque.

### 4. Créer la base de données et les tables

Démarrer MySQL puis lancer :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

La première commande crée la base de données, la seconde crée la table des citations. Répondre `yes` si une confirmation est demandée.

### 5. Lancer le serveur

Avec la Symfony CLI :

```bash
symfony serve
```

Ou, sans la Symfony CLI :

```bash
php -S localhost:8000 -t public
```

L'application est alors accessible à l'adresse : **http://localhost:8000/citation

---
