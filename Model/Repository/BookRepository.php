<?php


namespace Model\Repository;


use Model\Entity\Book;

class BookRepository
{
    private $pdo;

    public function setPdo($pdo)
    {
        $this->pdo = $pdo;

        return $this;
    }

    public function save(Book $book)
    {
        global $pdo;

        //todo: implement - check Id: if id===null => insert, else update
    }

    public function find($id)
    {
        $pdo = $this->pdo;

        $sth = $pdo->prepare("SELECT * FROM book WHERE id = :id");
        $sth->execute(['id' => $id]);
        $data = $sth->fetch(\PDO::FETCH_ASSOC);
        $book = (new Book())
            ->setId($data['id'])
            ->setTitle($data['title'])
            ->setDescription($data['description'])
            ->setPrice($data['price'])
            ->setActive($data['is_active'])
            ->setCreated($data['created'])
            ->setCategory($data['category_id'])
        ;

        return $book;

    }

    public function findAll()
    {
        $pdo = $this->pdo;

        $collection = [];
        $sth = $pdo->query('SELECT * FROM book ORDER BY title');

        while ($data = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $book = (new Book())
                ->setId($data['id'])
                ->setTitle($data['title'])
                ->setDescription($data['description'])
                ->setPrice($data['price'])
                ->setActive($data['is_active'])
                ->setCreated($data['created'])
                ->setCategory($data['category_id'])
            ;

            $collection[] = $book;
        }

        return $collection;
    }

    public function findByIds(array $ids)
    {
        $pdo = $this->pdo;

        $collection = [];

        $in = str_repeat('?,', count($ids) - 1) . '?';
        $sth = $pdo->prepare('SELECT * FROM book WHERE id IN ('.$in.') ORDER BY title');
        $sth->execute($ids);

        while ($data = $sth->fetch(\PDO::FETCH_ASSOC)){
            $book = (new Book())
                ->setId($data['id'])
                ->setTitle($data['title'])
                ->setPrice($data['price'])
                ->setActive((bool) $data['is_active'])
                ->setDescription(($data['description']))
                ;

            $collection[] = $book;
        }
        return $collection;
    }

    public function findActive()
    {

    }


}