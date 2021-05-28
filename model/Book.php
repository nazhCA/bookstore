<?php

//egyelőre nincs használva ez az osztály sehol
class Book
{
    private $id;
    private $name;
    private $price;
    private $quantity;
    private $image;

    /**
     * Book constructor.
     * @param $id
     * @param $name
     * @param $price
     * @param $quantity
     * @param $image
     */
    public function __construct($id, $name, $price, $quantity, $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->image = $image;
    }


}