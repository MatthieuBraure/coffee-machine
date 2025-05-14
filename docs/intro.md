# Intro
## Architecture générale
Le projet a une architecture simple en DDD/CQRS.
Le domaine (CoffeMachine) contient les 3 dossiers principaux (Application, Domain, Infrastructure).

Pour la partie CQRS il y a 3 bus différents (utilise Messenger)
- Command Bus: il est responsable de l'exécution des commandes.

- Query Bus: il est responsable de l'exécution des requêtes.

 - Event Bus: il est responsable de l'exécution des événements.

## Messenger
Toute la partie des commandes et événements est gérée par Messenger (Shared\Infrastructure), le transport choisi est la base de donnée déjà en place mais on peut utiliser rabbitmq par exemple (branche rabbitmq disponible en démo).

## Gestion des commandes et de la machine
Le transport async est utilisé pour la liaison entre le projet et le machine. Il y a un consumer lancé qui va lire les messages et les traiter. Les sleep positionnées permettent de simuler la préparation du café et la réactivité de la machine.

## QA 
Il n'y a pas de tests écrit sur le projet mais 2 outils sont disponibles :
- make php-cs-fixer et make phpstan pour vérifier la qualité du code
- une collection postman est disponible pour appeler les APIs

## Evolution possible : 
### Gestion des états
Actuellement il n'y a pas de workflow pour imposer les transitions possibles entre les états (commande et machine).

### Ajout de plusieurs machines
Il faudrait :
- Ajouter un champs id ou name dans les routes des APIs pour la contrôler.
- Ajouter l'id de la machine concernée dans les commandes

Passer à rabbitmq pour gérer plusieurs queues et lancer un consumer par machine/queue
