<?php
//Created by: Raymond Chong
//Date: 2017-08-10
namespace HTML;

class Node
{
    const CLOSE_TAG=["input"];
    //const HTML_TAG_LIST=["a","abbr","address","area","article","aside","audio","b","base","bdi","bdo","blockquote","body","br","button","canvas","caption","cite","code","col","colgroup","command","datalist","dd","del","details","dfn","div","dl","dt","em","embed","fieldset","figcaption","figure","footer","form","h1","h2","h3","h4","h5","h6","head","header","hgroup","hr","html","i","iframe","img","input","ins","kbd","keygen","label","legend","li","link","map","mark","menu","meta","meter","nav","noscript","object","ol","optgroup","option","output","p","param","pre","progress","q","rp","rt","ruby","s","samp","script","section","select","small","source","span","strong","style","sub","summary","sup","table","tbody","td","textarea","tfoot","th","thead","time","title","tr","track","u","ul","var","video","wbr","abbr","object"];

    public $_tag;
    public $_child=[];

    public $_style=[];
    public $_attribute=[];
    public $_class=[];

    public function __construct($tag)
    {
        $this->_tag=$tag;
    }

    public function __get($tag)
    {
        $element=new Node($tag);
        $this->_child[]=$element;
        return $element;
    }

    public function __call($name, $argv)
    {
        $this->attr([$name=>$argv[0]]);
        return $this;
    }

    public function __toString()
    {
        $tag=$this->_tag;

        $html="<$tag";

        if ($this->_class) {
              $html.=" class=\"".implode(" ", $this->_class)."\"";
        }

        if ($this->_attribute) {
            foreach ($this->_attribute as $n => $v) {
                if($v===true){
                    $attribute[]=$n;
                }elseif($v===false){
                    
                }else{
                    if(is_array($v)){
                        $v=json_encode($v,JSON_UNESCAPED_UNICODE);
                    }
                    $attribute[]="$n=\"".htmlspecialchars($v)."\"";
                }
            }
            if ($attribute) {
                $html.=" ".implode(" ", $attribute);
            }
        }


        if ($this->_style) {
            foreach ($this->_style as $n => $v) {
                $style[]="$n:$v";
            }
            if ($style) {
                $style=implode(";", $style);
                $html.=" style=\"$style\"";
            }
        }



        if (in_array($this->_tag, self::CLOSE_TAG)) {
            $html.="/>";
            return $html;
        }

        $html.=">";

        return $html. implode("", $this->_child)."</$tag>";
    }

    public function style($array = [])
    {
        $this->_style=array_merge($this->_style, $array);
        return $this;
    }

    public function attr($array)
    {
        $this->_attribute=array_merge($this->_attribute, $array);
        return $this;
    }

    public function text($text)
    {
        $this->_child[]=htmlspecialchars($text);
        return $this;
    }

    public function html($html)
    {
        $this->_child[]=$html;
        return $this;
    }

    public function _class($class)
    {
        $this->_class[]=$class;
        return $this;
    }
    
}
