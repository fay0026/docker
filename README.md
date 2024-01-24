# s4-docker
## FAY Damien

Dernier TP :

# Partage et persistance des données

Maintenant, recréez le même conteneur avec la même commande :

docker run -ti --name=my-ubuntu --volume /working/<votre_login>/s4-docker/partage:/myData ubuntu /bin/bash

Vérifiez la présence ou l'absence des fichiers /other_file.txt et /myData/file2.txt ainsi que de leur contenu.


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

#### Après avoir créé des fichiers via un conteneur, il faut effectuer un rm dans le conteneur pour le supprimer.