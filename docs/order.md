# Order

## Introduction
La commande d'un café se fait avec 2 paramètres :
size: la taille du café (enum CoffeeSize)
intensity: l'intensité du café (int) entre 1 et 10

## Commandes

### Placer une commande
Si la commande est acceptée (machine disponible), elle est mise en PENDING :

Le status de la commande est défini dans OrderStatus
PENDING => La commande est en attente de traitement
PROCESSING => Le café est en cours de préparation
DONE => La café en fini
CANCELED => La commande a été annulée

### Annuler une commande
Si le café en cours de préparation ou en attente il est possible de l'annuler. (API api_coffee_cancel)

