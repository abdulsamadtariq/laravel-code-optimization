<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTApi\Helpers\TeHelper;

class TeHelperTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWillExpireAt()
    {
        $dueTime="2022-11-27 09:21:08";
        $createdAt="2022-11-23 09:21:08";
        TeHelper::willExpireAt($dueTime,$createdAt);
        
        $this->assertTrue(true);
    }
}
