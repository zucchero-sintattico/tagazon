<?php

require_once(__DIR__."/../db/database.php");

abstract class Api {

    /**
     * Get the elements.
     * Possible find on specified id.
     */
    protected abstract function onGet();

    /**
     * Create a new element.
     */
    protected abstract function onPost();

    /**
     * Update an element.
     */
    protected abstract function onPatch();

    /**
     * Delete an element.
     */
    protected abstract function onDelete();

    public function handle(){
        header('Content-Type: application/json');
        if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
            $this->onGet();
        } else if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $this->onPost();
        } else if( $_SERVER['REQUEST_METHOD'] === 'PATCH' ) {
            $this->onPatch();
        } else if( $_SERVER['REQUEST_METHOD'] === 'DELETE' ) {
            $this->onDelete();
        }
    }

    public static function run($api){
        $api->handle();
    }


}

?>