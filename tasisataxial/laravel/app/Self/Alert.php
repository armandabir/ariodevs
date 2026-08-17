<?php
namespace App\Self;

Class Alert {

    static protected $string;
    static protected $icon;
    static protected $title;


    static public function message($icon,$string,$title){

        self::$string=$string;
        self::$icon=$icon;
        self::$title=$title;
        return new static;

    }

    public function show(){
        session()->flash("title",self::$title);
        session()->flash("string",self::$string);
        session()->flash("icon",self::$icon);
    }

    public function save(){
        session()->keep("title",self::$title);
        session()->keep("string",self::$string);
        session()->keep("icon",self::$icon);
    }

}
