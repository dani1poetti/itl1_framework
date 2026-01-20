<?php
/**
 * TaskModel
 * Modell für die einfache Aufgabenverwaltung (miniTrack)
 */
class TaskModel
{
    /**
     * Neue Aufgabe anlegen
     */
    public static function createTask($title, $description)
    {
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "CALL sp_create_task(:title, :description)";
        $query = $db->prepare($sql);
        $parameters = array(':title' => $title, ':description' => $description);
        return $query->execute($parameters);
    }

    /**
     * Alle Aufgaben abrufen, sortiert nach created_at DESC
     */
    public static function getAllTasks()
    {
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "CALL sp_get_all_tasks()";
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Status ändern
     */
    public static function updateStatus($id, $status)
    {
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "CALL sp_update_task_status(:id, :status)";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $id, ':status' => $status);
        return $query->execute($parameters);
    }

    /**
     * Aufgabe löschen
     */
    public static function deleteTask($id)
    {
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "CALL sp_delete_task(:id)";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $id);
        return $query->execute($parameters);
    }
}