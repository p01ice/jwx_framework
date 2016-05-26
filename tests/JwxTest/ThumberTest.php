<?php

/**
 *  PHPUnit 测试
 */
class ThumberTest extends PHPUnit_Framework_TestCase
{
    // 自动测试断言
    public function testIni()
    {
        $all[0] = 1;
        $this->assertEquals(1, count($all));
    }
}
