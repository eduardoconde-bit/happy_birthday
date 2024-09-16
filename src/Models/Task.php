<?php
namespace App\Models;

class Task
{
    private readonly ?int $id;
    private string $title;
    private ?string $description;
    private bool $state;

    public function __construct(string $title, ?string $description = null)
    {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setState(false);
    }

    public function setId(int $id) {
        $this->id = $id;
        return $this;
    }

    public function getId():int
    {
        return $this->id;
    }

    /**
     * @param string $title
     * Task Title, limited for to 255 characters
     */
    public function setTitle(string $title) 
    {
        if(mb_strlen($title) > 255) {
            throw new \Exception("String Size Exceeded Allowed");
        }
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * 
     */
    public function setDescription(string $description) 
    {
        $description = trim($description, " \n\r\t");
        if(mb_strlen($description) > 500) {
            throw new \Exception("String Size Exceeded Allowed");
        }
        $this->description = $description === "" ? null : $description;
        return $this;
    }

    public function getDescription():?string 
    {
        return $this->description;
    }

    /**
     * 
     */
    public function setState(bool $taskState) {
        $this->state = $taskState;
        return $this;
    }

    public function getState():bool 
    {
        return $this->state; 
    }
}
