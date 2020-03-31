# Presentation

The Virtual plugin allows the creation of virtual devices
and their properties.

We will name a device created by this plugin : peripheral
virtual.

A virtual device can be created for the following needs :

-   consolidate information or actions from a single device
    multiple physical / virtual devices;

-   create a device powered by a source external to Jeedom
    (Zibase, IPX800…);

-   duplicate equipment to split it into 2, for example;

-   perform a calculation on several equipment values;

-   execute multiple actions (macro).




# Setup

The plugin does not require any configuration, you just have to activate it :

![virtual1](../images/virtual1.png)




# Equipment configuration

The configuration of the virtual devices is accessible from the
plugin menu :

![virtual2](../images/virtual2.png)

This is what the virtual plugin page looks like (here with already a
equipment) :

![virtual3](../images/virtual3.png)

This is what the configuration page of a virtual device looks like
:

![virtual4](../images/virtual4.png)

> **Tip**
>
> As in many places on Jeedom, put the mouse on the far left
> brings up a quick access menu (you can
> from your profile always leave it visible).

Here you find all the configuration of your equipment :

-   **Name of the virtual device** : name of your virtual equipment,

-   **Parent object** : indicates the parent object to which belongs
    equipment,

-   **Category** : equipment categories (it may belong to
    multiple categories),

-   **Activate** : makes your equipment active,

-   **Visible** : makes it visible on the dashboard,

-   **Comment** : allows you to comment on
    equipment.

At the top right you have access to 4 buttons :

-   **Expression** : the expression tester identical to that of the scenarios
    to facilitate the development of some virtual

-   **Import equipment** : allows to automatically duplicate a
    existing equipment in a virtual (saves time for
    split equipment in 2 for example),

-   **Duplicate** : duplicates current equipment,

-   **Advanced (notched wheels)** : displays options
    equipment advances (common to all Jeedom plugins).

Below you find the list of orders :

-   the name displayed on the dashboard,

-   type and subtype,

-   the value : allows to give the value of the order according
    another command, a key (when you make a switch
    ), a calculation, etc..

-   "Status feedback value "and" Duration before status feedback" : allows
    to indicate to Jeedom that after a change in the information
    value must return to Y, X min after the change. Example : IN
    the case of a presence detector which emits only during a
    presence detection, it is useful to set for example 0
    value and 4 in duration, so that 4 min after motion detection
    (and if there has been no news since) Jeedom puts back the
    information value at 0 (no more movement detected),

-   Unit : data unit (can be empty),

-   Historize : allows to historize the data,

-   Pin up : allows to display the data on the dashboard,

-   Event : in the case of RFXcom this box must always be
    checked because you cannot query an RFXcom module,

-   min / max : data bounds (may be empty),

-   advanced configuration (small notched wheels) : Displays
    advanced configuration of the command (historization method,
    widget, etc.),

-   "Test" : Used to test the command,

-   delete (sign -) : allows to delete the command.




# Tutorial

## Virtual switch

To make a virtual switch, you need to add 2 commands
virtual like this :

![virtual5](../images/virtual5.png)

Then you save and there Jeedom will automatically add the
virtual information order :

![virtual6](../images/virtual6.png)

Ajoutez IN les commandes "action" `On` et `Off`, la commande `Etat`
(this allows Jeedom to make the link with the state command).

To have a nice widget, you need to hide the status command :

![virtual7](../images/virtual7.png)

Assign a widget that manages the status feedback to the 2 action commands,
for example here the light widget. To do this click on the small
toothed wheel in front of the `On` command and in the 2nd tab
select `light` as widget :

![virtual8](../images/virtual8.png)

Enregistrez et faites de même pour la commande `Off`. And you will get
a nice widget that will change state when clicked :

![virtual9](../images/virtual9.png)




## Virtual slider

To make a virtual slider, add a virtual command
like this :

![virtual12](../images/virtual12.png)

As before after the backup, Jeedom will automatically
create the info command :

![virtual13](../images/virtual13.png)

And as before it is advisable to link the action to the command
and hide it.




## Toggle switch

This is how to make a toggle type switch.
create such a virtual order :

![virtual14](../images/virtual14.png)

Then you save to see the status command appear :

![virtual15](../images/virtual15.png)

Here it is necessary in the value of the action command to put
`not(\#[...][...][Etat]#)` (bien remplacer par votre propre commande) et
link the status to the action command (be careful, do not hide the
state command this time). You must also place the info command in
binary subtype.

Calculation

To do a calculation on multiple orders, it's very easy ! He
just create a virtual information type command and in the
value fields put your calculations. The expression tester can help you
at this stage to validate. For example, to average
2 temperatures :

![virtual10](../images/virtual10.png)

Several points to be done correctly :

-   Choose the subtype according to the type of information (here
    averaging so it's a numeric),

-   Put parentheses in the calculations, this allows you to be sure of the
    result of the operation,

-   Put the unit well,

-   Check the box to log if necessary,



## Multiple orders


We will see here how to make an order that will turn off 2
lights. Nothing simpler, just create a virtual order
et de mettre les 2 commandes séparées par un `&&` :

![virtual11](../images/virtual11.png)

Here, the command subtype must be the same as the
subtypes of the controlled commands, therefore all the commands in the
value fields must have the same subtype (all "other", or all
"slider ", or all of color type).




## Virtual status feedback

When using equipment that has no return
status and if this equipment is ordered only by Jeedom, it is
possible to have a virtual feedback. This requires creating a
virtual which takes action commands (ex: On & Off) of equipment
and who has an info command (status). Then you have to fill in the
Parameter column for each action command, by selecting the name
of the info command (status) and giving the value it should take.

We can also imagine a virtual one that turns on / off several lamps
(actions commands separated by &&) and thus have a status of this
general order.




# Assigning a value by API

It is possible to change the value of virtual information by a
API call :

    http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#

> **NOTE**
>
> Be careful to add a / jeedom after \ #IP \ _JEEDOM \ # if necessary
