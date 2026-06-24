<?php
    class IdentifiantInvalideException extends Exception{
        #[Override]
        public function __construct(string $message ="")
        {
            parent::__construct($message);
        }
    }

?>