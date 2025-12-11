<div class="container">
    <h1>MessagerController/index</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>
        <p>
            This is a Messager Dienst.
        </p>
        <p>
            <form method="post" action="<?php echo Config::get('URL');?>messager/create">
                <label>Text of new message: </label><input type="text" name="messager_text" />
                <input type="submit" value='Create this message' autocomplete="off" />
                <label>Empfänger auswählen:</label><br>

                <?php foreach ($this->users as $user): ?>
                    <label>
                        <input type="radio" name="empfaenger_id" value="<?= $user->user_id ?>">
                        <?= htmlspecialchars($user->user_name) ?>
                    </label><br>
                <?php endforeach; ?>

                <br>
            </form>
        </p>

        <?php if ($this->messager) { ?>
            <table class="note-table">
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Note</td>
                    <td>EDIT</td>
                    <td>DELETE</td>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($this->notes as $key => $value) { ?>
                        <tr>
                            <td><?= $value->note_id; ?></td>
                            <td><?= htmlentities($value->note_text); ?></td>
                            <td><a href="<?= Config::get('URL') . 'note/edit/' . $value->note_id; ?>">Edit</a></td>
                            <td><a href="<?= Config::get('URL') . 'note/delete/' . $value->note_id; ?>">Delete</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else { ?>
                <div>No messages yet</div>
            <?php } ?>
    </div>
</div>
