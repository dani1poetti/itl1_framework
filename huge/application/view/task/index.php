<!-- TEST-NOTIZ: Modernisierung aktiv -->
<style>
    .tasks-container { max-width: 950px; background: #fff; border-radius: 10px; box-shadow: 0 4px 16px #0001; padding: 2em; margin: 2em auto; }
    .tasks-table { width: 100%; border-collapse: separate; border-spacing: 0; margin-bottom: 1em; }
    .tasks-table th, .tasks-table td { padding: 0.75em 1em; text-align: left; }
    .tasks-table th { background: #f7f8fa; color: #37517e; }
    .tasks-table tr { transition: background 0.18s; }
    .tasks-table tr:hover { background: #eaf2ff; }
    .status-label { padding: 0.25em 0.8em; border-radius: 0.7em; font-size: 0.96em; color: #fff; display: inline-block; font-weight:bold; }
    .status-offen { background: #0d6efd; }
    .status-in_ausfuehrung { background: #ffc107; color: #222; }
    .status-fertig { background: #198754; }
    .task-btn { border: none; border-radius: 5px; }
    .btn-status { margin-right:4px; padding: 2px 10px; font-size: 0.87em; }
    .btn-offen { background: #0d6efd; color: #fff; }
    .btn-in_ausfuehrung { background: #ffc107; color: #222; }
    .btn-fertig { background: #198754; color: #fff; }
    .btn-delete { background: #d63333; color: #fff; }
    .filter-row { margin: 1.3em 0 1.8em 0; display: flex; align-items: center; gap: 1em; }
    .filter-label { font-weight: 500; color: #444; margin-right: 0.6em; }
    .filter-select { padding: 3px 10px; font-size: 1em; border-radius:4px; border: 1px solid #bbb; }
    a.create-link { display: inline-block; margin-bottom: 18px; background: #198754; color: #fff; font-weight: 500; padding: 8px 23px; border-radius: 6px; text-decoration: none; transition: background .15s; }
    a.create-link:hover { background: #145334; }
</style>

<div class="tasks-container">
    <h2 style="margin-top:0; color: #37517e;">Aufgabenliste</h2>
    <a href="<?php echo Config::get('URL'); ?>task/create" class="create-link">Neue Aufgabe anlegen</a>
    <!-- Filter Dropdown -->
    <form method="get" class="filter-row">
        <span class="filter-label">Status filtern:</span>
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Alle</option>
            <option value="offen" <?php if(!empty($_GET['status']) && $_GET['status']==='offen') echo 'selected'; ?>>Offen</option>
            <option value="in_ausfuehrung" <?php if(!empty($_GET['status']) && $_GET['status']==='in_ausfuehrung') echo 'selected'; ?>>In Ausführung</option>
            <option value="fertig" <?php if(!empty($_GET['status']) && $_GET['status']==='fertig') echo 'selected'; ?>>Fertig</option>
        </select>
    </form>
    <table class="tasks-table">
        <tr>
            <th>Titel</th>
            <th>Beschreibung</th>
            <th>Status</th>
            <th>Erstellt am</th>
            <th>Aktionen</th>
        </tr>
        <?php
        $tasks = $this->tasks;
        if (!empty($_GET['status'])) {
            $tasks = array_filter($tasks, function($task){
                return $task->status == $_GET['status'];
            });
        }
        if (!empty($tasks)): foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task->title); ?></td>
                <td><?php echo nl2br(htmlspecialchars($task->description)); ?></td>
                <td>
                    <?php
                    $statusClass = 'status-label ';
                    if($task->status==='offen') $statusClass .= 'status-offen';
                    elseif($task->status==='in_ausfuehrung') $statusClass .= 'status-in_ausfuehrung';
                    elseif($task->status==='fertig') $statusClass .= 'status-fertig';
                    else $statusClass .= 'status-offen';
                    ?>
                    <span class="<?php echo $statusClass; ?>">
                        <?php
                        if($task->status==='offen') echo 'Offen';
                        elseif($task->status==='in_ausfuehrung') echo 'In Ausführung';
                        elseif($task->status==='fertig') echo 'Fertig';
                        else echo htmlspecialchars($task->status);
                        ?>
                    </span>
                </td>
                <td><?php echo htmlspecialchars($task->created_at); ?></td>
                <td>
                    <form action="<?php echo Config::get('URL'); ?>task/updateStatus/<?php echo $task->id; ?>/offen" method="post" style="display:inline;">
                        <button class="task-btn btn-status btn-offen" type="submit">Offen</button>
                    </form>
                    <form action="<?php echo Config::get('URL'); ?>task/updateStatus/<?php echo $task->id; ?>/in_ausfuehrung" method="post" style="display:inline;">
                        <button class="task-btn btn-status btn-in_ausfuehrung" type="submit">In Ausführung</button>
                    </form>
                    <form action="<?php echo Config::get('URL'); ?>task/updateStatus/<?php echo $task->id; ?>/fertig" method="post" style="display:inline;">
                        <button class="task-btn btn-status btn-fertig" type="submit">Fertig</button>
                    </form>
                    <form action="<?php echo Config::get('URL'); ?>task/delete/<?php echo $task->id; ?>" method="post" style="display:inline;">
                        <button class="task-btn btn-delete" type="submit" onclick="return confirm('Aufgabe wirklich löschen?');">Löschen</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="5">Keine Aufgaben vorhanden.</td></tr>
        <?php endif; ?>
    </table>
</div>