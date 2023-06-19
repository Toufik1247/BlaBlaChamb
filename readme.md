# BlaBlaChamb

BlaBlaChamb est une application de covoiturage conçue pour mettre en relation des conducteurs avec des places vides dans leur voiture avec des passagers recherchant un trajet. C'est une application basée sur le framework Symfony et utilise Composer et NPM pour la gestion des dépendances.

## Live Version

[BlaBlaChamb](https://blablachamb.2screens.dev/)

## Fonctionnalités

- Recherche de trajets
- Publication de trajets
- Système d'évaluation des utilisateurs (à venir)
- Système de messagerie pour la communication entre les utilisateurs (à venir)
- Système pour filtrer les trajets (à venir)

## Prérequis

- PHP 7.4 ou supérieur
- Composer
- Node.js et NPM
- Base de données MySQL

## Installation

1. Cloner le dépôt:

```
https://github.com/Toufik1247/BlaBlaChamb
```

2. Installer les dépendances avec Composer:

```
cd BlaBlaChamb
composer install
```


3. Installer les dépendances avec NPM:

```
npm install
```


4. Mettre à jour le fichier `.env` avec vos informations de connexion à la base de données et créer la base de données.

```
php bin/console doctrine:database:create
```

5. Exécutez les migrations pour créer les tables dans la base de données:

```
php bin/console doctrine:migrations:migrate
```

6. Exécutez les fixtures (données fictives):

```
php bin/console d:f:l
```


7. Lancer le serveur Symfony:

```
symfony serve
```

7. Lancer le serveur Symfony:

```
symfony serve
```

8. Exécuter le script NPM "watch" pour surveiller les modifications de vos fichiers et recompiler automatiquement le code si nécessaire :

```
npm run watch
```

9. Compte par défaut

- admin@admin.com
- admin
