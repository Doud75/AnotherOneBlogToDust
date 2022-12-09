<?php

namespace App\Model\Entity;

use App\Model\Entity\BaseEntity;

class User extends BaseEntity
{

    private ?string $username = null;
    private ?string $password = null;
    private ?string $token = null;

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }


    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password, bool $hash = false)
    {
        if ($hash) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->password = $password;
        return $this;
    }
    public function verifyPassword($plainPassword): bool
    {
        return password_verify($plainPassword, $this->password);
    }
}