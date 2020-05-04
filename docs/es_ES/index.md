# Presentación 

El complemento virtual permite la creación de dispositivos virtuales
y sus propiedades.

Vamos a nombrar un dispositivo creado por este complemento : periférico
virtuel.

Se puede crear un dispositivo virtual para las siguientes necesidades :

-   consolidar información o acciones desde un solo dispositivo
    múltiples dispositivos físicos / virtuales;

-   crear un dispositivo alimentado por una fuente externa a Jeedom
    (Zibase, IPX800 ...);

-   equipo duplicado para dividirlo en 2, por ejemplo;

-   realizar un cálculo en varios valores de equipo;

-   ejecutar múltiples acciones (macro).




# Configuration

El complemento no requiere ninguna configuración, solo tiene que activarlo :

![virtual1](../images/virtual1.png)




# Configuración del equipo

Se puede acceder a la configuración de los dispositivos virtuales desde
menú de complementos :

![virtual2](../images/virtual2.png)

Así es como se ve la página del complemento virtual (aquí con un
equipos) :

![virtual3](../images/virtual3.png)

Así es como se ve la página de configuración de un dispositivo virtual
:

![virtual4](../images/virtual4.png)

> **Tip**
>
> Como en muchos lugares de Jeedom, coloca el mouse en el extremo izquierdo
> abre un menú de acceso rápido (puedes
> desde tu perfil siempre déjalo visible).

Aquí encontrarás toda la configuración de tu equipo :

-   **Nombre del dispositivo virtual.** : nombre de su equipo virtual,

-   **Objeto padre** : indica el objeto padre al que pertenece
    equipo,

-   **Categoría** : categorías de equipos (puede pertenecer a
    categorías múltiples),

-   **Activer** : activa su equipo,

-   **Visible** : lo hace visible en el tablero,

-   **Commentaire** : le permite comentar
    equipo.

En la parte superior derecha tiene acceso a 4 botones. :

-   **Expression** : el probador de expresión idéntico al de los escenarios
    para facilitar el desarrollo de algunos virtuales

-   **Equipo de importación** : permite duplicar automáticamente un
    equipo existente en un virtual (ahorra tiempo para
    dividir el equipo en 2, por ejemplo),

-   **Dupliquer** : duplica el equipo actual,

-   **Avanzado (ruedas con muescas)** : muestra opciones
    avances de equipo (comunes a todos los complementos de Jeedom).

A continuación encontrará la lista de pedidos. :

-   el nombre que se muestra en el tablero,

-   tipo y subtipo,

-   el valor : permite dar el valor del pedido según
    otro comando, una tecla (cuando haces un cambio
    ), un cálculo, etc..

-   "Valor de retroalimentación de estado "y" Duración antes de la retroalimentación de estado" : permet
    para indicarle a Jeedom que después de un cambio en la información
    el valor debe volver a Y, X min después del cambio. Ejemplo : dans
    el caso de un detector de presencia que emite solo durante un
    detección de presencia, es útil establecer por ejemplo 0
    valor y 4 de duración, de modo que 4 minutos después de la detección de movimiento
    (y si no ha habido noticias desde entonces) Jeedom vuelve a poner el
    valor de información en 0 (no se detecta más movimiento),

-   Unidad : unidad de datos (puede estar vacía),

-   Guardar historial : permite historizar los datos,

-   Mostrar : permite mostrar los datos en el tablero,

-   Evento : en el caso de RFXcom, esta casilla siempre debe ser
    marcado porque no puede consultar un módulo RFXcom,

-   min / max : límites de datos (pueden estar vacíos),

-   configuración avanzada (ruedas con muescas pequeñas) : Muestra
    configuración avanzada del comando (método de historización,
    widget, etc.),

-   "Tester" : Se usa para probar el comando,

-   eliminar (firmar -) : permite eliminar el comando.




# Tutoriel

## Interruptor virtual

Para realizar un cambio virtual, debe agregar 2 comandos
virtual como este :

![virtual5](../images/virtual5.png)

Luego guarda y allí Jeedom agregará automáticamente el
orden de información virtual :

![virtual6](../images/virtual6.png)

Agregue los comandos de "acción" `On` y` Off`, el comando `State`
(esto le permite a Jeedom hacer el enlace con el comando de estado).

Para tener un buen widget, debes ocultar el comando de estado :

![virtual7](../images/virtual7.png)

Asigne un widget que gestione los comentarios de estado a los 2 comandos de acción,
por ejemplo aquí el widget de luz. Para hacer esto, haga clic en el pequeño
rueda dentada delante del comando `On` y en la segunda pestaña
seleccione `light` como widget :

![virtual8](../images/virtual8.png)

Guarde y haga lo mismo para el comando `Off`. Y obtendrás
un buen widget que cambiará de estado al hacer clic :

![virtual9](../images/virtual9.png)




## Control deslizante virtual

Para hacer un control deslizante virtual, agregue un comando virtual
asi :

![virtual12](../images/virtual12.png)

Como antes después de la copia de seguridad, Jeedom automáticamente
crear el comando de información :

![virtual13](../images/virtual13.png)

Y como antes es recomendable vincular la acción al comando
y esconderlo.




## Interruptor de palanca

Así es como hacer un cambio de tipo de alternar.
crear un pedido tan virtual :

![virtual14](../images/virtual14.png)

Luego guarda para ver aparecer el comando de estado :

![virtual15](../images/virtual15.png)

Aquí es necesario en el valor del comando de acción poner
`not (\# [...] [...] [State] #)` (reemplace con su propio comando) y
vincular el estado al comando de acción (tenga cuidado, no oculte el
comando estatal esta vez). También debe colocar el comando de información en
subtipo binario.

Calcul

Para hacer un cálculo en múltiples pedidos, es muy fácil ! Il
simplemente cree un comando de tipo de información virtual y en el
campos de valor ponen sus cálculos. El probador de expresiones puede ayudarte
en esta etapa para validar. Por ejemplo, para promediar
2 temperaturas :

![virtual10](../images/virtual10.png)

Varios puntos para hacer correctamente :

-   Elija el subtipo de acuerdo con el tipo de información (aquí
    promediando así que es un valor numérico),

-   Ponga paréntesis en los cálculos, esto le permite estar seguro de la
    resultado de la operación,

-   Pon la unidad bien,

-   Marque la casilla para iniciar sesión si es necesario,



## Pedidos múltiples


Veremos aquí cómo hacer un pedido que se apagará 2
luces Nada más simple, solo crea un pedido virtual
y poner los 2 comandos separados por un `&&` :

![virtual11](../images/virtual11.png)

Aquí, el subtipo de comando debe ser el mismo que el
subtipos de los comandos controlados, por lo tanto, todos los comandos en el
los campos de valor deben tener el mismo subtipo (todos "otros" o todos
"control deslizante "o todo tipo de color).




## Retroalimentación de estado virtual

Cuando se usa equipo que no tiene retorno
estado y si este equipo es pedido solo por Jeedom, es
posible tener una retroalimentación virtual. Esto requiere crear un
virtual que toma comandos de acción (ej.: Encendido y apagado) del equipo
y quién tiene un comando de información (estado). Entonces tienes que completar el
Columna de parámetros para cada comando de acción, seleccionando el nombre
del comando de información (estado) y dar el valor que debe tomar.

También podemos imaginar una virtual que enciende / apaga varias lámparas
(comandos de acciones separados por &&) y, por lo tanto, tienen un estado de esto
orden general.




# Asignación de un valor por API

Es posible cambiar el valor de la información virtual por un
Llamada API :

    http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#

> **Note**
>
> Tenga cuidado de agregar un / jeedom después de \#IP\_JEEDOM \# si es necesario
