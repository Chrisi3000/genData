<?php

class Domains_GeneDataItem extends Domains_Base{
    // configures default domain keys matching explicit gene database column structures
    public function __construct(array $data){
        $this->data = [
            "id" => null,
            "genename" => null,
            "genesymbol" => null,
            "aliases" => null,
            "position" => null,
            "function" => null,
            "organism_id" => null,
            "organism" => null,
            "reviewed" => null,
            "created_by" => null,
        ];

        // overrides and hydrates foundational defaults with current active datasets
        parent::__construct($data);
    }
}