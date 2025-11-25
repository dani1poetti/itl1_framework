# In-Betriebnahme des Frameworks Huge

Author: Daniel Pöttler <br>
LBS Eibiswald | 3aAPC

5 Übung - Framwork Huge<br>

## Framework Überblick

Heute mussten/sollten wir das Framework Huge zum Laufen bekommen,
ich habe dazu die zip. des Framworkes bekommen (Eduvidual) und konnte dies
einmal in meinen htddocs Ordner verschieben. Danach mit Compuser die fehlenden
Dependencies geholt. Jetzt noch die Datenbank anlegen und es hat soweit schon
funktioniert. <br>
Ich habe dann noch das Bild und den footer entfernt und konnte mich
schließlich dann auch erfolgreich anmelden. <br>
Fragen sind unten beantwortet


Screenshot der fertigen Oberfläche
[![Screen Shot][img1]](https://example.com)


## Fragen

### Bausteine des Frameworks
- **Config** – Einstellungen (DB, Pfade)
- **Model** – Daten & Datenbanklogik
- **Controller** – verarbeitet Requests
- **Core** – Routing & Basisfunktionen
- **View** – Darstellung / HTML
- **Public** – öffentlich zugängliche Dateien (CSS, JS, Bilder, index.php)

### Wie sieht die Datenbank aus?
Mehrere Tabellen, strukturiert nach den Models  
(z. B. `users`, `sessions`, `articles`, …).


### Wie sieht der Konstruktor in PHP Klassen aus?
```php
public function __construct() {}
```

### Wozu dient die Variable "$this"
Verweist im Objekt auf dessen eigene Eigenschaften und Methoden.

### Vorteile von OOP in php
- Strukturierter und modular
- Wiederverwendbar
- Besser wartbar und erweiterbar
- vieles mehr -> wie generell OOP

### Welche Datenkapselungsmethoden gibt es in php?
public, private und protected

### Wie sehen abstrakte Klassen in php aus?
```php
abstract class BaseClass {
    abstract public function run();
}
```

[img1]: images/img1.png