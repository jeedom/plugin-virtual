# Complemento virtual

El complemento virtual permite la creación de dispositivos virtuales y sus propiedades.

Vamos a nombrar un dispositivo creado por este complemento : dispositivo virtual.

Se puede crear un dispositivo virtual para las siguientes necesidades :

-   consolidar información o acciones de varios dispositivos físicos / virtuales en un solo dispositivo;
-   crear un periférico alimentado por una fuente externa a Jeedom (Zibase, IPX800, etc.);
-   equipo duplicado para dividirlo en 2, por ejemplo;
-   realizar un cálculo en varios valores de equipo;
-   ejecutar múltiples acciones (macro).

# Configuration

El complemento no requiere ninguna configuración, solo tiene que activarlo :

![virtual1](../images/virtual1.png)

# Configuración del equipo

Se puede acceder a la configuración de dispositivos virtuales desde el menú de complementos :

![virtual2](../images/virtual2.png)

Así es como se ve la página del complemento virtual (aquí con un equipo) :

![virtual3](../images/virtual3.png)

Así es como se ve la página de configuración de un dispositivo virtual :

![virtual4](../images/virtual4.png)

> **Punta**
>
> Como en muchos lugares de Jeedom, al colocar el mouse en el extremo izquierdo, aparece un menú de acceso rápido (siempre puede dejarlo visible desde su perfil).

Aquí encontrarás toda la configuración de tu equipo :

-   **Nombre del dispositivo virtual** : nombre de su equipo virtual,
-   **Objeto padre** : indica el objeto padre al que pertenece el equipo,
-   **Categoría** : categorías de equipos (puede pertenecer a varias categorías),
-   **Activar** : activa su equipo,
-   **Visible** : lo hace visible en el tablero,
-   **Comentario** : le permite comentar sobre el equipo.

En la parte superior derecha tiene acceso a 4 botones :

-   **Expresión** : El probador de expresión idéntico al de los escenarios para facilitar el desarrollo de algunos
-   **Equipo de importación** : permite duplicar automáticamente un equipo existente en uno virtual (ahorra tiempo para dividir un equipo en 2, por ejemplo),
-   **Duplicar** : duplica el equipo actual,
-   **Avanzado (ruedas con muescas)** : muestra opciones de equipos avanzados (comunes a todos los complementos de Jeedom).

A continuación encontrará la lista de pedidos :

-   el nombre que se muestra en el tablero,
-   tipo y subtipo,
-   el valor : permite dar el valor del comando de acuerdo con otro comando, una tecla (cuando hacemos un cambio virtual), un cálculo, etc.
-   "Valor de retroalimentación de estado "y" Duración antes de la retroalimentación de estado" : permite indicar a Jeedom que después de un cambio en la información, su valor debe volver a Y, X min después del cambio. Ejemplo : en el caso de un detector de presencia que emite solo durante una detección de presencia, es útil establecer, por ejemplo, 0 en valor y 4 en duración, de modo que 4 minutos después de una detección de movimiento (y s ' no ha habido noticias desde entonces) Jeedom restablece el valor de la información a 0 (se detecta más movimiento),
-   Unidad : unidad de datos (puede estar vacía),
-   Guardar historial : permite historizar los datos,
-   Mostrar : permite mostrar los datos en el tablero,
-   Evento : en el caso de RFXcom, esta casilla siempre debe estar marcada porque no puede interrogar a un módulo RFXcom,
-   min / max : límites de datos (pueden estar vacíos),
-   configuración avanzada (ruedas con muescas pequeñas) : muestra la configuración avanzada del comando (método de registro, widget, etc.),
-   "Tester" : Se usa para probar el comando,
-   eliminar (firmar -) : permite eliminar el comando.

# Tutoriel

## Interruptor virtual

Para hacer un cambio virtual, debe agregar 2 comandos virtuales como este :

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

Para hacer un control deslizante virtual, agregue un comando virtual como este :

![virtual12](../images/virtual12.png)

Como antes después de la copia de seguridad, Jeedom creará automáticamente el comando de información :

![virtual13](../images/virtual13.png)

Y como antes, es recomendable vincular la acción al comando de estado y ocultarlo.

## Interruptor de palanca

Así es como hacer un cambio de tipo alternar, para eso debe crear un comando virtual de este tipo :

![virtual14](../images/virtual14.png)

Luego guarda para ver aparecer el comando de estado :

![virtual15](../images/virtual15.png)

Aquí es necesario en el valor del comando de acción poner ``not(\#[...][...][Etat]#)`` (reemplace con su propio comando) y vincule el estado con el comando de acción (tenga cuidado, esta vez no debe ocultar el comando de estado). También debe colocar el comando de información en subtipo binario.

Para hacer un cálculo en múltiples pedidos, es muy fácil ! Simplemente cree un orden de tipo de información virtual y en el campo de valor coloque sus cálculos. El probador de expresiones puede ayudarlo con este paso para validar. Por ejemplo, para promediar 2 temperaturas :

![virtual10](../images/virtual10.png)

Varios puntos para hacer correctamente :

-   Elija el subtipo de acuerdo con el tipo de información (aquí promediando, entonces es un valor numérico),
-   Ponga paréntesis en los cálculos, esto le permite estar seguro del resultado de la operación,
-   Pon la unidad bien,
-   Marque la casilla para iniciar sesión si es necesario,



## Pedidos múltiples


Veremos aquí cómo hacer un pedido que apagará 2 luces. Nada podría ser más simple, solo crea un pedido virtual y coloca los 2 pedidos separados por un ``&&`` :

![virtual11](../images/virtual11.png)

Aquí, el subtipo de comando debe ser el mismo que los subtipos de comando controlado, por lo que todos los comandos en el campo de valor deben tener el mismo subtipo (todos los controles deslizantes "todos" o todos " ", o todo color).

## Retroalimentación de estado virtual

Cuando se utiliza un equipo que no tiene una retroalimentación de estado y si este equipo está controlado solo por Jeedom, es posible tener una retroalimentación de estado virtual. Esto requiere crear un virtual que tome los comandos de acciones (ej: On & Off) del equipo y que tiene un comando de información (el estado). Luego debe completar la columna Parámetro para cada comando de acción, seleccionando el nombre del comando de información (estado) y dando el valor que debe tomar.

También podemos imaginar una virtual que enciende / apaga varias lámparas (comandos de acciones separados por &&) y, por lo tanto, tiene un estado de este comando general.

# Asignación de un valor por API

Es posible cambiar el valor de la información virtual por un
Llamada API :

``http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#``

> **Nota**
>
> Tenga cuidado de agregar un / jeedom después de \#IP\_JEEDOM\# si es necesario
