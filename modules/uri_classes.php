<?php

class URI {

    var $uri;
    var $segments = array();

    function __construct() {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->segments = explode('/', $this->uri);
    }

    function getSegment($id, $default = false) {
        $id = (int) ($id - 1);
        return isset($this->segments[$id]) ? $this->segments[$id] : $default;
    }
}
