# ecf-garage Guide d'installation
Guide d’installation Projet garage Leveque Emmanuel 20/07/2023
Téléphone de contact : 06.09.57.00.04
E-mail : clavinova1@free.fr
Lien public Github : git@github.com:Clickandgo-informatique/ecf-garage.git
Lien Trello : https://trello.com/b/JNOJfimP/ecf-garage
Lien site en ligne : https://ecf-garage-ba610b6d6edb.herokuapp.com/
Cloner un dépôt Git : https://docs.github.com/fr/repositories/creating-and-managing-repositories/cloning-a-repository
Guide d’installation :
1/ Installer Xampp ou Mamp ou Easy-php avec la dernière version de php
2/ Installer Composer
4/ Installer Symfony :
https://symfony.com/download
5/ Cloner le dépôt en suivant les instructions en se rendant sur le lien fourni plus haut
6/ Démarrer le serveur Apache depuis l’interface de Xampp ou Mamp ou Easy-php et MySql
7/Créer la base de données en tapant :
 symfony console doctrine:database:create
7/ Créer la base de données et effectuer les migrations :
Dans l’éditeur de code (vscode par exemple, ouvrir le dossier du projet puis ouvrir un terminal :
Taper : symfony console make:migration 
Puis taper : symfony console doctrine:migration:migrate
8/ Créer le jeu de données factice (fixtures)
Toujours dans le terminal taper :
Symfony console doctrine :fixtures :load
Suite à cette commande le chargement des données devrait s’effectuer.
Dans le logiciel gérant php activer « MySQL »
Dans le navigateur taper : https://127.0.0.1:8000, la page d’accueil du site devrait être affichée
Pour accéder au compte administrateur du site, appuyez sur « Se connecter » et rentrez dans le formulaire :
Email :
Vincent.parrot@garage-parrot.fr
Mot de passe :
Parrot2023!
Pour accéder au compte « Employé » du site, appuyez sur « Se connecter » et rentrez dans le formulaire :
Email :
employe1@garage-parrot.fr ou employe2@garage-parrot.fr
Mot de passe :
Employe2023!
Attention : Il est indispensable d’installer un intercepteur de mails (type MailHog) pour pouvoir profiter de toutes les fonctionnalités du site et recevoir les messages de confirmation de l’interface sans blocages…
