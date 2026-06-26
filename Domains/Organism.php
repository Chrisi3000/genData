<?php

class Domains_Organism extends Domains_Base
{
    public function __construct(array $data)
    {
        $this->data = [
            "id" => null,
            "name" => null,
            "latin_name" => null,
        ];

        parent::__construct($data);
    }
}