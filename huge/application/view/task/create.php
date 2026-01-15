<div class="container">
    <h2>Neue Aufgabe erstellen</h2>
    <form method="post" action="">
        <label for="title">Titel:</label><br>
        <input type="text" id="title" name="title" maxlength="100" required><br><br>

        <label for="description">Beschreibung:</label><br>
        <textarea id="description" name="description" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" value="Speichern">
        <a href="<?php echo Config::get('URL'); ?>task/index">Zurück zur Übersicht</a>
    </form>
</div>