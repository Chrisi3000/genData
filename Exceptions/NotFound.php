<?php

class Exceptions_NotFound extends Exceptions_Statuscode {
    public function __construct(
        string $message = "The requested page or record could not be found.",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct(404, $message, $code, $previous);
    }
}
