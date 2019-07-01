# Conference-Blog

Projet Symfony 
Outil de gestion de conference, composé d'une partie front et back.

Contenu : 
  - Design Bootstrap
  - DockerFile
  - Gestion des comptes : interface user & admin
  - Inscription et connexion 
  - Sécurité
  - CRUD utilisateurs & conférences
  - Satistiques 
  - Gestion des votes
  - Pagination 
  - Envoi des mails et récupération grâce à mailhog (port 8025)
  - BDD gestion avecc adminer (port 8083)
  - Génération de fixtures
  - Upload d'images


Pour installer l'application veuillez lancer Docker et lancer dans votre terminal à l'emplaçement du projet la commande : 
- make start
Puis
- php bin/console server:run

L'application est maintenant en marche sur votre localhost au le port 8000

Connexion à l'admin : 
  - mail : root@root.com & password : root

Connexion en tant qu'utilisateur:
  - mail : user@user.com & password : user

