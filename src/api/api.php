<?php

interface Api {

    /**
     * Handle GET requests.
     */
    public function onGet();
    
    /**
     * Handle POST requests.
     */
    public function onPost();

}

?>