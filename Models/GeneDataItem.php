<?php

class Models_GeneDataItem extends Models_Base {
    public function findAll(): array {
        $statement = "SELECT id, genename, GeneSymbol, aliases, position, function, organism, reviewed FROM GeneDataItem";

        $statement = $this->connection->query($statement);
        $res = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($item) {
            return new Domains_GeneDataItem($item);
        }, $res);
    }

    public function findById($id): Domains_GeneDataItem {
        $statement = "SELECT id, genename, GeneSymbol, aliases, position, function, organism, reviewed
                      FROM GeneDataItem 
                      WHERE id = :id";

        $statement = $this->connection->prepare($statement);
        $statement->execute([":id" => $id]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);

        if ($data){
            return new Domains_GeneDataItem($data);
        } else{
            throw new Exceptions_NotFound();
        }
    }

}