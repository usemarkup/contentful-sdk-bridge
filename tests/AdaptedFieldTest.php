<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Delivery\Resource\ContentType\Field;
use Markup\Contentful\ContentTypeFieldInterface;
use Markup\ContentfulSdkBridge\AdaptedField;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AdaptedFieldTest extends MockeryTestCase
{
    /**
     * @var Field|m\MockInterface
     */
    private $sdkField;

    /**
     * @var AdaptedField
     */
    private $adapted;

    protected function setUp()
    {
        $this->sdkField = m::spy(Field::class);
        $this->adapted = new AdaptedField($this->sdkField);
    }

    public function testIsContentTypeField()
    {
        $this->assertInstanceOf(ContentTypeFieldInterface::class, $this->adapted);
    }

    public function testGetId()
    {
        $id = 'kjlghfskjfhdskljh';
        $this->sdkField
            ->shouldReceive('getId')
            ->andReturn($id);
        $this->assertEquals($id, $this->adapted->getId());
    }

    public function testGetType()
    {
        $type = 'i_am_a_type';
        $this->sdkField
            ->shouldReceive('getType')
            ->andReturn($type);
        $this->assertEquals($type, $this->adapted->getType());
    }

    public function testGetName()
    {
        $name = 'this is the name';
        $this->sdkField
            ->shouldReceive('getName')
            ->andReturn($name);
        $this->assertEquals($name, $this->adapted->getName());
    }

    public function testIsLocalized()
    {
        $this->sdkField
            ->shouldReceive('isLocalized')
            ->andReturnTrue();
        $this->assertTrue($this->adapted->isLocalized());
    }

    public function testIsRequired()
    {
        $this->sdkField
            ->shouldReceive('isRequired')
            ->andReturnTrue();
        $this->assertTrue($this->adapted->isRequired());
    }

    public function testGetItemsWhenItemTypeEmpty()
    {
        $this->sdkField
            ->shouldReceive('getItemsType')
            ->andReturnNull();
        $this->assertEquals([], $this->adapted->getItems());
    }

    public function testGetItemsWhenItemTypeNonLink()
    {
        $type = 'Symbol';
        $this->sdkField
            ->shouldReceive('getItemsType')
            ->andReturn($type);
        $this->assertEquals(['type' => $type], $this->adapted->getItems());
    }

    public function testGetItemsWhenItemTypeLink()
    {
        $type = 'Link';
        $linkType = 'Asset';
        $this->sdkField
            ->shouldReceive('getItemsType')
            ->andReturn($type);
        $this->sdkField
            ->shouldReceive('getItemsLinkType')
            ->andReturn($linkType);
        $this->assertEquals([
            'type' => $type,
            'linkType' => $linkType,
        ], $this->adapted->getItems());
    }
}
