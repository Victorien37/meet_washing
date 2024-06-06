# Documentation du projet Symfony

## Prérequis

- PHP 7.4 ou supérieur
- Composer
- Symfony CLI
- Une base de données MySQL

## Installation

Dans une console de commandes, dans le projet :
`composer install`

Modifier dans le fichier .env la ligne suivante en fonction de la configuration de votre base de données:
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/meet_washing"
```

Créer la base de données
`php bin/console doctrine:database:create`

Exécuter les migrations pour créer les tables :
`php bin/console doctrine:migrations:migrate`

Charger les fixtures pour remplir la base de données
`php bin/console doctrine:fixtures:load`

Lancement du serveur
`symfony server:start`

La documentation de l'api est dans le fichier api.md qui est à la racine du projet