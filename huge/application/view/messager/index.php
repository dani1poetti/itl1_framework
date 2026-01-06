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
                <label>Text of new message: </label><input type="text" name="messager_text" required />
                <br>
                <label>Empfänger auswählen:</label>
                <br>
                <?php foreach ($this->users as $user): ?>
                    <label>
                        <input type="radio" name="empfaenger_id" value="<?= $user->user_id ?>" <?php if ($this->selectedUserId == $user->user_id) echo 'checked'; ?> required>
                        <?= htmlspecialchars($user->user_name) ?>
                        <?php if(isset($this->unreadCounts[$user->user_id]) && $this->unreadCounts[$user->user_id] > 0): ?>
                            <span style="color:red; font-weight:bold;">(<?= $this->unreadCounts[$user->user_id] ?> unread)</span>
                        <?php endif; ?>
                    </label><br>
                <?php endforeach; ?>
                <br>
                <input type="submit" value="Create this message" autocomplete="off" /> <br>
            </form>
        </p>

        <h3>Conversations</h3>

        <div>
            <label>Select User conversation: </label>
            <select id="userSelector">
                <?php foreach ($this->users as $user): ?>
                    <option value="<?= $user->user_id ?>" <?php if ($this->selectedUserId == $user->user_id) echo 'selected'; ?>>
                        <?= htmlspecialchars($user->user_name) ?>
                        <?php if(isset($this->unreadCounts[$user->user_id]) && $this->unreadCounts[$user->user_id] > 0): ?>
                            (<?= $this->unreadCounts[$user->user_id] ?> unread)
                        <?php endif; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="conversationContainer">
            <?php if ($this->messages): ?>
                <div class="message-thread">
                    <?php foreach ($this->messages as $msg): ?>
                        <div class="bubble <?php echo ($msg->sender_id == Session::get('user_id')) ? 'sender' : 'recipient'; ?>">
                            <strong><?php echo htmlspecialchars($msg->sender_name); ?>:</strong> <?php echo htmlentities($msg->text); ?><br />
                            <small><?php echo htmlspecialchars($msg->timestamp); ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div>No messages yet</div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
    document.getElementById('userSelector').addEventListener('change', function () {
        const userId = this.value;
        const url = '<?php echo Config::get("URL"); ?>messager/ajaxGetMessages/' + encodeURIComponent(userId);

        fetch(url)
            .then(response => response.json())
            .then(messages => {
                const container = document.getElementById('conversationContainer');
                container.innerHTML = '';

                if (messages.length === 0) {
                    container.innerHTML = '<div>No messages yet</div>';
                    return;
                }

                const thread = document.createElement('div');
                thread.classList.add('message-thread');

                messages.forEach(msg => {
                    const bubble = document.createElement('div');
                    bubble.className = 'bubble ' + (msg.sender_id == <?=json_encode(Session::get('user_id'))?> ? 'sender' : 'recipient');

                    bubble.innerHTML = '<strong>' + escapeHtml(msg.sender_name) + ':</strong> ' + escapeHtml(msg.text) + '<br />' +
                        '<small>' + escapeHtml(msg.timestamp) + '</small>';
                    thread.appendChild(bubble);
                });

                container.appendChild(thread);
            })
            .catch(error => {
                console.error('Error fetching messages:', error);
            });
    });

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }
</script>

<style>
    .bubble {
        border-radius: 15px;
        padding: 10px;
        margin: 5px 10px;
        max-width: 70%;
        clear: both;
    }
    .sender {
        background-color: #dcf8c6;
        float: right;
        text-align: right;
    }
    .recipient {
        background-color: #fff;
        float: left;
        text-align: left;
    }
    .message-thread {
        overflow-y: auto;
        max-height: 300px;
        border: 1px solid #ccc;
        padding: 10px;
        background-color: #f9f9f9;
    }
</style>
