<div class="container">
    <h1>MessagerController/index</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>
        <p>
            This is a Messager Dienst.
        </p>
        <h3>Write Message</h3>
        <p>
            <form method="post" action="<?php echo Config::get('URL');?>messager/create">
                <label>Text of new message: </label><input type="text" name="messager_text" />
                <br>
                <label>Empfänger auswählen:</label>
                <br>
                <?php foreach ($this->users as $user): ?>
                    <label>
                        <input type="radio" name="empfaenger_id" value="<?= $user->user_id ?>">
                        <?= htmlspecialchars($user->user_name) ?>
                    </label><br>
                <?php endforeach; ?>
                <br>
                <input type="submit" value='Create this message' autocomplete="off" /> <br>
            </form>
        </p>

        <h3>Messages</h3>
        <?php if ($this->messager) { ?>
            <table class="note-table">
                <thead>
                <tr>
                    <td>Name</td>
                    <td>Nachricht</td>
                    <td>Timestamp</td>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->messages as $msg) { ?>
                        <tr>
                            <td><?= $msg->sender_name; ?></td>
                            <td><?= htmlentities($msg->text); ?></td>
                            <td><?= $msg->timestamp; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else { ?>
                <div>No messages yet</div>
            <?php } ?>
    </div>
</div>
