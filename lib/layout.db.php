<?php
/**
 * @author stefan truong
 * @version 1
 **/
require_once('./../config.php');

class Layout {
    public $name;
    public $background_image;
    public $datetime;
    public $x1;
    public $y1;
    public $x2;
    public $y2;
    public $w;
    public $h;
    public $id;
    public $l;
    public $color;
    public $d;
    public $r;
    	
	public function __construct() {
		global $config;
	    $this->name = $config['name'];	
	    $this->background_image = $config['background_image'];
	    $this->datetime = time();
	  	$this->x1 = $config['x1'];
	  	$this->y1 = $config['y1'];
	  	$this->x2 = $config['x2'];
	  	$this->y2 = $config['y2'];
	  	$this->w = $config['w'];
	  	$this->h = $config['h'];
        $this->id = $config['id'];
        $this->l = $config['l'];
        $this->color = '#FFFFFF';
	  	$this->d = 1;
        $this->r = 0;
	}

	public function set_name($name) {
        $this->name = $name;
        return $this;
    }

    public function set_l($l) {
        $this->l = $l;
        return $this;
    }

    public function set_color($color) {
        $this->color = $color;
        return $this;
    }

    public function set_d($d) {
        $this->d = $d;
        return $this;
    }

    public function set_r($r) {
        $this->r = $r;
        return $this;
    }

    public function set_background_image($background_image) {
        $this->background_image = $background_image;
        return $this;
    }

    public function set_datetime($datetime) {
        $this->datetime = $datetime;
        return $this;
    }

    //place info of text
    public function set_x1($x1) {
        $this->x1 = $x1;
        return $this;
    }

    public function set_y1($y1) {
        $this->y1 = $y1;
        return $this;
    }

    public function set_x2($x2) {
        $this->x2 = $x2;
        return $this;
    }

    public function set_y2($y2) {
        $this->y2 = $y2;
        return $this;
    }

    public function set_w($w) {
        $this->w = $w;
        return $this;
    }

    public function set_h($h) {
        $this->h = $h;
        return $this;
    } 

    public function set_id($id) {
        $this->id = $id;
        return $this;
    }

    public function getAllData(){
    	return array(
	    		'name'=>$this->name,
	    		'background_image'=>$this->background_image,
                'datetime'=>$this->datetime,
                'color'=>$this->color,
                'r'=>$this->r,
	    		'd'=>$this->d,
	    		'x1'=>$this->x1,
	    		'x2'=>$this->x2,
	    		'y1'=>$this->y1,
	    		'y2'=>$this->y2,
	    		'w'=>$this->w,
                'id'=>$this->id,
	    		'l'=>$this->l,
	    		'h'=>$this->h
    		);
    }

}
?>
