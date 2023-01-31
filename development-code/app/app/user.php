<?php

class User
{
    private $id;
    private $name;
    private $group;
    private $home;

    public function __construct($id, $name, $group, $home)
    {
        $this->id = $id;
        $this->name = $name;
        $this->group = $group;
        $this->home = $home;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}