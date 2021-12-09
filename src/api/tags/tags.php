<?php

require('src/api/api.php');

class TagsApi implements Api {
    
        public function get($request, $response, $args) {
            $tags = Tag::all();
            $response->getBody()->write(json_encode($tags));
        }
    
        public function post($request, $response, $args) {
            $tag = new Tag();
            $tag->name = $request->getParsedBody()['name'];
            $tag->save();
            $response->getBody()->write(json_encode($tag));
        }
    
        public function put($request, $response, $args) {
            $tag = Tag::find($args['id']);
            $tag->name = $request->getParsedBody()['name'];
            $tag->save();
            $response->getBody()->write(json_encode($tag));
        }
    
        public function delete($request, $response, $args) {
            $tag = Tag::find($args['id']);
            $tag->delete();
            $response->getBody()->write(json_encode($tag));
        }
    
}
?>