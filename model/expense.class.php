<?php
class Expense
{
    protected $id, $id_payer, $username_payer, $ids_participants, $cost, $description, $date;

    function __construct($id_payer, $username_payer, $cost, $description, $date)
    {
        $this->id_payer = $id_payer;
        $this->username_payer = $username_payer;
        $this->cost = $cost;
        $this->description = $description;
        $this->date = $date;
    }

    function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

    function __set($property, $value)
    {
        if (property_exists($this, $property))
            $this->$property = $value;

        return $this;
    }
}
