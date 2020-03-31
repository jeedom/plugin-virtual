# Präsentation

Das virtuellle Plugin ermöglicht die Erstellung virtuelller Geräte
und ihre Eigenschaften.

Wir werden ein Gerät benennen, das von diesem Plugin erstellt wurde : peripher
virtuell.

Ein virtuellles Gerät kann für die folgenden Anforderungen erstellt werden :

-   Konsolidieren Sie Informationen oder Aktionen von einem einzigen Gerät
    mehrere physische / virtuellle Geräte;

-   Erstellen Sie ein Gerät, das von einer Quelle außerhalb von Jeedom gespeist wird
    (Zibase, IPX800…);

-   doppelte Ausrüstung, um sie beispielsweise in zwei Teile zu teilen;

-   eine Berechnung für mehrere Gerätewerte durchführen;

-   mehrere Aktionen ausführen (Makro).




# Konfiguration

Das Plugin benötigt keine Konfiguration, Sie müssen es nur aktivieren :

![virtual1](../images/virtual1.png)




# Gerätekonfiguration

Auf die Konfiguration der virtuelllen Geräte kann über das zugegriffen werden
Plugin-Menü :

![virtual2](../images/virtual2.png)

So sieht die virtuellle Plugin-Seite aus (hier mit bereits einem
Ausrüstung) :

![virtual3](../images/virtual3.png)

So sieht die Konfigurationsseite eines virtuelllen Geräts aus
:

![virtual4](../images/virtual4.png)

> **Spitze**
>
> Setzen Sie die Maus wie an vielen Stellen auf Jeedom ganz links
> ruft ein Schnellzugriffsmenü auf (Sie können
> von deinem Profil immer sichtbar lassen).

Hier finden Sie die gesamte Konfiguration Ihrer Geräte :

-   **Name des virtuelllen Geräts** : Name Ihrer virtuelllen Ausrüstung,

-   **Übergeordnetes Objekt** : gibt das übergeordnete Objekt an, zu dem es gehört
    Ausrüstung,

-   **Kategorie** : Gerätekategorien (es kann gehören
    mehrere Kategorien),

-   **Aktivieren** : macht Ihre Ausrüstung aktiv,

-   **Sichtbar** : macht es auf dem Dashboard sichtbar,

-   **Kommentar** : ermöglicht es Ihnen zu kommentieren
    Ausrüstung.

Oben rechts haben Sie Zugriff auf 4 Schaltflächen :

-   **Ausdruck** : Der Ausdruckstester ist identisch mit dem der Szenarien
    um die Entwicklung einiger virtuelller zu erleichtern

-   **Ausrüstung importieren** : ermöglicht das automatische Duplizieren von a
    vorhandene Geräte in einer virtuelllen (spart Zeit für
    Split Ausrüstung in 2 zum Beispiel),

-   **Duplikat** : dupliziert aktuelle Geräte,

-   **Fortgeschrittene (gekerbte Räder)** : zeigt Optionen an
    Gerätefortschritte (allen Jeedom-Plugins gemeinsam).

Nachfolgend finden Sie die Liste der Bestellungen :

-   Der im Dashboard angezeigte Name,

-   Typ und Subtyp,

-   der Wert : ermöglicht es, den Wert der Bestellung entsprechend anzugeben
    ein anderer Befehl, eine Taste (wenn Sie einen Wechsel vornehmen
    ), eine Berechnung usw..

-   "Statusrückmeldungswert "und" Dauer vor Statusrückmeldung" : erlaubt
    Jeedom darauf hinzuweisen, dass nach einer Änderung der Informationen
    Der Wert muss nach der Änderung auf Y, X min zurückkehren. Beispiel : IN
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

-   "Test" : Wird zum Testen des Befehls verwendet,

-   löschen (unterschreiben -) : ermöglicht das Löschen des Befehls.




# Tutorial

## Virtueller Switch

Um einen virtuelllen Switch durchzuführen, müssen Sie 2 Befehle hinzufügen
virtuelll so :

![virtual5](../images/virtual5.png)

Dann speichern Sie und dort fügt Jeedom automatisch das hinzu
virtuellle Informationsreihenfolge :

![virtual6](../images/virtual6.png)

Ajoutez IN les commandes "action" `On` et `Off`, la commande `Etat`
(Dadurch kann Jeedom die Verknüpfung mit dem Statusbefehl herstellen.).

Um ein schönes Widget zu haben, müssen Sie den Statusbefehl ausblenden :

![virtual7](../images/virtual7.png)

Weisen Sie den beiden Aktionsbefehlen ein Widget zu, das die Statusrückmeldung verwaltet,
Zum Beispiel hier das Licht-Widget. Klicken Sie dazu auf das kleine
Zahnrad vor dem Befehl "Ein" und in der 2. Registerkarte
Wählen Sie "Licht" als Widget :

![virtual8](../images/virtual8.png)

Enregistrez et faites de même pour la commande `Off`. Und du wirst bekommen
Ein nettes Widget, das beim Klicken den Status ändert :

![virtual9](../images/virtual9.png)




## Virtueller Schieberegler

Fügen Sie einen virtuelllen Befehl hinzu, um einen virtuelllen Schieberegler zu erstellen
so :

![virtual12](../images/virtual12.png)

Wie zuvor nach dem Backup wird Jeedom automatisch
Erstellen Sie den Befehl info :

![virtual13](../images/virtual13.png)

Und wie zuvor ist es ratsam, die Aktion mit dem Befehl zu verknüpfen
und verstecke es.




## Kippschalter

So machen Sie einen Kippschalter.
Erstellen Sie eine solche virtuellle Bestellung :

![virtual14](../images/virtual14.png)

Anschließend speichern Sie, um den Statusbefehl anzuzeigen :

![virtual15](../images/virtual15.png)

Hier muss im Wert des Aktionsbefehls gesetzt werden
`not(\#[...][...][Etat]#)` (bien remplacer par votre propre commande) et
Verknüpfen Sie den Status mit dem Aktionsbefehl (seien Sie vorsichtig, verstecken Sie den nicht
diesmal Staatsbefehl). Sie müssen auch den Befehl info in platzieren
binärer Subtyp.

Berechnung

Es ist sehr einfach, eine Berechnung für mehrere Bestellungen durchzuführen ! Er
Erstellen Sie einfach einen Befehl für den virtuelllen Informationstyp und in der
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
Lichter. Nichts ist einfacher, erstellen Sie einfach eine virtuellle Bestellung
et de mettre les 2 commandes séparées par un `&&` :

![virtual11](../images/virtual11.png)

Hier muss der Befehlssubtyp mit dem identisch sein
Untertypen der gesteuerten Befehle, daher alle Befehle in der
Wertefelder müssen denselben Untertyp haben (alle "anderen" oder alle
"Schieberegler "oder alle Farbtypen).




## Virtuelles Statusfeedback

Bei Verwendung von Geräten ohne Rückgabe
Status und wenn dieses Gerät nur von Jeedom bestellt wird, ist es
möglich, ein virtuellles Feedback zu haben. Dies erfordert das Erstellen eines
virtuelll, das Aktionsbefehle entgegennimmt (z: Ein & Aus) der Ausrüstung
und wer hat einen Infobefehl (Status). Dann müssen Sie die ausfüllen
Parameterspalte für jeden Aktionsbefehl durch Auswahl des Namens
des Info-Befehls (Status) und Angabe des Wertes, den er annehmen soll.

Wir können uns auch eine virtuellle vorstellen, die mehrere Lampen ein- und ausschaltet
(Aktionsbefehle durch && getrennt) und haben daher einen Status davon
allgemeine Ordnung.




# Zuweisen eines Werts per API

Es ist möglich, den Wert virtuelller Informationen durch a zu ändern
API-Aufruf :

    http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&type=virtual&type=virtual&id=#ID#&value=#value#

> **Notiz**
>
> Achten Sie darauf, bei Bedarf nach / #IP \ _JEEDOM \ # ein / jeedom hinzuzufügen
