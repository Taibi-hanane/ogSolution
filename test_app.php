<?php
use PHPUnit\Framework\TestCase;
require "app.php";

class StringTest extends TestCase {

    public function test_app()
    {

        $output = array('1', '0.46180844185832', '1.6574127786525', '2.4014038976632', '43.714413735069');

        $this->assertEquals($output, $array_push);
    }

}