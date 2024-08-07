# Virtuelles Plugin

Das Plugin **Virtuell** ermöglicht die Erstellung virtueller Geräte und virtueller Steuerungen.

In dieser Dokumentation benennen wir ein von diesem Plugin erstelltes Gerät als a **virtuelle Ausrüstung**.

Virtuelle Ausrüstung kann für die folgenden Bedürfnisse nützlich sein :

- Konsolidieren Sie in einem einzigen Gerät die Informationen und / oder Aktionen mehrerer physischer / virtueller Geräte,
- Erstellen Sie Geräte, die von einer externen Quelle von Jeedom betrieben werden *(Zibase, IPX800 usw.)*,
- Duplizieren Sie die Ausrüstung, um sie beispielsweise in 2 aufzuteilen,
- eine Berechnung mit mehreren Gerätewerten durchführen,
- mehrere Aktionen ausführen *(macro)*.

>**WICHTIG**
>
>Virtuals sollten nicht missbraucht werden, da sie zu allgemeinem Überkonsum führen *(CPU/Speicher/Swap/Festplatte)*, längere Latenzzeiten, Abnutzung der SD-Karte etc ! Virtuals sind Werkzeuge, die nur bei Bedarf sparsam eingesetzt werden sollten.

# Configuration

## Plugin-Konfiguration

Dieses Plugin erfordert keine spezielle Konfiguration und muss nach der Installation einfach aktiviert werden.

## Jeedom-Monitor erstellen/aktualisieren

Schaltfläche, mit der Sie Jeedom-Internetgeräte erstellen können, die Ihnen interne Informationen zu Jeedom liefern : 

- für jedes Plugin, das einen Daemon hat, einen Befehl zum Status des Daemons
- für jedes Plugin, das einen Daemon hat, einen Befehl zum Starten des Daemons
- für jedes Plugin, das einen Daemon hat, einen Befehl zum Stoppen des Daemons
- Anzahl der verfügbaren Updates
- Anzahl der Nachrichten im Nachrichtencenter
- Version von Jeedom
- Erstelle eine Sicherung
- Starten Sie das Update von Jeedom (und Plugins))


## Gerätekonfiguration

Virtuelle Geräte sind über das Menü zugänglich **Plugins → Programmierung → Virtuell**.

Klicken Sie auf ein virtuelles Gerät, um auf seine Konfigurationsseite zuzugreifen :

- **Virtueller Name** : Name Ihrer virtuellen Ausrüstung.
- **Übergeordnetes Objekt** : Gibt das übergeordnete Objekt an, zu dem das Gerät gehört,
- **Kategorie** : Ausstattungskategorien *(es kann mehreren Kategorien angehören)*,
- **Aktivieren** : ermöglicht es, das Gerät aktiv zu machen,
- **Sichtbar** : ermöglicht es, die Ausrüstung auf dem Armaturenbrett sichtbar zu machen.
- **Selbstaktualisierung** : Aktualisierungshäufigkeit der Infobefehle *(per cron - ein Assistent ist verfügbar, wenn Sie auf das Fragezeichen am Ende der Zeile klicken)*.
- **Rücksende-URL** : es ist möglich, den Wert einer virtuellen Information per API zu ändern (``http://#IP_JEEDOM#/core/api/jeeApi.php?apikey=#APIKEY_VIRTUEL#&plugin=virtual&type=event&id=#CMD_ID#&value=#VALUE#``)
- **Virtuelle Beschreibung** : ermöglicht es Ihnen, die virtuelle Ausrüstung zu beschreiben.

>**TRICK**
>
>Bezüglich ich'**Rücksende-URL**, unbedingt hinzufügen ``/jeedom`` nach ``#IP_JEEDOM#`` falls erforderlich.

Oben rechts haben Sie Zugriff auf 3 Schaltflächen zusätzlich zu denen, die für alle Plugins gelten :

- **Ausdruck** : öffnet den Ausdruckstester, um die Implementierung bestimmter virtueller zu erleichtern.
- **Vorlage** : ermöglicht es Ihnen, sehr schnell ein virtuelles Gerät zu erstellen, indem Sie eine Vorlage auswählen.
- **Ausrüstung importieren** : Dupliziert vorhandene Geräte automatisch als virtuelle Geräte *(um Zeit zu sparen, um beispielsweise ein Gerät in 2 aufzuteilen)*.

# Commandes

Durch Klicken auf die Registerkarte **Aufträge**, Sie finden die Liste der virtuellen Bedienelemente :

- **ICH WÜRDE** : die Bestell-Identifikationsnummer.
- **Name** :
    - **Bestellname** : Der im Dashboard angezeigte Name.
    - **Symbol** : ggf. das Symbol für die Bestellung.
    - **Zugehöriger Info-Befehl** *(actions)* : Wird verwendet, um den Statusinfo-Befehl einzugeben, der mit dem Aktionsbefehl verknüpft ist.
- **Typ** : Typ und Subtyp,
- **Wert** : ermöglicht es, den Wert des Befehls gemäß einem anderen Befehl anzugeben, einem Schlüssel *(wenn wir einen virtuellen Schalter machen)*, eine Rechnung usw...
- **Einstellungen** :
    - **Statusrückgabewert** & **Dauer vor Statusrückgabe** *(infos)* : ermöglicht Ihnen anzugeben, dass der Wert zu zurückkehren muss ``Y``, ``X minutes`` nach einer Änderung. Bei einem Bewegungsmelder, der nur bei Erkennung emittiert, ist es beispielsweise sinnvoll, ``0`` im Wert und ``4`` in der Dauer so, dass 4 Minuten nach einer Bewegungserkennung der Wert des Befehls auf zurückkehrt ``0`` *(wenn seither keine weiteren Erkennungen stattgefunden haben)*.
    - **Info zum Aktualisieren** & **Infowert** *(actions)* : ermöglicht es Ihnen, einen Info-Befehl anzugeben, der während der Ausführung des Befehls aktualisiert werden soll, und den ihm zuzuweisenden Wert.
- **Optionen** :
  - **Anzeige** : ermöglicht Ihnen, die Bestellung auf dem Dashboard anzuzeigen.
  - **Chronik** : ermöglicht es, die Bestellung zu protokollieren.
  - **Umkehren**: ermöglicht es, den Wert des Befehls zu invertieren *(nur Info / Binär)*.
  - **Min / max** : Sollwertgrenzen *(kann leer sein - min:0/max:100 standardmäßig)*.
  - **Unit** : Bestellwerteinheit *(kann leer sein)*.
  - **Liste von Werten** : Liste von ``valeur|texte`` getrennt durch a ``; (point-virgule)`` *(Nur Aktion / Liste)*.
- **Aktionen** :
    - **Erweiterte Konfiguration** *(Zahnräder)* : Wird verwendet, um die erweiterte Konfiguration des Befehls anzuzeigen *(Historisierungsmethode, Widget usw...)*.
    - **Test** : Wird zum Testen des Befehls verwendet.
    - **Löschen** *(Unterschrift -)* : ermöglicht das Löschen des Befehls.

>**INFORMATION**
>
>Jedes virtuelle Gerät hat einen Befehl **Aktualisierung** wodurch die Aktualisierung aller Info-Befehle erzwungen werden kann.

# Virtuelle Beispiele

## Virtueller Switch

Um einen virtuellen Wechsel vorzunehmen, müssen Sie 2 virtuelle Aktionen wie diese hinzufügen :

![virtual5](../images/virtual5.png)

Dann speichern Sie und dort fügt Jeedom automatisch den Befehl für virtuelle Informationen hinzu :

![virtual6](../images/virtual6.png)

Fügen Sie in der Bestellung "Aktion hinzu" ``On`` und ``Off``, Die Bestellung ``Etat`` (Dadurch kann Jeedom die Verknüpfung mit dem Statusbefehl herstellen).

Um ein schönes Widget zu haben, musst du den Statusbefehl ausblenden :

![virtual7](../images/virtual7.png)

Weisen Sie den beiden Aktionsbefehlen ein Widget zu, das die Statusrückmeldung verwaltet, z. B. hier das Licht-Widget. Klicken Sie dazu auf das kleine gekerbte Rad vor der Steuerung ``On`` und auf der 2. Registerkarte auswählen ``light`` als Widget :

![virtual8](../images/virtual8.png)

Speichern Sie und machen Sie dasselbe für die Bestellung ``Off``. Und Sie erhalten ein nettes Widget, das beim Klicken den Status ändert :

![virtual9](../images/virtual9.png)

## Virtueller Schieberegler

Um einen virtuellen Schieberegler zu erstellen, müssen Sie eine virtuelle Aktion wie diese hinzufügen :

![virtual12](../images/virtual12.png)

Wie zuvor nach der Sicherung erstellt Jeedom automatisch den Befehl info :

![virtual13](../images/virtual13.png)

Nach wie vor ist es ratsam, die Aktion mit dem Statusbefehl zu verknüpfen und auszublenden.

## Kippschalter

So erstellen Sie einen Kippschalter (oder Druckknopf), dafür müssen Sie eine virtuelle Aktion dieses Typs erstellen :

![virtual14](../images/virtual14.png)

Anschließend speichern Sie, um den Statusbefehl anzuzeigen :

![virtual15](../images/virtual15.png)

Hier muss im Wert des Aktionsbefehls gesetzt werden ``not(#[...][...][Etat]#)`` *(durch Ihre eigene Bestellung ersetzen)* und verknüpfen Sie den Zustand mit dem Aktionsbefehl (Achtung, Sie dürfen den Zustandsbefehl diesmal nicht ausblenden). Sie müssen den Befehl info auch im binären Subtyp platzieren.

## Mehrfachbestellungen

Es ist sehr einfach, eine Berechnung für mehrere Bestellungen durchzuführen ! Erstellen Sie einfach einen virtuellen Befehl vom Typ ``info/Numérique`` und geben Sie in das Wertefeld Ihre Berechnungen ein. Der Ausdruckstester kann Ihnen bei diesem Schritt bei der Validierung helfen. Zum Beispiel, um 2 Temperaturen zu mitteln :

![virtual10](../images/virtual10.png)

Einige Punkte müssen richtig gemacht werden :

- Wählen Sie den Subtyp entsprechend der Art der Informationen (hier Berechnung des Durchschnitts, so dass es sich um eine Zahl handelt),
- Setzen Sie Klammern in die Berechnungen ein, damit Sie sicher sein können, dass das Ergebnis der Operation vorliegt,
- Stellen Sie das Gerät gut auf,
- Aktivieren Sie das Kontrollkästchen, um bei Bedarf zu protokollieren.

Wir werden hier sehen, wie man eine Bestellung aufgibt, die 2 Lichter ausschaltet. Nichts könnte einfacher sein, erstellen Sie einfach einen virtuellen Befehl vom Typ ``action/Défaut`` und geben Sie die beiden Befehle durch a getrennt ein ``&&`` :

![virtual11](../images/virtual11.png)

Es ist zwingend erforderlich, dass der Untertyp des Befehls mit den Untertypen der gesteuerten Befehle übereinstimmt. Alle Befehle im Wertefeld müssen daher den gleichen Subtyp haben *(alle "andere" oder alle "Schieberegler" oder alle vom Typ "Farbe" usw...)*.

## Virtuelles Statusfeedback

Bei Verwendung von Geräten ohne Statusrückmeldung und wenn dieses Gerät nur von Jeedom gesteuert wird, ist eine virtuelle Statusrückmeldung möglich. Dies erfordert das Erstellen einer virtuellen Datei, die die Aktionsbefehle ausführt (z: Ein & Aus) des Geräts, das über einen Infobefehl verfügt (das). Anschließend müssen Sie die Spalte Parameter für jeden Aktionsbefehl ausfüllen, indem Sie den Namen des Infobefehls (Status) auswählen und den Wert angeben, den er annehmen muss.

Wir können uns auch eine virtuelle vorstellen, die mehrere Lampen ein- und ausschaltet (durch && getrennte Aktionsbefehle) und somit den Status dieses allgemeinen Befehls hat.
