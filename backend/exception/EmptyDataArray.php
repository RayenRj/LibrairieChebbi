<?php
class EmptyDataArray extends Exception{
    public function __construct(string $message = ""){
        parent::__construct($message);
    }
}