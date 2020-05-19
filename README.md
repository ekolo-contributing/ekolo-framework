# Ekolo Framework

Framework PHP

C'est un framework, ayant pour but de donner aux développeurs un environnement de travail simple et souple

## Installation

Pour l'installer vous devez à avoir déjà composer installé. Si ce n'est pas le cas aller sur  [Composer](https://getcomposer.org/).

### Installation avec [ekolo/installer](https://packagist.org/packages/ekolo/installer)

Vous pouvez utiliser [ekolo/installer](https://packagist.org/packages/ekolo/installer) qui un outil qui vous permettra de générer par défaut la structure de votre projet et les différents éléments que vous aurez besoin pour votre développement.

Pour installer [ekolo/installer](https://packagist.org/packages/ekolo/installer), tappez sur votre console (assure-vous d'avoir [Composer](https://getcomposer.org/) installé) : 

```bash
$ composer global require ekolo/installer
```

Une fois [ekolo/installer](https://packagist.org/packages/ekolo/installer) installé, pour créer un nouveau projet il suffit de taper sur votre console :

```bash
$ ekolo new your-project-name
```

Vous aurez en retour un truc du genre :

```bash
   crée : your-project-name\
   crée : your-project-name\app\
   crée : your-project-name\app\Controllers\
   crée : your-project-name\app\Controllers\PagesController.php
   crée : your-project-name\app\Middleware\
   crée : your-project-name\app\Middleware\ErrorsMiddleware.php
   crée : your-project-name\app\Models\
   crée : your-project-name\app\Models\PagesModel.php
   crée : your-project-name\bootstrap\app.php
   crée : your-project-name\bootstrap\constantes.php
   crée : your-project-name\bootstrap\helpers.php
   crée : your-project-name\config\app.php
   crée : your-project-name\config\database.php
   crée : your-project-name\config\namespace.php
   crée : your-project-name\config\path.php
   crée : your-project-name\public\css\style.css
   crée : your-project-name\public\img\ekolo-logo.png
   crée : your-project-name\public\js\
   crée : your-project-name\routes\pages.php
   crée : your-project-name\views\errors\
   crée : your-project-name\views\errors\404.php
   crée : your-project-name\views\errors\error.php
   crée : your-project-name\views\pages\index.php
   crée : your-project-name\views\layout.php
   crée : your-project-name\.env
   crée : your-project-name\.gitignore
   crée : your-project-name\.htaccess
   crée : your-project-name\composer.json
   crée : your-project-name\ekolo
   crée : your-project-name\index.php

   Accéder au dossier du projet:
    > cd test-heroku-bitbucket

   Installez les dépendances:
    > composer install

   Générer l'autoloader de class:
    > composer dumpautoload -o

   Lancer le projet:
    > php ekolo serve
```

Et pour lancer votre projet il suffit de faire :

```bash
$ php ekolo serve
```

L'application sera lancée par défaut sur le port `3000` mais au cas où vous aurez besoin de spécifier votre propre port vous pouvez faire :

```bash
$ php ekolo serve:8080
```

Donc `8080` peut être remplacé par le port que vous souhaitez spécifier.

### Installation directe

Pour installer directement [ekolo/ekolo-framework](https://packagist.org/packages/ekolo/ekolo-framework) sur votre projet :

```bash
$ composer require ekolo/ekolo-framework
```

Assurez-vous d'être à l'emplacement de votre projet. Une fois fait, vous devez créer cahque dossier et fichier générés par [ekolo/installer](https://packagist.org/packages/ekolo/installer) à la main (par vous même ;-)).

Bon la suite de la doc vient après, :-)