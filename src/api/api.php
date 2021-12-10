<?php

require_once(__DIR__."/../db/database.php");

function parse_raw_http_request(array &$a_data)
{
  // read incoming data
  $input = file_get_contents('php://input');

  // grab multipart boundary from content type header
  preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
  $boundary = $matches[1];

  // split content by boundary and get rid of last -- element
  $a_blocks = preg_split("/-+$boundary/", $input);
  array_pop($a_blocks);

  // loop data blocks
  foreach ($a_blocks as $id => $block)
  {
    if (empty($block))
      continue;

    // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char

    // parse uploaded files
    if (strpos($block, 'application/octet-stream') !== FALSE)
    {
      // match "name", then everything after "stream" (optional) except for prepending newlines 
      preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
    }
    // parse all other fields
    else
    {
      // match "name" and optional value in between newline sequences
      preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
    }
    $a_data[$matches[1]] = $matches[2];
  }        
}
class Api {

    private $class;

    public function __construct($class) {
        $this->class = $class;
    }

    /**
     * Get the elements.
     * Possible find on specified id.
     */
    protected function onGet(){
        
        $idSet = true;
        $ids = [];
        foreach($this->class::primary_keys as $key => $value){
          if(!isset($_GET[$key])){
            $idSet = false;
          }else{
            array_push($ids, $_GET[$key]);
          }
        }

        if ($idSet) {
            echo json_encode(Entity::find($this->class, ...$ids));
        } else {
            echo json_encode(Entity::all($this->class));
        }
    }

    /**
     * Create a new element.
     */
    protected function onPost(){
		
        $idSet = true;
        $ids = [];
		$params = [];
        foreach($this->class::primary_keys as $key => $value){
			if(!isset($_GET[$key])){
				$idSet = false;
			}else{
				array_push($ids, $_GET[$key]);
			}
        }
		foreach($this->class::fields as $key => $value){
			if(isset($_POST[$key])){
			  array_push($params, $_POST[$key]);
			}
		}

        $res = Entity::create($this->class, null, ...$params);
        echo $res;
	}

    /**
     * Update an element.
     */
    protected function onPatch(){

		$_PATCH = $this->getPatchData();

        $idSet = true;
        $ids = [];
		$params = [];
        foreach($this->class::primary_keys as $key => $value){
			if(!isset($_GET[$key])){
				$idSet = false;
			}else{
				array_push($ids, $_GET[$key]);
			}
        }
		foreach($this->class::fields as $key => $value){
			if(isset($_PATCH[$key])){
			  array_push($params, $_PATCH[$key]);
			}
		}

        echo Entity::update($this->class, $ids, ...$params);
	}

    /**
     * Delete an element.
     */
    protected function onDelete(){

        $idSet = true;
        $ids = [];
		$params = [];
        foreach($this->class::primary_keys as $key => $value){
			if(!isset($_GET[$key])){
				$idSet = false;
			}else{
				array_push($ids, $_GET[$key]);
			}
        }
		foreach($this->class::fields as $key => $value){
			if(isset($_POST[$key])){
			  array_push($params, $_POST[$key]);
			}
		}        
		
		if ($idSet) {
            $res = Entity::delete($this->class, ...$ids);
            http_response_code($res ? 200 : 400);
            echo json_encode($res);
        }

	}

    /**
     * Get the PATCH request data.
     */
    protected function getPatchData(){
        $_PATCH = [];
        parse_str(file_get_contents('php://input'), $_PATCH);
        parse_raw_http_request($_PATCH);
        return $_PATCH;
    }

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