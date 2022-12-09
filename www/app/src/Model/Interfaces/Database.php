<?php

namespace App\Model\Interfaces;

interface Database
{
    public function getMySqlPDO(): \PDO;
}