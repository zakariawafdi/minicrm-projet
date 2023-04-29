# My Laravel Project

C'est ma réalisation du projet "mini-crm" une application application web de type SPA développé à l'aide du framework laravel et Vuejs 3 

## Installation 

Pour installer ce projet, vous devez avoir PHP et Composer ainsi que NodeJS et son gestionnaire de paquets NPM installés sur votre système. Une fois ces prérequis installés, vous pouvez suivre les étapes suivantes :


1. Clonez le repository sur votre machine locale.
2. Exécutez `composer install` puis `npm install`  pour installer les dépendances du projet.
3. Copiez le fichier `.env.example` dans `.env` et mettez à jour les paramètres de configuration de la base de données et de smtp.
4. Lancez `php artisan jwt:secret` pour générer une clé JWT secrète.
5. Exécutez `php artisan key:generate`
6. Lancez `php artisan migrate` pour créer les tables de la base de données.
7. exécutez `php artisan db:seed` pour créer le compte administrateur par défaut (admin@exemple.com:password).






## Démarrer

Pour démarrer ce projet, vous pouvez exécuter les instructions suivantes :

1. Lancer `php artisan serve` pour lancer l'application laravel sur l'adresse par défaut (localhost:8000)
2. Ouvrez une nouvelle console cmd et exécutez npm run watch pour construire l'application vue.

Utilisez le chemin localhost:8000/admin pour accéder à l'espace d'admin Et localhost:8000/employee pour accéder à l'espace employé.
