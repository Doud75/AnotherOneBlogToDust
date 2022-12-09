<?php

namespace App\Model\Repository;

use App\Model\Interfaces\Database;

abstract class Repository
{
    protected \PDO $pdo;

    public function __construct(Database $database)
    {
        $this->pdo = $database->getMySqlPDO();
    }
}