# Plugin Virtuel

Le plugin **Virtuel** permet la création d'équipements virtuels et de commandes virtuelles.

Dans cette documentation, nous nommerons un équipement créé par ce plugin comme étant un **équipement virtuel**.

Un équipement virtuel peut être utile pour les besoins suivants :

- consolider dans un seul équipement les informations et/ou les actions de plusieurs équipements physiques/virtuels,
- créer un équipement alimenté par une source externe à Jeedom *(Zibase, IPX800, etc…)*,
- dupliquer un équipement pour le scinder en 2 par exemple,
- effectuer un calcul sur plusieurs valeurs d'équipements,
- exécuter de multiples actions *(macro)*.

>**IMPORTANT**
>
>Il ne faut pas abuser des virtuels car ils entrainent une surconsommation générale *(cpu/mémoire/swap/disque)*, des temps de latence plus longs, une usure de la carte SD, etc... Il ne faut donc EN AUCUN CAS dupliquer (tous) les équipements en virtuel sans absolue nécessité ! Les virtuels sont des outils à utiliser avec parcimonie uniquement lorsque cela s'avère nécessaire.

# Configuration

## Configuration du plugin

Ce plugin ne nécessite pas de configuration particulière et doit simplement être activé après l'installation.

## Configuration des équipements

Les équipements virtuels sont accessibles à partir du menu **Plugins → Programmation → Virtuel**.

Cliquez sur un équipement virtuel pour accéder à sa page de configuration :

- **Nom du virtuel** : nom de votre équipement virtuel.
- **Objet parent** : indique l’objet parent auquel appartient l'équipement,
- **Catégorie** : les catégories de l'équipement *(il peut appartenir à plusieurs catégories)*,
- **Activer** : permet de rendre l’équipement actif,
- **Visible** : permet de rendre l’équipement visible sur le dashboard.
- **Auto-actualisation** : Fréquence de mise à jour des commandes info *(par cron - un assistant est disponible en cliquant sur le point d'interrogation en bout de ligne)*.
- **URL de retour** : il est possible de changer la valeur d’une information virtuelle par API (``http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&plugin=virtual&type=event&id=#CMD_ID#&value=#VALUE#``)
- **Description du virtuel** : vous permet de décrire l'équipement virtuel.

>**ASTUCE**
>
>Concernant l'**URL de retour**, veillez à bien ajouter ``/jeedom`` après ``#IP_JEEDOM#`` si nécessaire.

En haut à droite vous avez accès à 3 boutons en complément de ceux communs à tous les plugins :

- **Expression** : ouvre le testeur d'expressions afin de faciliter la mise en place de certains virtuels.
- **Template** : permet de créer un équipement virtuel très rapidement par la sélection d'un template.
- **Importer équipement** : permet de dupliquer automatiquement un équipement existant en équipement virtuel *(pour gagner du temps afin de scinder un équipement en 2 par exemple)*.

# Commandes

En cliquant sur l'onglet **Commandes**, vous retrouvez la liste des commandes virtuelles :

- **ID** : le numéro d'identification de la commande.
- **Nom** :
    - **Nom de la commande** : le nom affiché sur le dashboard.
    - **Icône** : le cas échéant, l'icône représentative de la commande.
    - **Commande info liée** *(actions)* : permet de renseigner la commande info d'état liée à la commande action.
- **Type** : le type et le sous-type,
- **Valeur** : permet de donner la valeur de la commande en fonction d’une autre commande, d’une clef *(quand on fait un interrupteur virtuel)*, d’un calcul, etc...
- **Paramètres** :
    - **Valeur de retour d'état** & **Durée avant retour d'état** *(infos)* : permet d’indiquer que la valeur doit revenir à ``Y``, ``X minutes`` après un changement. Par exemple, dans le cas d’un détecteur de mouvement qui n'émet que lors d’une détection, il est utile de mettre ``0`` en valeur et ``4`` en durée pour que 4 minutes après une détection de mouvement la valeur de la commande revienne à ``0`` *(s’il n’y en a pas eu d'autres détections depuis)*.
    - **Info à mettre à jour** & **valeur de l'info** *(actions)* : permet d'indiquer une commande info à mettre à jour lors de l'exécution de la commande et la valeur à lui attribuer.
- **Options** :
  - **Afficher** : permet d’afficher la commande sur le dashboard.
  - **Historiser** : permet d’historiser la commande.
  - **Inverser**: permet d'inverser la valeur de la commande *(info/binaire uniquement)*.
  - **Min/Max** : bornes des valeurs de la commande *(peuvent être vides - min:0/max:100 par défaut)*.
  - **Unité** : unité de la valeur de la commande *(peut être vide)*.
  - **Liste de valeurs** : Liste de ``valeur|texte`` séparées par un ``; (point-virgule)`` *(action/liste uniquement)*.
- **Actions** :
    - **Configuration avancée** *(roues crantées)* : permet d’afficher la configuration avancée de la commande *(méthode d’historisation, widget, etc...)*.
    - **Tester** : permet de tester la commande.
    - **Supprimer** *(signe -)* : permet de supprimer la commande.

>**INFORMATION**
>
>Chaque équipement virtuel possède une commande **Rafraichir** qui permet de forcer la mise à jour de toutes les commandes info.

# Exemples de virtuels

## Interrupteur virtuel

Pour faire un interrupteur virtuel, il faut ajouter 2 actions virtuelles comme cela :

![virtual5](../images/virtual5.png)

Puis vous sauvegardez et là Jeedom va automatiquement ajouter la commande d’information virtuelle :

![virtual6](../images/virtual6.png)

Ajoutez dans les commandes "action" ``On`` et ``Off``, la commande ``Etat`` (cela permet à Jeedom de faire le lien avec la commande état).

Pour avoir un joli widget, il faut masquer la commande d'état :

![virtual7](../images/virtual7.png)

Affectez un widget qui gère le retour d'état aux 2 commandes d’action, par exemple ici le widget light. Pour ce faire cliquez sur la petite roue crantée en face de la commande ``On`` et dans le 2ème onglet sélectionnez ``light`` comme widget :

![virtual8](../images/virtual8.png)

Enregistrez et faites de même pour la commande ``Off``. Et vous obtiendrez un joli widget qui changera d'état lors d’un clic :

![virtual9](../images/virtual9.png)

## Slider virtuel

Pour faire un slider virtuel, il faut ajouter une action virtuelle comme cela :

![virtual12](../images/virtual12.png)

Comme tout à l’heure après la sauvegarde, Jeedom va automatiquement créer la commande info :

![virtual13](../images/virtual13.png)

Et comme tout à l’heure il est conseillé de lier l’action à la commande d'état et de masquer celle-ci.

## Interrupteur de type toggle

Voilà comment faire un interrupteur de type toggle (ou bouton poussoir), pour cela il faut créer une action virtuelle de ce type :

![virtual14](../images/virtual14.png)

Ensuite vous sauvegardez pour voir apparaître la commande d'état :

![virtual15](../images/virtual15.png)

Ici il faut dans la valeur de la commande action mettre ``not(#[...][...][Etat]#)`` *(remplacer par votre propre commande)* et lier l'état à la commande action (attention, il ne faut pas masquer la commande état cette fois). Il faut aussi passer la commande info en sous-type binaire.

## Multiple commandes

Pour faire un calcul sur de multiples commandes, c’est très facile ! Il suffit de créer une commande virtuelle de type ``info/Numérique`` et dans le champs valeur mettre vos calculs. Le testeur d'expression peut vous aider à cette étape pour valider. Par exemple, pour faire la moyenne de 2 températures :

![virtual10](../images/virtual10.png)

Plusieurs points à réaliser correctement :

- Bien choisir le sous-type en fonction du type d’information (ici calcul de moyenne donc c’est un numérique),
- Mettre des parenthèses dans les calculs, cela permet d'être sûr du résultat de l’opération,
- Bien mettre l’unité,
- Cocher la case pour historiser si nécessaire.

Nous allons voir ici comment faire une commande qui va éteindre 2 lumières. Rien de plus simple, Il suffit de créer une commande virtuelle de type ``action/Défaut`` et de mettre les 2 commandes séparées par un ``&&`` :

![virtual11](../images/virtual11.png)

Il est impératif que le sous-type de la commande soit le même que les sous-types des commandes pilotées. Toutes les commandes dans le champs valeur doivent donc avoir le même sous-type *(toutes "autre" ou toutes "slider" ou toutes de type "couleur", etc...)*.

## Retour d'état virtuel

Lors de l’utilisation d’un équipement qui ne possède pas de retour d'état et si cet équipement est commandé seulement par Jeedom, il est possible d’avoir un retour d'état virtuel. Il faut pour cela créer un virtuel qui reprend les commandes actions (ex: On & Off) de l'équipement et qui possède une commande info (l'état). Il faut ensuite renseigner la colonne Paramètre pour chaque commande action, en sélectionnant le nom de la commande info (état) et en donnant la valeur qu’elle doit prendre.

On peut aussi imaginer un virtuel qui allume/éteint plusieurs lampes (commandes actions séparées par des &&) et avoir ainsi un état de cette commande générale.
