<?php

namespace App\Repositories;

use App\Entities\User;
use App\Repositories\AbstractRepository;

/** 
 * Classe UserManager pour gérer les requêtes liées aux users et à l'authentification.
 */

class UserRepository extends AbstractRepository
{
    /**
     * Récupère un user par son login.
     * @param string $login
     * @return ?User
     */
    public function getUserByLogin(string $login): ?User
    {
        $sql = "SELECT * FROM user WHERE login = :login";
        $result = $this->db->query($sql, ['login' => $login]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }
}
