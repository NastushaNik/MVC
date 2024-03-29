<?php


namespace Framework;


class RepositoryFactory
{
    private $repositories = [];

    private $pdo;

    public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;

        return $this;
    }

    /**
     * This method return 'something' Repository class, like 'Book|Category ...'
     * @param $entityName
     * @return mixed
     */
    public function createRepository($entityName)
    {
        if (isset($this->repositories[$entityName])){
            return $this->repositories[$entityName];
        }
        $classname = "\\Model\Repository\\{$entityName}Repository";

        $repo = new $classname();
        $repo->setPdo($this->pdo);
        $this->repositories[$entityName] = $repo;

        return $repo;
    }
}