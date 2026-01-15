<?php
/**
 * TaskController
 * Controller für miniTrack Aufgabenverwaltung
 */
class TaskController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }

    // Zeigt die Aufgabenübersicht
    public function index()
    {
        $this->View->render('task/index', array(
            'tasks' => TaskModel::getAllTasks()
        ));
    }

    // Aufgabe erstellen (Formular & Verarbeitung)
    public function create()
    {
        if (isset($_POST['title']) && !empty($_POST['title'])) {
            TaskModel::createTask($_POST['title'], $_POST['description']);
            Redirect::to('task/index');
        }
        $this->View->render('task/create');
    }

    // Status aktualisieren
    public function updateStatus($id, $status)
    {
        TaskModel::updateStatus($id, $status);
        Redirect::to('task/index');
    }

    // Löschen einer Aufgabe
    public function delete($id)
    {
        TaskModel::deleteTask($id);
        Redirect::to('task/index');
    }
}