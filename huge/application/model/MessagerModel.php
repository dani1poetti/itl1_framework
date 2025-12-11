<?php

/**
 * NoteModel
 * This is basically a simple CRUD (Create/Read/Update/Delete) demonstration.
 */
class MessagerModel
{
    /**
     * Get all notes (notes are just example data that the user has created)
     * @return array an array with several objects (the results)
     */
    public static function getAllMessageByUser()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM messages WHERE sender_id = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id')));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

//    /**
//     * Get a single note
//     * @param int $note_id id of the specific note
//     * @return object a single object (the result)
//     */
//    public static function getNote($note_id)
//    {
//        $database = DatabaseFactory::getFactory()->getConnection();
//
//        $sql = "SELECT user_id, note_id, note_text FROM notes WHERE user_id = :user_id AND note_id = :note_id LIMIT 1";
//        $query = $database->prepare($sql);
//        $query->execute(array(':user_id' => Session::get('user_id'), ':note_id' => $note_id));
//
//        // fetch() is the PDO method that gets a single result
//        return $query->fetch();
//    }

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

    /**
     * Set a note (create a new one)
     * @param string $message_text note text that will be created
     * @param int $empfaenger_id
     * @return bool feedback (was the note created properly ?)
     */
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

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

//    /**
//     * Update an existing note
//     * @param int $note_id id of the specific note
//     * @param string $note_text new text of the specific note
//     * @return bool feedback (was the update successful ?)
//     */
//    public static function updateNote($note_id, $note_text)
//    {
//        if (!$note_id || !$note_text) {
//            return false;
//        }
//
//        $database = DatabaseFactory::getFactory()->getConnection();
//
//        $sql = "UPDATE notes SET note_text = :note_text WHERE note_id = :note_id AND user_id = :user_id LIMIT 1";
//        $query = $database->prepare($sql);
//        $query->execute(array(':note_id' => $note_id, ':note_text' => $note_text, ':user_id' => Session::get('user_id')));
//
//        if ($query->rowCount() == 1) {
//            return true;
//        }
//
//        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_EDITING_FAILED'));
//        return false;
//    }

//    /**
//     * Delete a specific note
//     * @param int $note_id id of the note
//     * @return bool feedback (was the note deleted properly ?)
//     */
//    public static function deleteNote($note_id)
//    {
//        if (!$note_id) {
//            return false;
//        }
//
//        $database = DatabaseFactory::getFactory()->getConnection();
//
//        $sql = "DELETE FROM notes WHERE note_id = :note_id AND user_id = :user_id LIMIT 1";
//        $query = $database->prepare($sql);
//        $query->execute(array(':note_id' => $note_id, ':user_id' => Session::get('user_id')));
//
//        if ($query->rowCount() == 1) {
//            return true;
//        }
//
//        // default return
//        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_DELETION_FAILED'));
//        return false;
//    }
}
