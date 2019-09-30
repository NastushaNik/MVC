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
        $pdo = $this->pdo;

//        $data = [
//            'id' => $book->getId(),
//            'title' => $book->getTitle(),
//            'description' => $book->getDescription(),
//            'price' => $book->getPrice(),
//            'is_active' => $book->getActive(),
//            'category_id' => $book->getCategory(),
//            'created' => $book->getMySqlCreated()
//        ];
//
//        if ($data['id'] === null){
//
//        }else{
//            $sth = $pdo->prepare("UPDATE book SET 'title' = :title,
//                                                'description' = :description,
//                                                'price' = :price,
//                                                'is_active' = :is_active,
//                                                'category_id' = :category_id,
//                                                'created' = :'created'
//                                                WHERE 'id' = :id");
//
//            $sth->bindParam(':title', $data['title'], PDO::PARAM_STR);
//            $sth->bindParam(':description', $data['description'], PDO::PARAM_STR);
//            $sth->bindParam(':is_active', $_POST['is_active'], PDO::PARAM_BOOL);
//            $sth->bindParam(':category_id', $_POST['category_id'], PDO::PARAM_INT);
//            $sth->bindParam(':created', $_POST['created'], PDO::PARAM_STR);
//            $sth->bindParam(':price', $_POST['price'], PDO::PARAM_INT);
//            $sth->execute();
//        }


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