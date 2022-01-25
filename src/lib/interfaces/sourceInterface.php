<?php


namespace andyp\sidebarmenu\lib\interfaces;

interface sourceInterface { 

    public function config($config);
    public function options_data($options_data);
    public function run();
    public function out();

}