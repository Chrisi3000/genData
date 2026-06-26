<?php

class Models_Organism extends Models_Base
{
    public function findAll(): array
    {
        $query = "SELECT id, name, latin_name
                  FROM organism
                  ORDER BY name";

        $statement = $this->connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($item) {
            return new Domains_Organism($item);
        }, $result);
    }

    public function findById($id): Domains_Organism
    {
        $query = "SELECT id, name, latin_name
                  FROM organism
                  WHERE id = :id";

        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":id" => $id
        ]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exceptions_NotFound();
        }

        return new Domains_Organism($data);
    }
}