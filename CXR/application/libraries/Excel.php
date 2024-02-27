<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'PHPExcel.php';

require_once 'PHPExcel/IOFactory.php';

class Excel extends PHPExcel
{
   public function __construct()
   {
       parent:: __construct();
   }
}

class IOFactory extends PHPExcel_IOFactory
{
    public function __construct()
    {
        //    parent:: __construct();
    }
}