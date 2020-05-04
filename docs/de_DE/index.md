# Präsentation

Das virtuelle Plugin ermöglicht die Erstellung virtueller Geräte
und ihre Eigenschaften.

Wir werden ein Gerät benennen, das von diesem Plugin erstellt wurde : peripher
virtuel.

Ein virtuelles Gerät kann für die folgenden Anforderungen erstellt werden :

-   Konsolidieren Sie Informationen oder Aktionen von einem einzigen Gerät
    mehrere physische / virtuelle Geräte;

-   Erstellen Sie ein Gerät, das von einer Quelle außerhalb von Jeedom gespeist wird
    (Zibase, IPX800…);

-   doppelte Ausrüstung, um sie beispielsweise in zwei Teile zu teilen;

-   eine Berechnung für mehrere Gerätewerte durchführen;

-   mehrere Aktionen ausführen (Makro).




# Configuration

Das Plugin benötigt keine Konfiguration, Sie müssen es nur aktivieren :

![virtual1](../images/virtual1.png)




# Gerätekonfiguration

Auf die Konfiguration der virtuellen Geräte kann über das zugegriffen werden
Plugin-Menü :

![virtual2](../images/virtual2.png)

So sieht die virtuelle Plugin-Seite aus (hier mit bereits einem
Ausrüstung) :

![virtual3](../images/virtual3.png)

So sieht die Konfigurationsseite eines virtuellen Geräts aus
:

![virtual4](../images/virtual4.png)

> **Tip**
>
> Setzen Sie die Maus wie an vielen Stellen auf Jeedom ganz links
> ruft ein Schnellzugriffsmenü auf (Sie können
> von deinem Profil immer sichtbar lassen).

Hier finden Sie die gesamte Konfiguration Ihrer Geräte :

-   **Name des virtuellen Geräts** : Name Ihrer virtuellen Ausrüstung,

-   **Übergeordnetes Objekt** : gibt das übergeordnete Objekt an, zu dem es gehört
    Ausrüstung,

-   **Kategorie** : Gerätekategorien (es kann gehören
    mehrere Kategorien),

-   **Activer** : macht Ihre Ausrüstung aktiv,

-   **Visible** : macht es auf dem Dashboard sichtbar,

-   **Commentaire** : ermöglicht es Ihnen zu kommentieren
    Ausrüstung.

Oben rechts haben Sie Zugriff auf 4 Schaltflächen :

-   **Expression** : Der Ausdruckstester ist identisch mit dem der Szenarien
    um die Entwicklung einiger virtueller zu erleichtern

-   **Ausrüstung importieren** : ermöglicht das automatische Duplizieren von a
    vorhandene Geräte in einer virtuellen (spart Zeit für
    Split Ausrüstung in 2 zum Beispiel),

-   **Dupliquer** : dupliziert aktuelle Geräte,

-   **Fortgeschrittene (gekerbte Räder)** : zeigt Optionen an
    Gerätefortschritte (allen Jeedom-Plugins gemeinsam).

Nachfolgend finden Sie die Liste der Bestellungen :

-   Der im Dashboard angezeigte Name,

-   Typ und Subtyp,

-   der Wert : ermöglicht es, den Wert der Bestellung entsprechend anzugeben
    ein anderer Befehl, eine Taste (wenn Sie einen Wechsel vornehmen
    ), eine Berechnung usw..

-   "Statusrückmeldungswert "und" Dauer vor Statusrückmeldung" : permet
    Jeedom darauf hinzuweisen, dass nach einer Änderung der Informationen
    Der Wert muss nach der Änderung auf Y, X min zurückkehren. Beispiel : dans
    der Fall eines Anwesenheitsdetektors, der nur während a emittiert
    Anwesenheitserkennung ist es nützlich, zum Beispiel 0 zu setzen
    Wert und 4 in der Dauer, so dass 4 min nach Bewegungserkennung
    (und wenn es seitdem keine Neuigkeiten mehr gibt) Jeedom setzt das zurück
    Informationswert bei 0 (keine Bewegung mehr erkannt),

-   Unit : Dateneinheit (kann leer sein),

-   Chronik : ermöglicht das Historisieren der Daten,

-   Anzeige : ermöglicht die Anzeige der Daten im Dashboard,

-   Ereignis : Bei RFXcom muss diese Box immer sein
    aktiviert, da Sie kein RFXcom-Modul abfragen können,

-   min / max : Datengrenzen (können leer sein),

-   erweiterte Konfiguration (kleine gekerbte Räder) : Anzeigen
    Erweiterte Konfiguration des Befehls (Historisierungsmethode,
    Widget usw.),

-   "Tester" : Wird zum Testen des Befehls verwendet,

-   löschen (unterschreiben -) : ermöglicht das Löschen des Befehls.




# Tutoriel

## Virtueller Switch

Um einen virtuellen Switch durchzuführen, müssen Sie 2 Befehle hinzufügen
virtuell so :

![virtual5](../images/virtual5.png)

Dann speichern Sie und dort fügt Jeedom automatisch das hinzu
virtuelle Informationsreihenfolge :

![virtual6](../images/virtual6.png)

Fügen Sie in den "Aktions" -Befehlen "Ein" und "Aus" den Befehl "Status" hinzu
(Dadurch kann Jeedom die Verknüpfung mit dem Statusbefehl herstellen.).

Um ein schönes Widget zu haben, müssen Sie den Statusbefehl ausblenden :

![virtual7](../images/virtual7.png)

Weisen Sie den beiden Aktionsbefehlen ein Widget zu, das die Statusrückmeldung verwaltet,
Zum Beispiel hier das Licht-Widget. Klicken Sie dazu auf das kleine
Zahnrad vor dem Befehl "Ein" und in der 2. Registerkarte
Wählen Sie "Licht" als Widget :

![virtual8](../images/virtual8.png)

Speichern Sie und machen Sie dasselbe für den Befehl "Aus". Und du wirst bekommen
Ein nettes Widget, das beim Klicken den Status ändert :

![virtual9](../images/virtual9.png)




## Virtueller Schieberegler

Fügen Sie einen virtuellen Befehl hinzu, um einen virtuellen Schieberegler zu erstellen
so :

![virtual12](../images/virtual12.png)

Wie zuvor nach dem Backup wird Jeedom automatisch
Erstellen Sie den Befehl info :

![virtual13](../images/virtual13.png)

Und wie zuvor ist es ratsam, die Aktion mit dem Befehl zu verknüpfen
und verstecke es.




## Kippschalter

So machen Sie einen Kippschalter.
Erstellen Sie eine solche virtuelle Bestellung :

![virtual14](../images/virtual14.png)

Anschließend speichern Sie, um den Statusbefehl anzuzeigen :

![virtual15](../images/virtual15.png)

Hier muss im Wert des Aktionsbefehls gesetzt werden
`not (\# [...] [...] [State] #)` (durch eigenen Befehl ersetzen) und
Verknüpfen Sie den Status mit dem Aktionsbefehl (seien Sie vorsichtig, verstecken Sie den nicht
diesmal Staatsbefehl). Sie müssen auch den Befehl info in platzieren
binärer Subtyp.

Calcul

Es ist sehr einfach, eine Berechnung für mehrere Bestellungen durchzuführen ! Il
Erstellen Sie einfach einen Befehl für den virtuellen Informationstyp und in der
Wertfelder setzen Ihre Berechnungen. Der Ausdruckstester kann Ihnen helfen
zu diesem Zeitpunkt zu validieren. Zum Beispiel zu durchschnittlich
2 Temperaturen :

![virtual10](../images/virtual10.png)

Einige Punkte müssen richtig gemacht werden :

-   Wählen Sie den Subtyp entsprechend der Art der Informationen (hier
    Mittelwertbildung, also eine Zahl),

-   Setzen Sie Klammern in die Berechnungen ein, damit Sie sicher sein können, dass
    Ergebnis der Operation,

-   Stellen Sie das Gerät gut auf,

-   Aktivieren Sie das Kontrollkästchen, um bei Bedarf zu protokollieren,



## Mehrfachbestellungen


Wir werden hier sehen, wie Sie eine Bestellung aufgeben, die sich ausschaltet 2
Lichter. Nichts ist einfacher, erstellen Sie einfach eine virtuelle Bestellung
und setzen Sie die 2 Befehle durch ein "&&" getrennt :

![virtual11](../images/virtual11.png)

Hier muss der Befehlssubtyp mit dem identisch sein
Untertypen der gesteuerten Befehle, daher alle Befehle in der
Wertefelder müssen denselben Untertyp haben (alle "anderen" oder alle
"Schieberegler "oder alle Farbtypen).




## Virtuelles Statusfeedback

Bei Verwendung von Geräten ohne Rückgabe
Status und wenn dieses Gerät nur von Jeedom bestellt wird, ist es
möglich, ein virtuelles Feedback zu haben. Dies erfordert das Erstellen eines
virtuell, das Aktionsbefehle entgegennimmt (z: Ein & Aus) der Ausrüstung
und wer hat einen Infobefehl (Status). Dann müssen Sie die ausfüllen
Parameterspalte für jeden Aktionsbefehl durch Auswahl des Namens
des Info-Befehls (Status) und Angabe des Wertes, den er annehmen soll.

Wir können uns auch eine virtuelle vorstellen, die mehrere Lampen ein- und ausschaltet
(Aktionsbefehle durch && getrennt) und haben daher einen Status davon
allgemeine Ordnung.




# Zuweisen eines Werts per API

Es ist möglich, den Wert virtueller Informationen durch a zu ändern
API-Aufruf :

    http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#

> **Note**
>
> Achten Sie darauf, bei Bedarf nach / #IP\_JEEDOM \# ein / jeedom hinzuzufügen
