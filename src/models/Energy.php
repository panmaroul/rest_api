<?php
namespace models;

use PDO;
use PDOException;

class Energy
{
    private $conn;
    const TABLE_NAME = 'energy_measurements';

    public $res;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . self::TABLE_NAME . ' em';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function read_single($column) {
        try {
            if ($column === 'world_share') {
                $sth = $this->conn->prepare('SELECT id, country, population, world_share FROM energy_measurements');
            } elseif ($column === 'non_renewable') {
                $sth = $this->conn->prepare('SELECT id, country, population, non_renewable FROM energy_measurements');
            } elseif ($column === 'co2_emiss_per_capita') {
                $sth = $this->conn->prepare('SELECT id, country, population, co2_emiss_per_capita FROM energy_measurements');
            } elseif ($column === 'country_share_of_world_co2') {
                $sth = $this->conn->prepare('SELECT id, country, population, country_share_of_world_co2 FROM energy_measurements');
            } elseif ($column === 'co2_emiss_one_year_change') {
                $sth = $this->conn->prepare('SELECT country, population, co2_emiss_one_year_change FROM energy_measurements');
            }
            $sth->execute();
            $response = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
        if ($column === 'world_share') {
            foreach ($response as $value) {
                $this->res[$value['country']] = [
                    $value['id'], $value['country'], $value['population'], $value['world_share']
                ];
                //array_push($res, $value['id'], $value['country'], $value['population'], $value['world_share']);
            }
        } elseif ($column === 'non_renewable') {
            foreach ($response as $value) {
                $this->res[$value['country']] = [
                    $value['id'], $value['country'], $value['population'], $value['non_renewable']
                ];
            }
        } elseif ($column === 'co2_emiss_per_capita') {
            foreach ($response as $value) {
                $this->res[$value['country']] = [
                    $value['id'], $value['country'], $value['population'], $value['co2_emiss_per_capita']
                ];
            }
        } elseif ($column === 'country_share_of_world_co2') {
            foreach ($response as $value) {
                $this->res[$value['country']] = [
                    $value['id'], $value['country'], $value['population'], $value['country_share_of_world_co2']
                ];
            }
        } elseif ($column === 'co2_emiss_one_year_change') {
            foreach ($response as $value) {
                $this->res[$value['country']] = [
                    $value['id'], $value['country'], $value['population'], $value['co2_emiss_one_year_change']
                ];
            }
        }
    }

}