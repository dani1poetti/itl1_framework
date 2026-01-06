<?php

class MessagerController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        // VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
        // need this line! Otherwise not-logged in users could do actions. If all of your pages should only
        // be usable by logged-in users: Put this line into libs/Controller->__construct
        Auth::checkAuthentication();
    }

    public function index($selectedUserId = null)
    {
        $currentUserId = Session::get('user_id');

        $users = MessagerModel::getAllOtherUsers($currentUserId);

        if ($selectedUserId === null) {
            // Default to first user in list
            $selectedUserId = count($users) > 0 ? $users[0]->user_id : null;
        } else {
            // Convert param to int and verify
            $selectedUserId = (int)$selectedUserId;
        }

        // Mark messages as read for the selected user
        if ($selectedUserId !== null) {
            MessagerModel::markMessagesAsRead($currentUserId, $selectedUserId);
        }

        // Get conversation messages between current user and selected user
        $messages = [];
        if ($selectedUserId !== null) {
            $messages = MessagerModel::getConversation($currentUserId, $selectedUserId);
        }

        // Get unread counts for users
        $unreadCounts = MessagerModel::getUnreadCounts($currentUserId);

        $this->View->render('messager/index', array(
            'users' => $users,
            'messages' => $messages,
            'selectedUserId' => $selectedUserId,
            'unreadCounts' => $unreadCounts
        ));
    }

    public function create()
    {
        MessagerModel::createMessage(Request::post('messager_text'), Request::post('empfaenger_id'));
        Redirect::to('messager');
    }

    public function ajaxGetMessages($otherUserId)
    {
        $currentUserId = Session::get('user_id');
        $otherUserId = (int)$otherUserId;

        // Mark messages as read
        MessagerModel::markMessagesAsRead($currentUserId, $otherUserId);

        $messages = MessagerModel::getConversation($currentUserId, $otherUserId);

        // Output safely as JSON.
        header('Content-Type: application/json');
        echo json_encode($messages);
        exit();
    }
}