<?php

namespace app\controllers;

class AutoTextTreeController {
    
    private $tree = [];
    
    public function __construct() {
        ;
    }
    
    private function createNode($text,$url='',$last=FALSE) {
        $r['text'] = $text;
        if($last) {
            $r['href'] = $url;
        }
        return $r;
    }
    
    public function createNodesFromPath($path, $url) {
        $array = explode('\\',$path);
        if(empty($array)) {
            return FALSE;
        }
        $r = $this->createNode(array_shift($array));
        $aux = &$r;
        while(!empty($array)) {
            $text = array_shift($array);
            $node = $this->createNode($text,$url,empty($array));
            $aux['nodes'] = [$node];
            $aux = &$aux['nodes'][0];
        } // var_dump($r); die();
        return $r;
    } 
    
    private function equals($n, $n1) {
        return $this->isNode($n) && $this->isNode($n1) && $n['text'] == $n1['text'];
    }
    
    private function isSheet($n) {
        return $this->isNode($n) && !array_key_exists('nodes', $n);
    }

    private function _merge($node, &$tree) {
        if(empty($tree)) {
            $tree = [$node];
            return TRUE;
        } else {
            foreach($tree as &$n){
                if($this->equals($node,$n)) {
                    if(!$this->isSheet($node)) {
                        return $this->_merge($node['nodes'][0], $n['nodes']);                            
                    }else {
                        return FALSE;
                    }                    
                }
            }
            $tree[] = $node;
            return TRUE;
        }
    }
    
    private function isNode($node) {
        return array_key_exists('text', $node);// && array_key_exists('href', $node);
    }
    
    public function merge($path, $url) {
        $path_nodes = $this->createNodesFromPath($path, $url);
        return $this->_merge($path_nodes,$this->tree);        
    }
    
    public function getTree() {
        return $this->tree;
    }

}


