<?php
abstract class Api {
	
	protected abstract function onGet();
	protected abstract function onPost();
	protected abstract function onPatch();
	protected abstract function onDelete();
	protected abstract function handle();

	public static function run($api){
		echo $api->handle();
	}
}
?>