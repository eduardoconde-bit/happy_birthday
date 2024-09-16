<?php
use App\DAO\TaskDAO;
use const App\DAO\{DSN, USER, PASSWORD};
use App\Models\Task;

require_once(__DIR__."/src/DAO/TaskDAO.php");
require_once(__DIR__."/src/Models/Task.php");

$pdo = new PDO(DSN, USER, PASSWORD);
$taskDAO = new TaskDAO($pdo);

/*if($taskDAO->updateTask((new Task("Tarefa 2", "Testando funcionalidade updateTask"))->setId(12))) {

}*/

$tasks = $taskDAO->readAll();
if($tasks) {
    echo "<pre>";
    print_r($tasks);
} else {
    echo "Não há tarefas Cadastradas ou Ocorreu um Problema!, tente novamente";
}