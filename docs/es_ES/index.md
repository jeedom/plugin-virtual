# Complemento virtual

El complemento **Virtual** permite la creación de equipos virtuales y controles virtuales.

En esta documentación, nombraremos un dispositivo creado por este complemento como un **equipo virtual**.

El equipo virtual puede ser útil para las siguientes necesidades :

- consolidar en un solo dispositivo la información y / o acciones de varios dispositivos físicos / virtuales,
- crear equipos alimentados por una fuente externa a Jeedom *(Zibase, IPX800, etc)*,
- duplicar el equipo para dividirlo en 2, por ejemplo,
- realizar un cálculo en varios valores del equipo,
- realizar múltiples acciones *(macro)*.

>**IMPORTANTE**
>
>No se debe abusar de los dispositivos virtuales porque conducen a un consumo excesivo generalizado *(cpu / memoria / intercambio / disco)*, tiempos de latencia más largos, desgaste de la tarjeta SD, etc ! Los virtuales son herramientas que se deben usar con moderación solo cuando sea necesario.

# Configuration

## Configuración del complemento

Este complemento no requiere ninguna configuración especial y simplemente debe activarse después de la instalación.

## Crear/actualizar monitor Jeedom

Botón que le permite crear equipos de Internet Jeedom que le brindarán información interna sobre jeedom : 

- para cada complemento que tenga un demonio, un comando sobre el estado del demonio
- para cada complemento que tenga un demonio, un comando para iniciar el demonio
- para cada complemento que tenga un demonio, un comando para detener el demonio
- número de actualizaciones disponibles
- número de mensajes en el centro de mensajes
- versión de aflicción
- hacer una copia de seguridad
- inicie la actualización de Jeedom (y complementos)


## Configuración del equipo

Los dispositivos virtuales son accesibles desde el menú **Complementos → Programación → Virtual**.

Haga clic en un dispositivo virtual para acceder a su página de configuración :

- **Nombre virtual** : nombre de su equipo virtual.
- **Objeto padre** : indica el objeto padre al que pertenece el equipo,
- **Categoría** : categorías de equipos *(puede pertenecer a varias categorías)*,
- **Activar** : permite activar el equipo,
- **Visible** : permite hacer visible el equipo en el salpicadero.
- **Autorrealización** : Frecuencia de actualización de comandos de información *(por cron: hay un asistente disponible al hacer clic en el signo de interrogación al final de la línea)*.
- **URL de retorno** : es posible cambiar el valor de una información virtual por API (``http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#Yplugin=virtualYtype=eventYid=#CMD_ID#Yvalue=#VALUE#``)
- **Descripción virtual** : le permite describir el equipo virtual.

>**TRUCO**
>
>Concerniente a yo'**URL de retorno**, asegúrese de agregar ``/jeedom`` después ``#IP_JEEDOM#`` si es necesario.

En la parte superior derecha tiene acceso a 3 botones además de los comunes a todos los complementos :

- **Expresión** : abre el probador de expresiones para facilitar la implementación de ciertos virtuales.
- **Plantilla** : le permite crear un dispositivo virtual muy rápidamente seleccionando una plantilla.
- **Equipo de importación** : Duplica automáticamente el equipo existente como equipo virtual *(para ahorrar tiempo con el fin de dividir un equipo en 2, por ejemplo)*.

# Commandes

Haciendo clic en la pestaña **Pedidos**, encontrarás la lista de controles virtuales :

- **IDENTIFICACIÓN** : el número de identificación del pedido.
- **Apellido** :
    - **Nombre de la orden** : el nombre que se muestra en el tablero.
    - **Icono** : si corresponde, el icono que representa el pedido.
    - **Comando de información relacionada** *(actions)* : utilizado para ingresar el comando de información de estado vinculado al comando de acción.
- **Escribe** : tipo y subtipo,
- **Valor** : permite dar el valor del comando de acuerdo con otro comando, una tecla *(cuando hacemos un cambio virtual)*, un cálculo, etc...
- **Configuraciones** :
    - **Valor de retorno de estado** Y **Duración antes de la devolución del estado** *(infos)* : le permite indicar que el valor debe volver a ``Y``, ``X minutes`` después de un cambio. Por ejemplo, en el caso de un detector de movimiento que emite solo al ser detectado, es útil poner ``0`` en valor y ``4`` de duración para que 4 minutos después de una detección de movimiento el valor del comando vuelva a ``0`` *(si no ha habido otras detecciones desde)*.
    - **Información para actualizar** Y **valor de la información** *(actions)* : le permite indicar un comando de información para actualizar durante la ejecución del comando y el valor para asignarle.
- **Opciones** :
  - **Mostrar** : le permite mostrar el pedido en el tablero.
  - **Guardar historial** : permite registrar el pedido.
  - **Marcha atrás**: permite invertir el valor del comando *(información / solo binario)*.
  - **Min / max** : límites de valor nominal *(puede estar vacío - min:0/max:100 por defecto)*.
  - **Unidad** : unidad de valor de pedido *(puede estar vacío)*.
  - **Lista de valores** : Lista de ``valeur|texte`` separados por un ``; (point-virgule)`` *(acción / lista solamente)*.
- **Comportamiento** :
    - **Configuración avanzada** *(ruedas dentadas)* : utilizado para mostrar la configuración avanzada del comando *(método de historización, widget, etc...)*.
    - **Probar** : Se usa para probar el comando.
    - **Borrar** *(signo -)* : permite eliminar el comando.

>**INFORMACIÓN**
>
>Cada dispositivo virtual tiene un comando **Actualizar** que permite forzar la actualización de todos los comandos de información.

# Ejemplos virtuales

## Interruptor virtual

Para hacer un cambio virtual, debe agregar 2 acciones virtuales como esta :

![virtual5](../images/virtual5.png)

Luego guarda y Jeedom agregará automáticamente el comando de información virtual :

![virtual6](../images/virtual6.png)

Agregar en la acción "órdenes" ``On`` y ``Off``, El orden ``Etat`` (esto le permite a Jeedom hacer el enlace con el comando de estado).

Para tener un buen widget, debes ocultar el comando de estado :

![virtual7](../images/virtual7.png)

Asigne un widget que gestione los comentarios de estado a los 2 comandos de acción, por ejemplo, aquí el widget de luz. Para hacer esto, haga clic en la pequeña rueda con muesca en frente del control ``On`` y en la segunda pestaña seleccione ``light`` como widget :

![virtual8](../images/virtual8.png)

Guardar y hacer lo mismo para el pedido ``Off``. Y obtendrá un buen widget que cambiará de estado al hacer clic :

![virtual9](../images/virtual9.png)

## Control deslizante virtual

Para hacer un control deslizante virtual, debe agregar una acción virtual como esta :

![virtual12](../images/virtual12.png)

Como antes después de la copia de seguridad, Jeedom creará automáticamente el comando de información :

![virtual13](../images/virtual13.png)

Y como antes, es recomendable vincular la acción al comando de estado y ocultarlo.

## Interruptor de palanca

Así es como se hace un interruptor tipo palanca (o pulsador), para ello tienes que crear una acción virtual de este tipo :

![virtual14](../images/virtual14.png)

Luego guarda para ver aparecer el comando de estado :

![virtual15](../images/virtual15.png)

Aquí es necesario en el valor del comando de acción poner ``not(#[...][...][Etat]#)`` *(reemplácelo con su propio pedido)* y vincular el estado al comando de acción (tenga cuidado, no debe ocultar el comando de estado esta vez). También debe colocar el comando de información en subtipo binario.

## Pedidos múltiples

Para hacer un cálculo en múltiples pedidos, es muy fácil ! Simplemente cree un comando virtual de tipo ``info/Numérique`` y en el campo valor pon tus cálculos. El probador de expresiones puede ayudarlo con este paso para validar. Por ejemplo, para promediar 2 temperaturas :

![virtual10](../images/virtual10.png)

Varios puntos para hacer correctamente :

- Elija el subtipo de acuerdo con el tipo de información (aquí cálculo del promedio para que sea un valor numérico),
- Ponga paréntesis en los cálculos, esto le permite estar seguro del resultado de la operación,
- Pon la unidad bien,
- Marque la casilla para iniciar sesión si es necesario.

Veremos aquí cómo hacer un pedido que apagará 2 luces. Nada podría ser más simple, simplemente cree un comando virtual de tipo ``action/Défaut`` y poner los 2 comandos separados por un ``YY`` :

![virtual11](../images/virtual11.png)

Es imperativo que el subtipo del comando sea el mismo que los subtipos de los comandos controlados. Por tanto, todos los comandos del campo de valor deben tener el mismo subtipo *(todos los "otros" o todos los "controles deslizantes" o todos los de tipo "color", etc...)*.

## Retroalimentación de estado virtual

Cuando se utiliza un equipo que no tiene una retroalimentación de estado y si este equipo está controlado solo por Jeedom, es posible tener una retroalimentación de estado virtual. Esto requiere crear un virtual que tome los comandos de acciones (ej: On & Off) del equipo y que tiene un comando de información (el). Luego debe completar la columna Parámetro para cada comando de acción, seleccionando el nombre del comando de información (estado) y dando el valor que debe tomar.

También podemos imaginar una virtual que enciende / apaga varias lámparas (comandos de acciones separados por &&) y, por lo tanto, tiene un estado de este comando general.
