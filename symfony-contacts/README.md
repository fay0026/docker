# Symfony contacts
## FAY Damien
## Installation / Configuration
Penser à supprimer le projet local après avoir push le travail sur gitlab, pour éviter d'encombrer
les serveurs de l'IUT.

Pour lancer le projet depuis une autre / nouvelle machine, penser à lancer composer install pour
mettre à jour le projet.

Pour supprimer le projet local et récupérer le projet gitlab :

cd /working/votre_login

git -RF /working/votre_login/symfony-contacts

git clone https://iut-info/univ-reims.fr/gitlab/votre_login/symfony-contacts.git

Penser à configurer un .env.local avec DATABASE_URL="mysql://login:password@mysql/login_contact?serverVersion=10.2.5-MariaDB&charset=utf8mb4"

cd /working/votre_login/symfony-contacts

composer install
composer update

Tables sur phpMyAdmin

Commandes composer disponibles :

"start": "Starts the symfony server",

"test:cs": "Launches php-cs-fixer to analyse the code",

"fix:cs": "Launches php-cs-fixer to fix the code"

"test:codecept": "Launches all codeception tests"

"test": "Launches fix:cs and test:codecept"

"db": "Destroys a possible precedent database, and replaces it with a new one, and initialises it with fixtures"

"test:codeception": "Nettoie l'output de codeception, détruit et recréé une BdD et son schéma, et exécute les tests Codeception"

Dev commands :

bin/console make:factory to create a new factory / nouvelle forge

bin/console make:migration to create a new migration

bin/console make:controller ControllerName to create a new controller

bin/console make:form ContactType Contact to create a new form

path('smth'), pour accéder à un chemin d'un contrôleur

asset('smth'), pour accéder à une page
