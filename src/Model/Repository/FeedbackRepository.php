<?php


namespace Model\Repository;


use Model\Entity\Feedback;

class FeedbackRepository
{

    public function save(Feedback $feedback)
    {
        global $pdo;

        $data = [
            'email' => $feedback->getEmail(),
            'message' => $feedback->getMessage(),
            'created' => $feedback->getMySqlCreated()
        ];

        $sql = 'INSERT INTO feedback VALUES (null, :email, :message, :created)';
        $sth = $pdo->prepare($sql);
        $sth->execute($data);

    }
}