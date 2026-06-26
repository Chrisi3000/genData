<?php

class Models_Organism extends Models_Base
{
    // fetches all database organism rows and returns them mapped into domain objects ordered alphabetically
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
}