<?php
//Declarations
declare(strict_types=1);

namespace App\DAO;

use App\Models\Task;
use Exception;
use PDO;

const DSN = 'mysql:host=localhost;dbname=db_tasks'; // Data Source Name
const USER = 'eduardo';
const PASSWORD = '102030';

class TaskDAO
{

    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function createTask(Task $task): bool
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO `tasks` (`title`, `description`) VALUES (:title, :description)");
            if ($stmt) {
                return $stmt->execute([":title" => $task->getTitle(), ":description" => $task->getDescription()]);
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 
     */
    public function readTask(int $id): Task|bool
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `tasks` WHERE id = :id");
            if ($stmt) {
                $stmt->execute(["id" => $id]);
                $task = $stmt->fetch(PDO::FETCH_ASSOC);
                return $task ? (new Task($task["title"], $task["description"]))->setState($task["state"])->setId($task["id"]) : false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateTask(task $task): bool
    {
        try {
            $stmt = $this->conn->prepare("UPDATE `tasks` SET `title` = :title, `description`= :description, `state` = :state WHERE id = :id");
            return $stmt->execute(["title" => $task->getTitle(), "description" => $task->getDescription(), "state" => $task->getState(), "id" => $task->getId()]);
        } catch (Exception $e) {
            //Logging Aplication Fail Capture
            return false;
        }
    }

    public function deleteTask(int $id):bool
    {
        try {
            $stmt =  $this->conn->prepare("DELETE FROM `tasks` WHERE `id` = :id");
            return $stmt->execute(["id" => $id]);
        } catch(Exception $e) {
            return false;
        }
    }

    public function readAll():array|bool
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM `tasks`");
            $stmt->execute();
            $tasks =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($tasks) {
                $taskList = [];
                foreach($tasks as $task) {
                    $taskList[] = (new Task($task["title"], $task["description"]))->setState($task["state"])->setId($task["id"]);
                }
                return $taskList;
            }
            return $tasks;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }
}
