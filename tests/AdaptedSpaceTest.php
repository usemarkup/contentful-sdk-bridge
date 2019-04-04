<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Delivery\Resource\Space;
use Markup\Contentful\SpaceInterface;
use Markup\ContentfulSdkBridge\AdaptedSpace;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AdaptedSpaceTest extends MockeryTestCase
{
    /**
     * @var Space|m\MockInterface
     */
    private $space;

    /**
     * @var AdaptedSpace
     */
    private $adapted;

    protected function setUp()
    {
        $this->space = m::spy(Space::class);
        $this->adapted = new AdaptedSpace($this->space);
    }

    public function testIsSpace()
    {
        $this->assertInstanceOf(SpaceInterface::class, $this->adapted);
    }

    public function testGetType()
    {
        $type = 'i_am_a_type';
        $this->space
            ->shouldReceive('getType')
            ->andReturn($type);
        $this->assertEquals($type, $this->adapted->getType());
    }

    public function testGetId()
    {
        $id = 'it_is_42';
        $this->space
            ->shouldReceive('getId')
            ->andReturn($id);
        $this->assertEquals($id, $this->adapted->getId());
    }

    public function testGetSpaceGetsSelf()
    {
        $this->assertSame($this->adapted, $this->adapted->getSpace());
    }

    public function testGetName()
    {
        $name = 'outer_space';
        $this->space
            ->shouldReceive('getName')
            ->andReturn($name);
        $this->assertEquals($name, $this->adapted->getName());
    }
}
