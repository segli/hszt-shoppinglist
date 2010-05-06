<?php
interface iMessage {
    function __construct($message = '', $type = 'info', $cssClass = '');
    public function to_array();

}