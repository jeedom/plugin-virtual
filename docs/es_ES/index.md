# Presentación

El plugin Virtual (virtual) permite la creación de dispositivos virtuales
y sus propiedades.

Nous nommerons un périphérique créé par ce plugin : périphérique
virtuel.

Se puede crear un dispositivo virtual para los siguientes propósitos:

-   consolidar en un solo dispositivo las informaciones o acciones de
    múltiples dispositivos físicos/virtuales ;

-   crear un dispositivo alimentado por una fuente externa a Jeedom
    (Zibase, IPX800…) ;

-   duplicar un dispositivo para dividirlo en 2, por ejemplo ;

-   effectuer un calcul sur plusieurs valeurs d'équipements ;

-   realizar múltiples acciones (macro).




# Configuración

El plugin no requiere ninguna configuración, solo actívelo :

![virtual1](../images/virtual1.png)




# Configuración de los dispositivos

La configuración de los dispositivos virtuales es accesible desde
el menú plugin:

![virtual2](../images/virtual2.png)

Así es como se ve la página del plugin virtual (aquí con un
dispositivo):

![virtual3](../images/virtual3.png)

Así es como se ve la página de configuración de un dispositivo virtual
:

![virtual4](../images/virtual4.png)

> **Sugerencia**
>
> Como en muchos lugares en Jeedom, coloque el mouse hacia la izquierda
> permite abrir un menú de acceso rápido (puede
>dejarlo siempre visible desde su perfil).

Aquí encontrará toda la configuración de su dispositivo:

-   **Nombre del dispositivo virtual** : nombre de su dispositivo virtual,

-   **Objeto padre** : especifica el objeto padre al que pertenece
    dispositivo,

-   **Catégorie** : les catégories de l'équipement (il peut appartenir à
    varias categorías),

-   ** ** Activar: para que su equipo activo,

-   **Visible** : le rend visible sur le dashboard,

-   **Commentaire** : vous permet de mettre des commentaires sur
    el equipo.

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

-   el valor: permite dar el valor del comando de acuerdo.
    d’une autre commande, d’une clef (quand on fait un interrupteur
    virtual), de un cálculo, etc.

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
    el control prolongado de la configuración (método de tala,
    widget, etc.),

-   "Tester" : permet de tester la commande,

-   supprimer (signe -) : permet de supprimer la commande.




# Tutorial

## Interruptor virtual

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




## Slider virtual

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

Cálculo

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

-   Tiene que poner bien la unidad,

-   Cocher la case pour historiser si nécessaire,



## Comandos multiples


Nous allons voir ici comment faire une commande qui va éteindre 2
lumières. Rien de plus simple, il suffit de créer une commande virtuelle
et de mettre les 2 commandes séparées par un `&&` :

![virtual11](../images/virtual11.png)

Ici, il faut bien que le sous-type de la commande soit le même que les
sous-types des commandes pilotées, donc toutes les commandes dans le
champs valeur doivent avoir le même sous-type (toutes "autre", ou toutes
"slider", ou toutes de type couleur).




## Estado virtual de retorno

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




# Asignando un valor por API

Il est possible de changer la valeur d’une information virtuelle par un
appel API :

    http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#

> **Note**
>
> Attention à bien rajouter un /jeedom après \#IP\_JEEDOM\# si nécessaire
