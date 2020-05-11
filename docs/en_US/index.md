# Virtual plugin

The Virtual plugin allows the creation of virtual devices and their properties.

We will name a device created by this plugin : virtual device.

A virtual device can be created for the following needs :

-   consolidate information or actions from several physical / virtual devices into a single device;
-   create a peripheral powered by a source external to Jeedom (Zibase, IPX800, etc.);
-   duplicate equipment to split it into 2, for example;
-   perform a calculation on several equipment values;
-   execute multiple actions (macro).

# Configuration

The plugin does not require any configuration, you just have to activate it :

![virtual1](../images/virtual1.png)

# Equipment configuration

The configuration of virtual devices is accessible from the plugin menu :

![virtual2](../images/virtual2.png)

This is what the virtual plugin page looks like (here with already an equipment) :

![virtual3](../images/virtual3.png)

This is what the configuration page of a virtual device looks like :

![virtual4](../images/virtual4.png)

> **Tip**
>
> As in many places on Jeedom, putting the mouse on the far left allows a quick access menu to appear (you can always leave it visible from your profile).

Here you find all the configuration of your equipment :

-   **Name of the virtual device** : name of your virtual equipment,
-   **Parent object** : indicates the parent object to which the equipment belongs,
-   **Category** : equipment categories (it can belong to several categories),
-   **Activate** : makes your equipment active,
-   **Visible** : makes it visible on the dashboard,
-   **Comment** : allows you to comment on equipment.

At the top right you have access to 4 buttons :

-   **Expression** : the expression tester identical to that of the scenarios to facilitate the development of some virtual
-   **Import equipment** : allows to automatically duplicate an existing equipment in a virtual one (saves time to split an equipment in 2 for example),
-   **Duplicate** : duplicates current equipment,
-   **Advanced (notched wheels)** : displays advanced equipment options (common to all Jeedom plugins).

Below you find the list of orders :

-   the name displayed on the dashboard,
-   type and subtype,
-   the value : allows to give the value of the command according to another command, a key (when we make a virtual switch), a calculation, etc.
-   "Status feedback value "and" Duration before status feedback" : allows to indicate to Jeedom that after a change on the information its value must return to Y, X min after the change. Example : in the case of a presence detector which emits only during a presence detection, it is useful to set for example 0 in value and 4 in duration, so that 4 minutes after a detection of movement (and s' there has been no news since) Jeedom resets the value of the information to 0 (more movement detected),
-   Unit : data unit (can be empty),
-   Historize : allows to historize the data,
-   Pin up : allows to display the data on the dashboard,
-   Event : in the case of RFXcom this box must always be checked because you cannot interrogate an RFXcom module,
-   min / max : data bounds (may be empty),
-   advanced configuration (small notched wheels) : displays the advanced configuration of the command (logging method, widget, etc.),
-   "Tester" : Used to test the command,
-   delete (sign -) : allows to delete the command.

# Tutoriel

## Virtual switch

To make a virtual switch, you need to add 2 virtual commands like this :

![virtual5](../images/virtual5.png)

Then you save and there Jeedom will automatically add the virtual information command :

![virtual6](../images/virtual6.png)

Add in the orders "action" ``On`` and ``Off``, The command ``Etat`` (this allows Jeedom to make the link with the state command).

To have a nice widget, you need to hide the status command :

![virtual7](../images/virtual7.png)

Assign a widget that manages the status feedback to the 2 action commands, for example here the light widget. To do this click on the small notched wheel in front of the control ``On`` and in the 2nd tab select ``light`` as widget :

![virtual8](../images/virtual8.png)

Save and do the same for the order ``Off``. And you will get a nice widget that will change state when clicked :

![virtual9](../images/virtual9.png)

## Virtual slider

To make a virtual slider, add a virtual command like this :

![virtual12](../images/virtual12.png)

As before after the backup, Jeedom will automatically create the info command :

![virtual13](../images/virtual13.png)

And as before, it is advisable to link the action to the status command and to hide it.

## Toggle switch

This is how to make a switch of type toggle, for that you have to create a virtual command of this type :

![virtual14](../images/virtual14.png)

Then you save to see the status command appear :

![virtual15](../images/virtual15.png)

Here it is necessary in the value of the action command to put ``not(\#[...][...][Etat]#)`` (replace with your own command) and link the state to the action command (be careful, you should not hide the state command this time). You must also place the info command in binary subtype.

To do a calculation on multiple orders, it's very easy ! Just create a virtual information type order and in the value field put your calculations. The expression tester can help you with this step to validate. For example, to average 2 temperatures :

![virtual10](../images/virtual10.png)

Several points to be done correctly :

-   Choose the subtype according to the type of information (here averaging so it's a numeric),
-   Put parentheses in the calculations, this allows you to be sure of the result of the operation,
-   Put the unit well,
-   Check the box to log if necessary,



## Multiple orders


We will see here how to make an order which will turn off 2 lights. Nothing could be simpler, just create a virtual order and put the 2 orders separated by a ``&&`` :

![virtual11](../images/virtual11.png)

Here, the command subtype must be the same as the controlled command subtypes, so all commands in the value field must have the same subtype (all "other", or all "slider ", or all color).

## Virtual status feedback

When using equipment which does not have a status feedback and if this equipment is controlled only by Jeedom, it is possible to have a virtual status feedback. This requires creating a virtual that takes the actions commands (ex: On & Off) of the equipment and which has an info command (the status). You must then complete the Parameter column for each action command, by selecting the name of the info command (status) and giving the value it must take.

We can also imagine a virtual one that turns on / off several lamps (actions commands separated by &&) and thus have a status of this general command.

# Assigning a value by API

It is possible to change the value of virtual information by a
API call :

``http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#``

> **NOTE**
>
> Be careful to add a / jeedom after \#IP\_JEEDOM\# if necessary
