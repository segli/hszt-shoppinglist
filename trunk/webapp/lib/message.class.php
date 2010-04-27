<?php
include('lib/message.interface.php');

class Message implements iMessage {
    private $type;
    private $message;
    private $cssClass;

    /**
     * @param string $type (debug, info, warn, error)
     * @param string $message
     * @param string $cssClass
     * @return void
     */
    function __construct($message = '', $type = 'info', $cssClass = '') {
        $this->type = $type;
        $this->message = $message;
        $this->cssClass = $cssClass;
    }

    /**
     * @return array
     */
    public function to_array() {
        return array(
            'type' => $this->type,
            'message' => $this->message,
            'cssClass' => $this->cssClass
        );
    }


    
}