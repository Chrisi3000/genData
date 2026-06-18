<?php

class Domains_GeneDataItem extends Domains_Base{
    public function __construct(array $data){
        $this->data = [
            "id" => null,
            "genename" => null,
            "GeneSymbol" => null,
            "aliases" => null,
            "position" => null,
            "function" => null,
            "organism" => null,
            "reviewed" => null
        ];

        parent::__construct($data);
    }
}