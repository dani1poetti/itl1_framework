<?php
/**
 * TaskController
 * Controller für miniTrack Aufgabenverwaltung
 */
class TaskController extends Controller
{
    // Zeigt die Aufgabenübersicht
    public function index()
    {
        $task_model = $this->loadModel('TaskModel');
        $tasks = $task_model->getAllTasks();
        require APP . 'view/task/index.php';
    }

    // Aufgabe erstellen (Formular & Verarbeitung)
    public function create()
    {
        $errors = array();
        if (isset($_POST['title']) && !empty($_POST['title'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $task_model = $this->loadModel('TaskModel');
            $task_model->createTask($title, $description);
            header('Location: ' . URL . 'task/index');
            exit;
        }
        require APP . 'view/task/create.php';
    }

    // Status aktualisieren
    public function updateStatus($id, $status)
    {
        $task_model = $this->loadModel('TaskModel');
        $task_model->updateStatus($id, $status);
        header('Location: ' . URL . 'task/index');
        exit;
    }

    // Löschen einer Aufgabe
    public function delete($id)
    {
        $task_model = $this->loadModel('TaskModel');
        $task_model->deleteTask($id);
        header('Location: ' . URL . 'task/index');
        exit;
    }
}
