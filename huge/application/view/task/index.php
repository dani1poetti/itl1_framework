<div class="container">
    <h2>Aufgabenliste</h2>
    <a href="<?php echo Config::get('URL'); ?>task/create">Neue Aufgabe anlegen</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Titel</th>
            <th>Beschreibung</th>
            <th>Status</th>
            <th>Erstellt am</th>
            <th>Aktionen</th>
        </tr>
        <?php if (!empty($this->tasks)): foreach ($this->tasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task->title); ?></td>
                <td><?php echo nl2br(htmlspecialchars($task->description)); ?></td>
                <td style="font-weight:bold; color: #006699;">
                    <?php echo htmlspecialchars($task->status); ?>
                </td>
                <td><?php echo htmlspecialchars($task->created_at); ?></td>
                <td>
                    <!-- Status-Buttons -->
                    <form action="<?php echo Config::get('URL'); ?>task/updateStatus/<?php echo $task->id; ?>/offen" method="post" style="display:inline;">
                        <button type="submit">Offen</button>
                    </form>
                    <form action="<?php echo Config::get('URL'); ?>task/updateStatus/<?php echo $task->id; ?>/in_ausfuehrung" method="post" style="display:inline;">
                        <button type="submit">In Ausführung</button>
                    </form>
                    <form action="<?php echo Config::get('URL'); ?>task/updateStatus/<?php echo $task->id; ?>/fertig" method="post" style="display:inline;">
                        <button type="submit">Fertig</button>
                    </form>
                    <!-- Löschen-Button -->
                    <form action="<?php echo Config::get('URL'); ?>task/delete/<?php echo $task->id; ?>" method="post" style="display:inline;">
                        <button type="submit" onclick="return confirm('Aufgabe wirklich löschen?');">Löschen</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="5">Keine Aufgaben vorhanden.</td></tr>
        <?php endif; ?>
    </table>
</div>