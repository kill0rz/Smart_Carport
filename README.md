# Smart_Carport
Using a Raspberry Pi 1 Model B for playing musik and controlling a fan heater via time control.

Dieses Repo beinhaltet eine Anleitung und Daten, um aus einem alten Raspberry Pi 1 Modell B eine Zeitschaltuhr und MP3-Player zu machen (ohne Internetverbindung).

Im konkreten Anwendungsfall steht das originale Setup in einer Garage, die Zeitschaltuhr steuert einen Heizlüfter und eine Audio-Anlage via Musikupload.
Die Steuerung erfolgt über das Netzwerk (z.B. WLAN) über HTTP.

Es ist möglich, diese Anwendung auf einen neueren Pi zu porten, dann müssen aber die Pins aktualisiert werden. Pull requests sind gerne sehen.

# Sicherheit
Das Projekt wurde mit minimaler Sicherheitsstufe umgesetzt, da es sich nur um ein Beispielsetup handelt. Es werden keine sensiblen Daten gespeichert, dennoch müssen Passwörter sicher gewählt werden.

Im Tutorial wird immer das Passwort "a" verwendet.

# Timecontrol
Der Pi im originalen Setup startet in der Woche mehrfach aufgrund von Stromunterbrechungen neu.
Daher ist eine Timecontrol eingebaut, die bei jedem Hochfahren die Uhr neu stellt (mangels Hardwareuhr am Pi).
Die Zeiten sind:

+ Mo-Fr 04:00Uhr und 16:00Uhr
+ Sa 07Uhr
+ So 09Uhr

Wird dieses Verhalten nicht gebraucht, wird einfach nur der Cronjob auskommentiert.
Die Zeiten können in der Datei /var/www/html/timecontrol/timecontrol.php angepasst werden.

# ToDo
+ Temperatursensor und Feuchtigkeitssensor implementieren.
+ Button implementieren
+ Bilder machen
    * Pinbelegung angeben