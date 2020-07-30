# Virtuelles Plugin

Das virtuelle Plugin ermöglicht die Erstellung virtueller Geräte und ihrer Eigenschaften.

Wir werden ein Gerät benennen, das von diesem Plugin erstellt wurde : virtuelles Gerät.

Ein virtuelles Gerät kann für die folgenden Anforderungen erstellt werden :

-   Konsolidieren von Informationen oder Aktionen von mehreren physischen / virtuellen Geräten zu einem einzigen Gerät;
-   Erstellen Sie ein Peripheriegerät, das von einer Quelle außerhalb von Jeedom (Zibase, IPX800 usw.) gespeist wird
-   doppelte Ausrüstung, um sie beispielsweise in zwei Teile zu teilen;
-   eine Berechnung für mehrere Gerätewerte durchführen;
-   Führen Sie mehrere Aktionen aus (Makro).

# Configuration

Das Plugin benötigt keine Konfiguration, Sie müssen es nur aktivieren :

![virtual1](../images/virtual1.png)

# Gerätekonfiguration

Auf die Konfiguration virtueller Geräte kann über das Plugin-Menü zugegriffen werden :

![virtual2](../images/virtual2.png)

So sieht die virtuelle Plugin-Seite aus (hier mit bereits einem) :

![virtual3](../images/virtual3.png)

So sieht die Konfigurationsseite eines virtuellen Geräts aus :

![virtual4](../images/virtual4.png)

> **Spitze**
>
> Wie an vielen Stellen in Jeedom wird durch einfaches Bewegen der Maus ganz links ein Schnellzugriffsmenü angezeigt (Sie können es in Ihrem Profil immer sichtbar lassen).

Hier finden Sie die gesamte Konfiguration Ihrer Geräte :

-   **Name des virtuellen Geräts** : Name Ihrer virtuellen Ausrüstung,
-   **Übergeordnetes Objekt** : Gibt das übergeordnete Objekt an, zu dem das Gerät gehört,
-   **Kategorie** : Gerätekategorien (es kann zu mehreren Kategorien gehören),
-   **Aktivieren** : macht Ihre Ausrüstung aktiv,
-   **Sichtbar** : macht es auf dem Dashboard sichtbar,
-   **Kommentar** : ermöglicht es Ihnen, Geräte zu kommentieren.

Oben rechts haben Sie Zugriff auf 4 Schaltflächen :

-   **Ausdruck** : Der Ausdruckstester ist mit dem der Szenarien identisch, um die Entwicklung einiger virtueller Systeme zu erleichtern
-   **Ausrüstung importieren** : Mit dieser Option können Sie ein vorhandenes Gerät automatisch in ein virtuelles Gerät duplizieren (dies spart beispielsweise Zeit, um ein Gerät in zwei Teile aufzuteilen),
-   **Duplikat** : dupliziert aktuelle Geräte,
-   **Fortgeschrittene (Zahnräder)** : Ermöglicht die Anzeige der erweiterten Optionen des Geräts (allen Jeedom-Plugins gemeinsam).

Nachfolgend finden Sie die Liste der Bestellungen :

-   Der im Dashboard angezeigte Name,
-   Typ und Subtyp,
-   der Wert : ermöglicht es, den Wert des Befehls gemäß einem anderen Befehl, einem Schlüssel (wenn wir einen virtuellen Wechsel vornehmen), einer Berechnung usw. anzugeben.
-   "Statusrückmeldungswert "und" Dauer vor Statusrückmeldung" : ermöglicht es Jeedom anzuzeigen, dass nach einer Änderung der Informationen der Wert auf Y, X min nach der Änderung zurückkehren muss. Beispiel : Bei einem Anwesenheitsdetektor, der nur während einer Anwesenheitserkennung emittiert, ist es sinnvoll, beispielsweise 0 als Wert und 4 als Dauer anzugeben, so dass 4 Minuten nach einer Bewegungserkennung (und wenn Seitdem gab es keine Neuigkeiten mehr.) Jeedom setzt den Informationswert auf 0 zurück (keine Bewegung mehr erkannt),
-   Unit : Dateneinheit (kann leer sein),
-   Chronik : ermöglicht das Historisieren der Daten,
-   Anzeige : ermöglicht die Anzeige der Daten im Dashboard,
-   Ereignis : Bei RFXcom muss dieses Kontrollkästchen immer aktiviert sein, da Sie ein RFXcom-Modul nicht abfragen können,
-   min / max : Datengrenzen (können leer sein),
-   Erweiterte Konfiguration (kleine gekerbte Räder) : Zeigt die erweiterte Konfiguration des Befehls an (Protokollierungsmethode, Widget usw.).),
-   "Tester" : Wird zum Testen des Befehls verwendet,
-   Löschen (unterschreiben -) : ermöglicht das Löschen des Befehls.

# Tutoriel

## Virtueller Switch

Um einen virtuellen Wechsel vorzunehmen, müssen Sie zwei virtuelle Befehle wie diesen hinzufügen :

![virtual5](../images/virtual5.png)

Dann speichern Sie und dort fügt Jeedom automatisch den Befehl für virtuelle Informationen hinzu :

![virtual6](../images/virtual6.png)

Fügen Sie in der Bestellung "Aktion hinzu" ``On`` und ``Off``, Die Bestellung ``Etat`` (Dadurch kann Jeedom die Verknüpfung mit dem Statusbefehl herstellen).

Um ein schönes Widget zu haben, müssen Sie den Statusbefehl ausblenden :

![virtual7](../images/virtual7.png)

Weisen Sie den beiden Aktionsbefehlen ein Widget zu, das die Statusrückmeldung verwaltet, z. B. hier das Licht-Widget. Klicken Sie dazu auf das kleine gekerbte Rad vor der Steuerung ``On`` und auf der 2. Registerkarte auswählen ``light`` als Widget :

![virtual8](../images/virtual8.png)

Speichern Sie und machen Sie dasselbe für die Bestellung ``Off``. Und Sie erhalten ein nettes Widget, das beim Klicken den Status ändert :

![virtual9](../images/virtual9.png)

## Virtueller Schieberegler

Fügen Sie einen virtuellen Befehl wie diesen hinzu, um einen virtuellen Schieberegler zu erstellen :

![virtual12](../images/virtual12.png)

Wie zuvor nach der Sicherung erstellt Jeedom automatisch den Befehl info :

![virtual13](../images/virtual13.png)

Nach wie vor ist es ratsam, die Aktion mit dem Statusbefehl zu verknüpfen und auszublenden.

## Kippschalter

Auf diese Weise können Sie einen Schalter vom Typ umschalten. Dazu müssen Sie einen virtuellen Befehl dieses Typs erstellen :

![virtual14](../images/virtual14.png)

Anschließend speichern Sie, um den Statusbefehl anzuzeigen :

![virtual15](../images/virtual15.png)

Hier muss im Wert des Aktionsbefehls gesetzt werden ``not(\#[...][...][Etat]#)`` (Ersetzen Sie es durch Ihren eigenen Befehl) und verknüpfen Sie den Status mit dem Aktionsbefehl (Vorsicht, diesmal dürfen Sie den Statusbefehl nicht ausblenden). Sie müssen den Befehl info auch im binären Subtyp platzieren.

Es ist sehr einfach, eine Berechnung für mehrere Bestellungen durchzuführen ! Erstellen Sie einfach eine virtuelle Informationstypreihenfolge und geben Sie im Wertefeld Ihre Berechnungen ein. Der Ausdruckstester kann Ihnen bei diesem Schritt bei der Validierung helfen. Zum Beispiel, um 2 Temperaturen zu mitteln :

![virtual10](../images/virtual10.png)

Einige Punkte müssen richtig gemacht werden :

-   Wählen Sie den Subtyp entsprechend der Art der Informationen (hier Berechnung des Durchschnitts, so dass es sich um eine Zahl handelt),
-   Setzen Sie Klammern in die Berechnungen ein, damit Sie sicher sein können, dass das Ergebnis der Operation vorliegt,
-   Stellen Sie das Gerät gut auf,
-   Aktivieren Sie das Kontrollkästchen, um bei Bedarf zu protokollieren,



## Mehrfachbestellungen


Wir werden hier sehen, wie man eine Bestellung aufgibt, die 2 Lichter ausschaltet. Nichts könnte einfacher sein, erstellen Sie einfach eine virtuelle Bestellung und setzen Sie die 2 Bestellungen getrennt durch a ``&&`` :

![virtual11](../images/virtual11.png)

Hier muss der Subtyp des Befehls mit den Subtypen der gesteuerten Befehle identisch sein, daher müssen alle Befehle im Wertefeld denselben Subtyp haben (alle "anderen" oder alle "Schieberegler) "oder alle vom Typ Farbe).

## Virtuelles Statusfeedback

Bei Verwendung von Geräten ohne Statusrückmeldung und wenn dieses Gerät nur von Jeedom gesteuert wird, ist eine virtuelle Statusrückmeldung möglich. Dies erfordert das Erstellen einer virtuellen Datei, die die Aktionsbefehle ausführt (z: Ein & Aus) des Geräts, das über einen Infobefehl verfügt (das). Anschließend müssen Sie die Spalte Parameter für jeden Aktionsbefehl ausfüllen, indem Sie den Namen des Infobefehls (Status) auswählen und den Wert angeben, den er annehmen muss.

Wir können uns auch eine virtuelle vorstellen, die mehrere Lampen ein- und ausschaltet (durch && getrennte Aktionsbefehle) und somit den Status dieses allgemeinen Befehls hat.

# Zuweisen eines Werts per API

Es ist möglich, den Wert virtueller Informationen durch a zu ändern
API-Aufruf :

``http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#``

> **Notiz**
>
> Achten Sie darauf, nach \ ein / jeedom hinzuzufügen#IP\_JEEDOM\# falls erforderlich
