# BlogSymfony

Application de blog développée avec **Symfony 8** permettant aux utilisateurs de publier des posts, ajouter des images, commenter et gérer leur profil.

---

## Aperçu

BlogSymfony est un projet réalisé pour pratiquer :

- l’architecture MVC avec Symfony
- la gestion des utilisateurs et de l’authentification
- les relations entre entités avec Doctrine
- les formulaires Symfony
- l’upload de fichiers
- une interface moderne avec Twig et CSS personnalisé

---

## Stack technique

- **PHP** 8.4
- **Symfony** 8
- **Doctrine ORM**
- **Twig**
- **MySQL**
- **CSS custom**

---

## Fonctionnalités principales

### Utilisateur
- Inscription et connexion
- Accès au profil personnel
- Création de posts avec image
- Ajout de commentaires

### Blog
- Liste des posts sur la page d’accueil
- Filtrage par catégorie
- Affichage des auteurs et dates
- Page détail d’un post

### Administration
- Accès admin selon le rôle
- Gestion des contenus

---

## Installation

### 1. Cloner le projet
```bash
git clone <url-du-repo>
cd BlogSymfony



composer install

DATABASE_URL="mysql://user:password@127.0.0.1:3306/blogsymfony"

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

symfony server:start




BlogSymfony/
│
├── config/                 # Configuration Symfony
│   ├── packages/
│   ├── routes/
│   └── services.yaml
│
├── migrations/             # Migrations Doctrine
│
├── public/                 # Dossier public accessible
│   ├── uploads/
│   │   └── posts/          # Images des posts
│   └── index.php
│
├── src/
│   ├── Controller/         # Contrôleurs (logique des routes)
│   │   ├── HomeController.php
│   │   ├── PostController.php
│   │   ├── ProfileController.php
│   │   └── SecurityController.php
│   │
│   ├── Entity/             # Entités Doctrine
│   │   ├── User.php
│   │   ├── Post.php
│   │   ├── Comment.php
│   │   └── Category.php
│   │
│   ├── Repository/         # Requêtes personnalisées
│   │
│   ├── Form/               # Formulaires Symfony
│   │   └── PostType.php
│   │
│   └── Security/           # Authentification
│       └── AppAuthenticator.php
│
├── templates/              # Vues Twig
│   ├── base.html.twig
│   ├── home/
│   ├── post/
│   ├── profile/
│   └── security/
│
├── var/                    # Cache et logs
├── vendor/                 # Dépendances Composer
│
├── .env
├── composer.json
└── README.md