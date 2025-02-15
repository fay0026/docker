# s4-docker
## FAY Damien

# Lancement Docker :

Toujours faire avant chaque session :
docker login

Chez soi, pensez à installer le script shell 

# Commandes Docker :

Les commandes * sont universelles, et marchent avec Image, Network et Volume.
Leurs description est donc le texte placé avant l'étoile.

Remplacer "" par ce qu'il vous convient.

Le début des commandes ressemble à :
docker container run ubuntu
Mais certaines (celles qui sont uniques aux conteneurs) peuvent être raccourcies :
docker run ubuntu

Utiliser la touche |TAB| permet de compléter ou vérifier les commandes. Marche avec docker container.

### Lister *(ls) les conteneurs inactifs : 
docker container ls
docker ps
##### Pour les actifs :
docker container ls -a
docker ps -a
##### Pour les rendre actifs :
docker-compose up

### Démarrer une instance de conteneur via une image donnée :
docker run "image"
#### Sans la démarrer :
docker create "conteneur"
##### Pour ajouter un nom :
docker run --name="conteneur" "image"
##### Pour l'ouvrir avec un bash :
docker run -ti "image" "chemin (/bash/rc)"

### Arrêter un conteneur actif :
docker stop "conteneur"

### Démarrer un conteneur inactif :
docker start "conteneur"

### Attacher entrées et sorties locales à un conteneur actif :
docker attach "conteneur"

### Exécuter une commande dans un conteneur actif :
docker exec "conteneur" "commande"

### Supprimer *(rm) un conteneur :
docker container rm "conteneur"

### Supprimer tout *(prune) les conteneurs actifs :
docker prune

### Afficher les logs d'un conteneur actif :
docker logs "conteneur"
##### Pour qu'il persiste :
docker logs -f "conteneur"

### Afficher les statistiques d'un conteneur actif :
docker stats "conteneur"

### Afficher les informations détaillées *(inspect) d'un conteneur actif :
docker inspect "conteneur"

#### Après avoir créé des fichiers via un conteneur, il faut effectuer un rm dans le conteneur pour le supprimer. Supprimer le conteneur supprime ses fichiers, si aucun partage n'est appliqué.

## Partage local et conteneur
docker _ --volume "Répertoirelocal" _



## Commandes réseau

### Lister les réseaux :
docker network ls

### Créer un réseau :
docker network create "network"

### Inspecter un réseau :
docker network inspect "network"

### Pour créer un conteneur lié à un réseau (Mysql en example) :
docker --detach --env ("MYSQL_ROOT_PASSWORD=root", définis le mot de passe) --network "network" mariadb

### Pour utiliser adminer, pour une interface web :
docker --publish "7080:8080" adminer

## Docker compose

## Pour exécuter un fichier docker-compose.yaml dans le répertoire courant :
docker-compose up -d
#### Pour spécifier
docker-compose -f <nom-du-fichier.yaml> up

## Image personnalisée

### Pour créer une image d'un fichier dockerfile :
docker build --tag"login"/"répertoire" .
#### Pour la supprimer
docker image rm "image"
### Pour publier un conteneur
docker run --publish 8080:80
### Pour les lister
docker image ls

### Ajouter une image locale à un dépôt distant :
docker tag local-image:"image" new-repo:"image"
docker push new-repo:"image"



# Dockerfile

### Définir une phase
FROM example:version as "nom de phase"
-alpine possible

### Créer une image à partir d'une phase
docker build --target contacts_php_prod -t fay0026/demo-contacts:v1.0.0 .
le -t permet de nommer, et le --target précise la phase.

### Copier des fichiers
COPY "Fichier1" ("Fichier2"...) "Destination"
#### A partir d'une phase
COPY --from="nom de phase" "Fichier1/Répertoire1" "Destination"
#### De tout les fichiers au docker
COPY . ./

### Définir un point de montage
VOLUME "Destination"

### Définir une entrée pour l'exécutable
ENTRYPOINT["filename"]

### Lancer un argument à l'exécutable
CMD["easter egg command"]

### Lancer des commandes en terminal
RUN "random command"\
"angry command"
#### Sécurisé (quitte si krach)
RUN set -eux

## Docker-compose

### Utiliser une variable d'un .env
 ${APP_ENV} 
#### Vérifier si elle est vide
 ${APP_ENV:?APP_ENV is not set or empty} 

### Organisation générale
services:
  dev:
    image: ${DEMO_REACT:?DEMO_REACT is not set or empty}:v${APP_VERSION}
    ports:
      - "80:8085"
      (Définis le port)
    restart:
      always
      (Permet de toujours relancer l'image)

# Déploiement

Pour le déploiement, si la version d'un projet est antérieure à la version de la machine hôte, il faut la supprimer et la recréer pour la mettre à jour. down, puis up. un build pour une màj, down, nouveau tag/pull, up.

docker build, puis docker push. username/monapp monapp.web
Sur la machine virtuelle, juste besoin du .env et du docker-compose.yml
On fait docker pull, et on est bon.



user data www-data:x:33:33:www-data:/var/www:/usr/sbin/nologin

setfacl -m u:33:..x website

Le groupe a un priorité sur l'utilisateur, penser à accorder les droits au groupe avant l'utilisateur.


Pour changer de tags :
docker tag monimage:v1.0a.0 monimage:v1.0.0


Si notre image hérite déjà de l'image cible, on peut juste lancer un npm run build

# CERTIFICATS

## Vérifier un certificat

Cette commande est utilisable sur un certificat racine, si utilisée sur un certificat certifié par un autre, cela ne marchera pas ou vous renverra une mauvaise réponse.

openssl verify -show-chain "certificat"

## Visualiser le contenu d'un certificat

openssl x509 -in "certificat" -noout -text

### N'extraire que la clé publique

openssl x509 -in "certificat" -noout -pubkey

## Créer une clef privée RSA
openssl genrsa -out server.key 2048

## Générer un certificat auto signé basé sur une clef privée

openssl req -new -x509 -key server.key -out server.crt -days 365

-new pour demander la création d'un nouveau certificat
-x509 pour demander un certificat auto signé
-key server.key pour préciser le nom du fichier contenant la clé
-day 365 pour préciser la durée de validité de 1 an de ce certificat
-out server.crt pour donner le nom du fichier de sortie qui contiendra le certificat.

