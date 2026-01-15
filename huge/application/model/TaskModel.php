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
        $sql = "INSERT INTO tasks (title, description, status, created_at) VALUES (:title, :description, 'offen', NOW())";
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
        $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
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
        $sql = "UPDATE tasks SET status = :status WHERE id = :id";
        $query = $db->prepare($sql);
        $parameters = array(':status' => $status, ':id' => $id);
        return $query->execute($parameters);
    }

    /**
     * Aufgabe löschen
     */
    public static function deleteTask($id)
    {
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "DELETE FROM tasks WHERE id = :id";
        $query = $db->prepare($sql);
        $parameters = array(':id' => $id);
        return $query->execute($parameters);
    }
}