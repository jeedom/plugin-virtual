# Virtual plugin

The plugin **Virtual** allows the creation of virtual equipment and virtual controls.

In this documentation, we will name a device created by this plugin as a **virtual equipment**.

Virtual equipment can be useful for the following needs :

- consolidate in a single device the information and / or actions of several physical / virtual devices,
- create equipment powered by a source external to Jeedom *(Zibase, IPX800, etc)*,
- duplicate equipment to split it into 2 for example,
- perform a calculation on several equipment values,
- perform multiple actions *(macro)*.

>**IMPORTANT**
>
>Virtuals should not be abused because they lead to general overconsumption *(cpu / memory / swap / disk)*, longer latency times, wear of the SD card, etc ! Virtuals are tools to be used sparingly only when necessary.

# Configuration

## Plugin configuration

This plugin does not require any special configuration and must simply be activated after installation.

## Equipment configuration

Virtual devices are accessible from the menu **Plugins → Programming → Virtual**.

Click on a virtual device to access its configuration page :

- **Virtual name** : name of your virtual equipment.
- **Parent object** : indicates the parent object to which the equipment belongs,
- **Category** : equipment categories *(it can belong to several categories)*,
- **Activate** : allows to make the equipment active,
- **Visible** : allows to make the equipment visible on the dashboard.
- **Self-actualization** : Info commands update frequency *(by cron - a wizard is available by clicking on the question mark at the end of the line)*.
- **Return url** : it is possible to change the value of a virtual information by API (``http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&plugin=virtual&type=event&id=#CMD_ID#&value=#VALUE#``)
- **Virtual description** : allows you to describe the virtual equipment.

>**TRICK**
>
>Concerning I'**Return url**, be sure to add ``/jeedom`` after ``#IP_JEEDOM#`` if necessary.

At the top right you have access to 3 buttons in addition to those common to all plugins :

- **Expression** : opens the expression tester to facilitate the implementation of certain virtual ones.
- **Template** : allows you to create a virtual device very quickly by selecting a template.
- **Import equipment** : Automatically duplicates existing equipment as virtual equipment *(to save time in order to split a piece of equipment into 2 for example)*.

# Commandes

By clicking on the tab **Orders**, you will find the list of virtual controls :

- **ID** : the order identification number.
- **Name** :
    - **Order name** : the name displayed on the dashboard.
    - **Icon** : if applicable, the icon representing the order.
    - **Related info command** *(actions)* : used to enter the status info command linked to the action command.
- **Type** : type and subtype,
- **Value** : allows to give the value of the command according to another command, a key *(when we make a virtual switch)*, a calculation, etc...
- **Settings** :
    - **Status return value** & **Duration before status return** *(infos)* : allows you to indicate that the value must return to ``Y``, ``X minutes`` after a change. For example, in the case of a motion detector which emits only upon detection, it is useful to put ``0`` in value and ``4`` in duration so that 4 minutes after a movement detection the value of the command reverts to ``0`` *(if there have been no other detections since)*.
    - **Info to update** & **info value** *(actions)* : allows you to indicate an info command to update during the execution of the command and the value to assign to it.
- **Options** :
  - **Pin up** : allows you to display the order on the dashboard.
  - **Historize** : allows to log the order.
  - **Reverse**: allows to invert the value of the command *(info / binary only)*.
  - **Min / max** : command value limits *(may be empty - min:0/max:100 by default)*.
  - **Unit** : order value unit *(can be empty)*.
  - **List of values** : List of ``valeur|texte`` separated by a ``; (point-virgule)`` *(action / list only)*.
- **Actions** :
    - **Advanced configuration** *(toothed wheels)* : used to display the advanced configuration of the command *(historization method, widget, etc...)*.
    - **Test** : Used to test the command.
    - **To delete** *(sign -)* : allows to delete the command.

>**INFORMATION**
>
>Each virtual device has a command **Refresh** which allows to force the update of all info commands.

# Virtual examples

## Virtual switch

To make a virtual switch, you have to add 2 virtual actions like this :

![virtual5](../images/virtual5.png)

Then you save and there Jeedom will automatically add the virtual information command :

![virtual6](../images/virtual6.png)

Add in the orders "action" ``On`` and ``Off``, The command ``Etat`` (this allows Jeedom to make the link with the state command).

To have a nice widget, you have to hide the status command :

![virtual7](../images/virtual7.png)

Assign a widget that manages the status feedback to the 2 action commands, for example here the light widget. To do this click on the small notched wheel in front of the control ``On`` and in the 2nd tab select ``light`` as widget :

![virtual8](../images/virtual8.png)

Save and do the same for the order ``Off``. And you will get a nice widget that will change state when clicked :

![virtual9](../images/virtual9.png)

## Virtual slider

To make a virtual slider, you have to add a virtual action like this :

![virtual12](../images/virtual12.png)

As before after the backup, Jeedom will automatically create the info command :

![virtual13](../images/virtual13.png)

And as before, it is advisable to link the action to the status command and to hide it.

## Toggle switch

This is how to make a toggle type switch (or push button), for this you have to create a virtual action of this type :

![virtual14](../images/virtual14.png)

Then you save to see the status command appear :

![virtual15](../images/virtual15.png)

Here it is necessary in the value of the action command to put ``not(#[...][...][Etat]#)`` *(replace with your own order)* and link the state to the action command (be careful, you must not hide the state command this time). You must also place the info command in binary subtype.

## Multiple orders

To do a calculation on multiple orders, it's very easy ! Simply create a virtual command of type ``info/Numérique`` and in the value field put your calculations. The expression tester can help you with this step to validate. For example, to average 2 temperatures :

![virtual10](../images/virtual10.png)

Several points to be done correctly :

- Choose the subtype according to the type of information (here calculation of average so it is a numeric),
- Put parentheses in the calculations, this allows you to be sure of the result of the operation,
- Put the unit well,
- Check the box to log if necessary.

We will see here how to make an order which will turn off 2 lights. Nothing could be simpler, just create a virtual command of type ``action/Défaut`` and put the 2 commands separated by a ``&&`` :

![virtual11](../images/virtual11.png)

It is imperative that the subtype of the command is the same as the subtypes of the controlled commands. All the commands in the value field must therefore have the same subtype *(all "other" or all "slider" or all of type "color", etc...)*.

## Virtual status feedback

When using equipment which does not have a status feedback and if this equipment is controlled only by Jeedom, it is possible to have a virtual status feedback. This requires creating a virtual that takes the actions commands (ex: On & Off) of the equipment and which has an info command (the). You must then complete the Parameter column for each action command, by selecting the name of the info command (status) and giving the value it must take.

We can also imagine a virtual one that turns on / off several lamps (actions commands separated by &&) and thus have a status of this general command.
