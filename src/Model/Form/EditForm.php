<?php


namespace Model\Form;


class EditForm
{
    public $id;
    public $title;
    public $description;
    public $price;
    public $active;
    public $created;
    public $category;

    /**
     * EditForm constructor.
     * @param $id
     * @param $title
     * @param $description
     * @param $price
     * @param $active
     * @param $created
     * @param $category
     */
    public function __construct($id, $title, $description, $price, $active, $created, $category)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->active = $active;
        $this->created = $created;
        $this->category = $category;
    }

    public function isValid()
    {
        return !empty($this->title) && !empty($this->description) && !empty($this->price) && !empty($this->active) && !empty($this->category);
    }


}