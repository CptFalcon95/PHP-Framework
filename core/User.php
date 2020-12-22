<?php

class User extends QueryBuilder
{
    protected $userData = [];

    public function __construct($data)
    {
        $this->userData = $data;
    }

    public function save()
    {
        return parent::insert(
            'names',
            $this->userData
        );
    }
}
