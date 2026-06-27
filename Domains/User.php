<?php

class Domains_User extends Domains_Base{

    // defines default identity column schemas to safely prevent missing index errors
    public function __construct($data){
        $this->data = [
            "id"=>null,
            "firstname"=>null,
            "lastname"=>null,
            "username"=>null,
            "password"=>null,
            "is_admin"=>null
        ];

        // merges runtime input mutations over schema defaults inside parent class context
        parent::__construct($data);
    }
}