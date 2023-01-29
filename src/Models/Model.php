<?php

namespace src\Models;

use config\Database;
use PDO;

abstract class Model
{

    protected $db;
    protected $table;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Retourner toutes les lignes d'une table
     *
     * @param [type] $ofset
     * @return array
     */
    public function all($ofset, $trie = "DESC"): array
    {
        return $this->query("SELECT * FROM {$this->table} ORDER BY {$ofset} {$trie}");
    }

    /**
     * Afficher par identifiant
     *
     * @param integer $id
     * @return void
     */
    public function afficherParId(string $champ, $id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE {$champ} = ?", [$id], true);
    }

    /**
     * Récupérer les informations de connexion
     *
     * @param integer $login
     * @return Model
     */
    public function findByLogin(string $login): Model
    {
        return $this->query("SELECT * FROM {$this->table} WHERE login = ?", [$login], true);
    }

    /**
     * Récupérer les informations de connexion
     *
     * @param integer $identifiant
     * @return Model
     */
    public function findById(string $id, string $field)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE {$field} = ?", [$id], true);
    }

    public function update(int $id, array $data, ?array $relations = null)
    {
        $sqlRequestPart = "";
        $i = 1;

        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? "" : ', ';
            $sqlRequestPart .= "{$key} = :{$key}{$comma}";
            $i++;
        }

        $data['id'] = $id;

        return $this->query("UPDATE {$this->table} SET {$sqlRequestPart} WHERE id = :id", $data);
    }

    public function destroy(int $id): bool
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function query(string $sql, array $param = null, bool $single = null)
    {
        $method = is_null($param) ? 'query' : 'prepare';

        if (
            strpos($sql, 'DELETE') === 0
            || strpos($sql, 'UPDATE') === 0
            || strpos($sql, 'INSERT') === 0) {

            $stmt = $this->db->getPDO()->$method($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
            return $stmt->execute($param);
        }

        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = $this->db->getPDO()->$method($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);

        if ($method === 'query') {
            return $stmt->$fetch();
        } else {
            $stmt->execute($param);
            return $stmt->$fetch();
        }
    }

    public function findByUser(int $id_user, $order)
    {
        $sql = "SELECT * FROM {$this->table} WHERE identifiant_user = ? ORDER BY {$order} DESC";
        return $this->query($sql, [$id_user]);
    }

}