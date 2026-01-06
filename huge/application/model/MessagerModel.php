<?php

class MessagerModel
{

    public static function getAllMessageByUser()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "
        SELECT 
            m.id,
            m.sender_id,
            sender.user_name AS sender_name,
            m.empfaenger_id,
            empfaenger.user_name AS empfaenger_name,
            m.text,
            m.timestamp,
            m.gelesen
        FROM messages m
        JOIN users sender ON sender.user_id = m.sender_id
        JOIN users empfaenger ON empfaenger.user_id = m.empfaenger_id
        WHERE m.empfaenger_id = :user_id
        ORDER BY m.timestamp DESC
    ";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        return $query->fetchAll();
    }

    public static function getAllOtherUsers($currentUserId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, user_name 
            FROM users 
            WHERE user_id != :current_user_id";

        $query = $database->prepare($sql);
        $query->execute([':current_user_id' => $currentUserId]);

        return $query->fetchAll();
    }

    public static function createMessage($message_text, $empfaenger_id)
    {
        if (!$message_text || strlen($message_text) == 0) {
            Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO messages (sender_id, empfaenger_id, text, gelesen) VALUES (:sender_id, :empfaenger_id, :text, 0)";

        $query = $database->prepare($sql);

        return $query->execute([
            ':sender_id'     => Session::get('user_id'),
            ':empfaenger_id' => $empfaenger_id,
            ':text'          => $message_text
        ]);
    }

    public static function getConversation($userId1, $userId2)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "
        SELECT 
            m.id,
            m.sender_id,
            sender.user_name AS sender_name,
            m.empfaenger_id,
            empfaenger.user_name AS empfaenger_name,
            m.text,
            m.timestamp,
            m.gelesen
        FROM messages m
        JOIN users sender ON sender.user_id = m.sender_id
        JOIN users empfaenger ON empfaenger.user_id = m.empfaenger_id
        WHERE 
            (m.sender_id = :userId1 AND m.empfaenger_id = :userId2) 
            OR (m.sender_id = :userId2 AND m.empfaenger_id = :userId1)
        ORDER BY m.timestamp ASC
        ";
        $query = $database->prepare($sql);
        $query->execute([
            ':userId1' => $userId1,
            ':userId2' => $userId2
        ]);

        return $query->fetchAll();
    }

    public static function getUnreadCounts($userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "
        SELECT sender_id, COUNT(*) AS unread_count
        FROM messages
        WHERE empfaenger_id = :userId AND gelesen = 0
        GROUP BY sender_id
        ";
        $query = $database->prepare($sql);
        $query->execute([':userId' => $userId]);

        $results = $query->fetchAll();

        $unreadCounts = [];
        foreach ($results as $row) {
            $unreadCounts[$row->sender_id] = $row->unread_count;
        }

        return $unreadCounts;
    }

    public static function markMessagesAsRead($userId, $otherUserId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE messages SET gelesen = 1 WHERE empfaenger_id = :userId AND sender_id = :otherUserId AND gelesen = 0";

        $query = $database->prepare($sql);

        return $query->execute([
            ':userId' => $userId,
            ':otherUserId' => $otherUserId
        ]);
    }
}
