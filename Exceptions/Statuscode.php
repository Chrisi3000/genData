<?php

abstract class Exceptions_Statuscode extends Exception {
    // structural property to bind precise numeric web response layers directly to errors
    public readonly int $status_code;

    // constructs status wrapper using structural parent class argument definitions
    public function __construct(int $statuscode, string $message = "", int $code = 0,
                                ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->status_code = $statuscode;
    }
}