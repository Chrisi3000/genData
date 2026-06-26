<?php

class Domains_Organism extends Domains_Base
{
    // establishes initial biological metadata structural blueprints with clean index defaults
    public function __construct(array $data)
    {
        $this->data = [
            "id" => null,
            "name" => null,
            "latin_name" => null,
        ];

        // aggregates incoming entity key variations directly into the mapped array state
        parent::__construct($data);
    }
}