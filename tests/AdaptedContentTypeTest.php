<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Delivery\Resource\ContentType;
use Contentful\Delivery\Resource\Space;
use Markup\Contentful\ContentTypeInterface;
use Markup\Contentful\SpaceInterface;
use Markup\ContentfulSdkBridge\AdaptedContentType;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AdaptedContentTypeTest extends MockeryTestCase
{
    /**
     * @var ContentType|m\MockInterface
     */
    private $sdkContentType;

    /**
     * @var AdaptedContentType
     */
    private $adapted;

    protected function setUp()
    {
        $this->sdkContentType = m::spy(ContentType::class);
        $this->adapted = new AdaptedContentType($this->sdkContentType);
    }

    public function testIsContentType()
    {
        $this->assertInstanceOf(ContentTypeInterface::class, $this->adapted);
    }

    public function testGetName()
    {
        $name = 'billy_the_content_type';
        $this->sdkContentType
            ->shouldReceive('getName')
            ->andReturn($name);
        $this->assertEquals($name, $this->adapted->getName());
    }

    public function testGetDescription()
    {
        $description = 'This is a description for a test content type';
        $this->sdkContentType
            ->shouldReceive('getDescription')
            ->andReturn($description);
        $this->assertEquals($description, $this->adapted->getDescription());
    }

    public function testGetId()
    {
        $id = 'the_id';
        $this->sdkContentType
            ->shouldReceive('getId')
            ->andReturn($id);
        $this->assertEquals($id, $this->adapted->getId());
    }

    public function testGetContentTypeGetsSelf()
    {
        $this->assertSame($this->adapted, $this->adapted->getContentType());
    }

    public function testGetSpace()
    {
        $sdkSpace = m::mock(Space::class);
        $this->sdkContentType
            ->shouldReceive('getSpace')
            ->andReturn($sdkSpace);
        $this->assertInstanceOf(SpaceInterface::class, $this->adapted->getSpace());
    }

    public function testGetType()
    {
        $type = 'i_am_a_type';
        $this->sdkContentType
            ->shouldReceive('getType')
            ->andReturn($type);
        $this->assertEquals($type, $this->adapted->getType());
    }
}
