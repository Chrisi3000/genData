<?php

abstract class Domains_Base implements JsonSerializable {
    protected $data;

    // combines core model structural defaults with incoming active runtime parameters
    public function __construct($data) {
        $this->data = array_merge($this->data, $data);
    }

    // interceptor fallback hook allowing fluent read access to protected data keys
    public function __get(string $name) {
        return $this->data[$name];
    }

    // specifies native dataset serialization targets when handling json encoding actions
    public function jsonSerialize(): mixed {
        return $this->data;
    }

    // isolates current active structural variable array identifier indices
    public function property_names(){
        return array_keys($this->data);
    }

}