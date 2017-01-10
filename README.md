# Smart_Carport
Using a Raspberry Pi 1 Model B for playing musik and controlling a fan heater via time control.

Dieses Repo beinhaltet Anleitung und Daten, um aus einem alten Raspberry Pi 1 Modell B eine Zeitschaltuhr und MP3-Player zu machen (ohne Internetverbindung).

Im konkreten Anwendungsfall steht das originale Setup in einer Garage, die Zeitschaltuhr steuert einen Heizlüfter.

Es ist möglich, diese Anwendung auf einen neueren Pi zu porten, dann müssen aber die Pins aktualisiert werden. Pull requests sind gerne sehen.


# WICHTIG!!
Dieses Repo hier ist noch nicht fertig, die Anleitung noch nicht vollständig und die Dateien werden nach dem Setup vermutlich noch nicht funktionieren. Abwarten, bis es fertig ist!!

# Sicherheit
Das Projekt wurde mit minimaler Sicherheitsstufe umgesetzt, da es sich nur um ein Beispielsetup handelt. Es werden keine sensiblen Daten gespeichert, dennoch müssen Passwörter sicher gewählt werden.

Im Tutorial wird immer das Passwort "a" verwendet. Bei Verwendung des Beispielimages ist dies zu ändern!

# Timecontrol
Der Pi im originalen Setup startet in der Woche mehrfach aufgrund von Stromunterbrechungen neu.
Daher ist eine Timecontrol eingebaut, die bei jedem Hochfahren die Uhr neu stellt (mangels Hardwareuhr am Pi).
Die Zeiten sind:

Mo-Fr 04:00Uhr und 16:00Uhr
Sa 07Uhr
So 09Uhr

Wird dieses Verhalten nicht gebraucht, wird einfach nur der Crontabronjob auskommentiert.