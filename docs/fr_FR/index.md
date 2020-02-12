# Présentation

Le plugin Virtual (virtuel) permet la création de périphériques virtuels
et de leurs propriétés.

Nous nommerons un périphérique créé par ce plugin : périphérique
virtuel.

Un périphérique virtuel peut être créé pour les besoins suivants :

-   consolider dans un seul périphérique des informations ou actions de
    plusieurs périphériques physiques/virtuels ;

-   créer un périphérique alimenté par une source externe à Jeedom
    (Zibase, IPX800…) ;

-   dupliquer un équipement pour le scinder en 2 par exemple ;

-   effectuer un calcul sur plusieurs valeurs d'équipements ;

-   exécuter de multiples actions (macro).




# Configuration

Le plugin ne nécessite aucune configuration, il faut juste l’activer :

![virtual1](../images/virtual1.png)




# Configuration des équipements

La configuration des équipements virtuels est accessible à partir du
menu plugin :

![virtual2](../images/virtual2.png)

Voilà à quoi ressemble la page du plugin virtuel (ici avec déjà un
équipement) :

![virtual3](../images/virtual3.png)

Voilà à quoi ressemble la page de configuration d’un équipement virtuel
:

![virtual4](../images/virtual4.png)

> **Tip**
>
> Comme à beaucoup d’endroits sur Jeedom, mettre la souris tout à gauche
> permet de faire apparaître un menu d’accès rapide (vous pouvez à
> partir de votre profil le laisser toujours visible).

Vous retrouvez ici toute la configuration de votre équipement :

-   **Nom de l'équipement virtuel** : nom de votre équipement virtuel,

-   **Objet parent** : indique l’objet parent auquel appartient
    l'équipement,

-   **Catégorie** : les catégories de l'équipement (il peut appartenir à
    plusieurs catégories),

-   **Activer** : permet de rendre votre équipement actif,

-   **Visible** : le rend visible sur le dashboard,

-   **Commentaire** : vous permet de mettre des commentaires sur
    l'équipement.

En haut à droite vous avez accès à 4 boutons :

-   **Expression** : le testeur d'expressions identique à celui des scénarios
    pour vous faciliter la mise au point de certains virtuels

-   **Importer équipement** : permet de dupliquer automatiquement un
    équipement existant dans un virtuel (permet de gagner du temps pour
    scinder un équipement en 2 par exemple),

-   **Dupliquer** : permet de dupliquer l'équipement courant,

-   **Avancée (roues crantées)** : permet d’afficher les options
    avancées de l'équipement (commun à tous les plugins Jeedom).

En-dessous vous retrouvez la liste des commandes :

-   le nom affiché sur le dashboard,

-   le type et le sous-type,

-   la valeur : permet de donner la valeur de la commande en fonction
    d’une autre commande, d’une clef (quand on fait un interrupteur
    virtuel), d’un calcul, etc.

-   "Valeur de retour d'état" et "Durée avant retour d'état" : permet
    d’indiquer à Jeedom qu’après un changement sur l’information sa
    valeur doit revenir à Y, X min après le changement. Exemple : dans
    le cas d’un détecteur de présence qui n'émet que lors d’une
    détection de présence, il est utile de mettre par exemple 0 en
    valeur et 4 en durée, pour que 4 mn après une détection de mouvement
    (et s’il n’y a en pas eu de nouvelle(s) depuis) Jeedom remette la
    valeur de l’information à 0 (plus de mouvement détecté),

-   unité : unité de la donnée (peut être vide),

-   historiser : permet d’historiser la donnée,

-   afficher : permet d’afficher la donnée sur le dashboard,

-   événement : dans le cas du RFXcom cette case doit toujours être
    cochée car on ne peut pas interroger un module RFXcom,

-   min/max : bornes de la donnée (peuvent être vides),

-   configuration avancée (petites roues crantées) : permet d’afficher
    la configuration avancée de la commande (méthode d’historisation,
    widget, etc.),

-   "Tester" : permet de tester la commande,

-   supprimer (signe -) : permet de supprimer la commande.




# Tutoriel

## Interrupteur virtuel

Pour faire un interrupteur virtuel, il vous faut ajouter 2 commandes
virtuelles comme cela :

![virtual5](../images/virtual5.png)

Puis vous sauvegardez et là Jeedom va automatiquement ajouter la
commande d’information virtuelle :

![virtual6](../images/virtual6.png)

Ajoutez dans les commandes "action" `On` et `Off`, la commande `Etat`
(cela permet à Jeedom de faire le lien avec la commande état).

Pour avoir un joli widget, il vous faut masquer la commande d'état :

![virtual7](../images/virtual7.png)

Affectez un widget qui gère le retour d'état aux 2 commandes d’action,
par exemple ici le widget light. Pour ce faire cliquez sur la petite
roue crantée en face de la commande `On` et dans le 2ème onglet
sélectionnez `light` comme widget :

![virtual8](../images/virtual8.png)

Enregistrez et faites de même pour la commande `Off`. Et vous obtiendrez
un joli widget qui changera d'état lors d’un clic :

![virtual9](../images/virtual9.png)




## Slider virtuel

Pour faire un slider virtuel, il faut ajouter une commande virtuelle
comme cela :

![virtual12](../images/virtual12.png)

Comme tout à l’heure après la sauvegarde, Jeedom va automatiquement
créer la commande info :

![virtual13](../images/virtual13.png)

Et comme tout à l’heure il est conseillé de lier l’action à la commande
d'état et de masquer celle-ci.




## Interrupteur de type toggle

Voilà comment faire un interrupteur de type toggle, pour cela il faut
créer une commande virtuelle de ce type :

![virtual14](../images/virtual14.png)

Ensuite vous sauvegardez pour voir apparaître la commande d'état :

![virtual15](../images/virtual15.png)

Ici il faut dans la valeur de la commande action mettre
`not(\#[...][...][Etat]#)` (bien remplacer par votre propre commande) et
lier l'état à la commande action (attention, il ne faut pas masquer la
commande état cette fois). Il faut aussi passer la commande info en
sous-type binaire.

Calcul

Pour faire un calcul sur de multiples commandes, c’est très facile ! Il
suffit de créer une commande de type information virtuelle et dans le
champs valeur mettre vos calculs. Le testeur d'expression peut vous aider
à cette étape pour valider. Par exemple, pour faire la moyenne de
2 températures :

![virtual10](../images/virtual10.png)

Plusieurs points à réaliser correctement :

-   Bien choisir le sous-type en fonction du type d’information (ici
    calcul de moyenne donc c’est un numérique),

-   Mettre des parenthèses dans les calculs, cela permet d'être sûr du
    résultat de l’opération,

-   Bien mettre l’unité,

-   Cocher la case pour historiser si nécessaire,



## Multiple commandes


Nous allons voir ici comment faire une commande qui va éteindre 2
lumières. Rien de plus simple, il suffit de créer une commande virtuelle
et de mettre les 2 commandes séparées par un `&&` :

![virtual11](../images/virtual11.png)

Ici, il faut bien que le sous-type de la commande soit le même que les
sous-types des commandes pilotées, donc toutes les commandes dans le
champs valeur doivent avoir le même sous-type (toutes "autre", ou toutes
"slider", ou toutes de type couleur).




## Retour d'état virtuel

Lors de l’utilisation d’un équipement qui ne possède pas de retour
d'état et si cet équipement est commandé seulement par Jeedom, il est
possible d’avoir un retour d'état virtuel. Il faut pour cela créer un
virtuel qui reprend les commandes actions (ex: On & Off) de l'équipement
et qui possède une commande info (l'état). Il faut ensuite renseigner la
colonne Paramètre pour chaque commande action, en sélectionnant le nom
de la commande info (état) et en donnant la valeur qu’elle doit prendre.

On peut aussi imaginer un virtuel qui allume/éteint plusieurs lampes
(commandes actions séparées par des &&) et avoir ainsi un état de cette
commande générale.




# Affectation d’une valeur par API

Il est possible de changer la valeur d’une information virtuelle par un
appel API :

    http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#

> **Note**
>
> Attention à bien rajouter un /jeedom après \#IP\_JEEDOM\# si nécessaire
