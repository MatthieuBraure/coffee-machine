# Machine

## Introduction
Il n'y a qu'une seule machine actuellement, son accès se fait implicitement via le repository (méthode get sans paramètre).

Pour en rajouter plusieurs il faudrait :
- Créer une API de listing des machines (coffee-machine/list)
- Ajouter un champs id ou name dans les routes des APIs pour la contrôler.
- Ajouter l'id de la machine concernée dans les commandes

## Gestion des états

Il n'y a pas de workflow pour imposer les transitions possibles entre les états. 
Les différents états sont définis dans le domaine (CoffeeMachineStatus)
OFF => La machine est éteinte il faut la démarrer (API Start)
STARTING => phase d'allumage de la machine, elle ne peut pas être utilisée
READY => la machine est prête à recevoir des commandes
RUNNING => la machine prépare un café
SHUTDOWN => la machine s'éteint.

## Commandes

### Start
La machine doit être OFF pour pouvoir être démarrée, passage à STARTING puis à READY
Dès que la machine est prête, un evénement (MachineReadyEvent) est déclenché, il est responsable de relancer les anciennes commandes et d'annuler la commande en cours s'il y en a une.
### Stop
Tous les états sont acceptés, passage à SHUTDOWN puis à OFF


## Reprise des commandes
Lorsque la machine est éteinte, les commandes non traitées (status PENDING) sont conservées.
Au redémarrage de la machine, celles ci sont relancées (via l'event MachineReadyEvent).

## Gestion des commandes
Le temps de préparation du café est défini par la machine et dépendant de la taille du café.
