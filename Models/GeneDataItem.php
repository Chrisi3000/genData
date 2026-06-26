<?php

class Models_GeneDataItem extends Models_Base {
    // queries all raw gene records utilizing a left join to ensure continuity when data creators are removed
    public function findAll(): array {
        $statement = "SELECT 
                        g.id,
                        g.genename,
                        g.genesymbol,
                        g.aliases,
                        g.position,
                        g.function,
                        g.organism_id,
                        o.latin_name AS organism,
                        g.reviewed,
                        g.created_by,
                        COALESCE(u.username, 'Deleted user') as creator
                    FROM genedataitem g
                    JOIN organism o ON o.id = g.organism_id
                    LEFT JOIN user u ON u.id = g.created_by";


        $statement = $this->connection->query($statement);
        $res = $statement->fetchAll(PDO::FETCH_ASSOC);

        // loops through the data matrix to transform row records into structural domains
        return array_map(function($item) {
            return new Domains_GeneDataItem($item);
        }, $res);
    }

    // single row fetch targeting specific database record based on identification key inputs
    public function findById($id): Domains_GeneDataItem {
        $statement = "SELECT 
                        g.id,
                        g.genename,
                        g.genesymbol,
                        g.aliases,
                        g.position,
                        g.function,
                        g.organism_id,
                        o.latin_name AS organism,
                        g.reviewed,
                        g.created_by,
                        COALESCE(u.username, 'Deleted user') as creator
                    FROM genedataitem g
                    JOIN organism o ON o.id = g.organism_id
                    LEFT JOIN user u ON u.id = g.created_by
                    WHERE g.id = :id";

        $statement = $this->connection->prepare($statement);
        $statement->execute([":id" => $id]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);

        if ($data){
            return new Domains_GeneDataItem($data);
        } else{
            throw new Exceptions_NotFound();
        }
    }

    // drop target row based on key arguments and guard with exception flags if nothing changes
    public function delete($id): void {
        $query = "DELETE FROM genedataitem WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);

        if ($statement->rowCount() === 0) {
            throw new Exceptions_NotFound();
        }
    }

    // registers fresh datasets inside information matrices and returns the fully mapped instance
    public function insert(Domains_GeneDataItem $gene): Domains_GeneDataItem
    {
        $query = "INSERT INTO genedataitem
                (genename, genesymbol, aliases, position, function, organism_id, reviewed, created_by)
                VALUES
                (:genename, :genesymbol, :aliases, :position, :function, :organism_id, :reviewed, :created_by)";

        $statement = $this->connection->prepare($query);

        $statement->execute([
            ":genename"    => $gene->genename,
            ":genesymbol"  => $gene->genesymbol,
            ":aliases"     => $gene->aliases,
            ":position"    => $gene->position,
            ":function"    => $gene->function,
            ":organism_id" => $gene->organism_id,
            ":reviewed"    => $gene->reviewed,
            ":created_by"  => $gene->created_by
        ]);

        $id = $this->connection->lastInsertId();

        return $this->findById($id);
    }

    // forces exception error handling and updates current entity row based on internal object states
    public function update(Domains_GeneDataItem $obj) {
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE genedataitem 
            SET genename = :genename, 
                genesymbol = :genesymbol, 
                aliases = :aliases,
                position = :position, 
                function = :function,
                organism_id = :organism_id, 
                reviewed = :reviewed
            WHERE id = :id";

        $stmt = $this->connection->prepare($sql);

        // accesses target domain internals safely through standard format serializations
        $dataArray = $obj->jsonSerialize();

        return $stmt->execute([
            ':genename'   => $dataArray['genename'] ?? null,
            ':genesymbol' => $dataArray['genesymbol'] ?? null,
            ':aliases'    => !empty($dataArray['aliases']) ? $dataArray['aliases'] : null,
            ':position'   => $dataArray['position'] ?? null,
            ':function'   => !empty($dataArray['function']) ? $dataArray['function'] : null,
            ':organism_id'=> (int)($dataArray['organism_id'] ?? 0),
            ':reviewed'   => (int)($dataArray['reviewed'] ?? 0),
            ':id'         => (int)($dataArray['id'] ?? 0)
        ]);
    }
}