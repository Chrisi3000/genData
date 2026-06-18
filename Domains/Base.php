<?php

abstract class Domains_Base implements JsonSerializable {
    protected $data;

    public function __construct($data) {
        $this->data = array_merge($this->data, $data);
    }

    // new Domains_Base()->xyz
    public function __get(string $name) {
        return $this->data[$name];
    }

    public function jsonSerialize(): mixed {
        return $this->data;
    }

    public function property_names(){
        return array_keys($this->data);
    }

}