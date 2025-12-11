<!doctype html>
<html>
<head>
    <title>HUGE</title>
    <!-- META -->
    <meta charset="utf-8">
    <!-- send empty favicon fallback to prevent user's browser hitting the server for lots of favicon requests resulting in 404s -->
    <link rel="icon" href="data:;base64,=">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/style.css" />

    <!-- jQuery und DataTables einfügen -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJ5lG6GXsFhXkPfkLksyn7OyeDvej/mdw="
            crossorigin="anonymous"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script type="text/javascript"
            src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Init DataTable -->
    <script>
        $(document).ready(function () {
            $('.js-table').DataTable();
        });
    </script>

</head>
<body>
    <!-- wrapper, to center website -->
    <div class="wrapper">

        <!-- navigation -->
        <ul class="navigation">
            <li <?php if (View::checkForActiveController($filename, "index")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>index/index">Index</a>
            </li>
            <li <?php if (View::checkForActiveController($filename, "profile")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>profile/index">Profiles</a>
            </li>
            <?php if (Session::userIsLoggedIn()) { ?>
                <li <?php if (View::checkForActiveController($filename, "dashboard")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>dashboard/index">Dashboard</a>
                </li>
                <li <?php if (View::checkForActiveController($filename, "note")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>note/index">My Notes</a>
                </li>
<!--                Admin soll auch Register im Menü angezeigt bekommen-->
                <?php if (View::checkForAdmin()): ?>
                    <li <?php if (View::checkForActiveControllerAndAction($filename, "register/index"))
                    { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>register/index">Register</a>
                    </li>
                <?php endif; ?>
            <?php } else { ?>
                <!-- for not logged in users -->
                <li <?php if (View::checkForActiveControllerAndAction($filename, "login/index")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>login/index">Login</a>
                </li>
                <?php if (View::checkForAdmin()): ?>
                    <li <?php if (View::checkForActiveControllerAndAction($filename, "register/index"))
                    { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>register/index">Register</a>
                    </li>
                <?php endif; ?>
            <?php } ?>
            <li <?php if (View::checkForActiveController($filename, "messager")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>messager/index">Messager</a>
            </li>
        </ul>

        <!-- my account -->
        <ul class="navigation right">
        <?php if (Session::userIsLoggedIn()) : ?>
            <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>user/index">My Account</a>
                <ul class="navigation-submenu">
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/changeUserRole">Change account type</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/editAvatar">Edit your avatar</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/editusername">Edit my username</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/edituseremail">Edit my email</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>user/changePassword">Change Password</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                    </li>
                </ul>
            </li>
            <?php if (Session::get("user_account_type") == 7) : ?>
                <li <?php if (View::checkForActiveController($filename, "admin")) {
                    echo ' class="active" ';
                } ?> >
                    <a href="<?php echo Config::get('URL'); ?>admin/">Admin</a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
        </ul>