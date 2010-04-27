<?php
interface iMessage {
    function __construct($message, $type, $cssClass);
    public function to_array();

}