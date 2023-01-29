<?php

namespace src\Models;

class User extends Model
{

    protected $table = "users";

    public function createUser(string $identifiant, string $password, string $userename, string $role)
    {
        return $this->query("INSERT INTO {$this->table} (login, password, username, role) VALUES (?, ?, ?, ?)", [$identifiant, $password, $userename, $role]);
    }

    public function findField(string $field)
    {
        return $this->query("SELECT login, password, username, Identifiant FROM {$this->table}", [], true);
    }

    public function updateUser($first_name, $last_name, $naissance, $profession, $genre, $pays, $profile, $ville, $photo = null)
    {
        $sql = "UPDATE {$this->table} SET first_name = ?, last_name = ?, birthday = ?, profession = ?, genre = ?, pays = ?, profile = ?, ville = ?, photo = ?";
        return $this->query($sql, [$first_name, $last_name, $naissance, $profession, $genre, $pays, $profile, $ville, $photo]);
    }

    /**
     * Identifiant de l'utilisateur qui est en session
     *
     * @param string $filed
     * @return
     */
    public function findByIdSession()
    {
        return ($this->query("SELECT Identifiant FROM {$this->table} WHERE login = ?", [$_SESSION['login']], true))->Identifiant;
    }
}
