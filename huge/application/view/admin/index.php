<div class="container">
    <h1>Admin/index</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>

        <div>
            This controller/action/view shows a list of all users in the system. with the ability to soft delete a user
            or suspend a user.
        </div>
        <div>
            <table class="overview-table js-table">
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>User's email</td>
                    <td>User Type</td>
                    <td>Activated ?</td>
                    <td>Link to user's profile</td>
                    <td>Suspension Time in days</td>
                    <td>Soft delete</td>
                    <td>Submit</td>
                </tr>
                </thead>
                <?php foreach ($this->users as $user) { ?>
                    <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                        <form action="<?= config::get("URL"); ?>admin/actionAccountSettings" method="post">
                            <td><?= $user->user_id; ?></td>
                            <td class="avatar">
                                <?php if (isset($user->user_avatar_link)) { ?>
                                    <img src="<?= $user->user_avatar_link; ?>"/>
                                <?php } ?>
                            </td>
                            <td><?= $user->user_name; ?></td>
                            <td><?= $user->user_email; ?></td>
                            <td><?= ($user->user_active == 0 ? 'No' : 'Yes'); ?></td>
                            <td>
                                <a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id; ?>">
                                    Profile
                                </a>
                            </td>

                            <!-- FORM-BEREICH: jetzt korrekt innerhalb der Tabellenzeile -->
                            <td>
                                <select name="user_account_type">
                                    <?php foreach ($this->user_types as $type): ?>
                                        <option value="<?= $type->users_type ?>"
                                                <?= ($type->users_type == $user->user_account_type) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($type->bezeichnung) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="suspension" />
                            </td>
                            <td>
                                <input type="checkbox" name="softDelete"
                                        <?php if ($user->user_deleted) { ?> checked <?php } ?> />
                            </td>
                            <td>
                                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                <input type="submit" />
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div class="register-box">
            <h2>Account erstellen ?</h2>
            <a href="<?php echo Config::get('URL'); ?>register/index">Register</a>
        </div>
    </div>
</div>
