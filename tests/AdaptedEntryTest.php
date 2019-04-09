<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Core\Api\Link;
use Contentful\Delivery\Resource\ContentType\Field;
use Contentful\Delivery\Resource\Entry;
use Markup\Contentful\EntryInterface as MarkupEntry;
use Markup\Contentful\LinkInterface;
use Markup\ContentfulSdkBridge\AdaptedEntry;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AdaptedEntryTest extends MockeryTestCase
{
    /**
     * @var Entry|m\MockInterface
     */
    private $sdkEntry;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $space;

    /**
     * @var AdaptedEntry
     */
    private $adapted;

    protected function setUp()
    {
        $this->sdkEntry = m::spy(Entry::class);
        $this->locale = 'en_GB';
        $this->space = 'i_am_a_space';
        $this->adapted = new AdaptedEntry($this->sdkEntry, $this->locale, $this->space);
    }

    public function testIsMarkupEntry()
    {
        $this->assertInstanceOf(MarkupEntry::class, $this->adapted);
    }

    public function testGetLocale()
    {
        $this->assertEquals($this->locale, $this->adapted->getLocale());
    }

    public function testGetFields()
    {
        $fields = ['this' => 'that', 'up' => 'down'];
        $this->sdkEntry
            ->shouldReceive('all')
            ->with($this->locale, false)
            ->andReturn($fields);
        $this->assertEquals($fields, $this->adapted->getFields());
    }

    public function testGetField()
    {
        $fieldName = 'field';
        $fieldValue = 'value';
        $this->sdkEntry
            ->shouldReceive('get')
            ->with($fieldName, $this->locale, false)
            ->andReturn($fieldValue);
        $this->setUpFieldOnSdkEntry($this->sdkEntry);
        $this->assertEquals($fieldValue, $this->adapted->getField($fieldName));
    }

    public function testOffsetExists()
    {
        $fieldName = 'field';
        $this->sdkEntry
            ->shouldReceive('has')
            ->once()
            ->with($fieldName, $this->locale, false)
            ->andReturnTrue();
        $this->assertTrue(isset($this->adapted[$fieldName]));
    }

    public function testOffsetGet()
    {
        $fieldName = 'field';
        $fieldValue = 'value';
        $this->sdkEntry
            ->shouldReceive('get')
            ->with($fieldName, $this->locale, false)
            ->andReturn($fieldValue);
        $this->setUpFieldOnSdkEntry($this->sdkEntry);
        $this->assertEquals($fieldValue, $this->adapted[$fieldName]);
    }

    public function testAdaptsLink()
    {
        $link = m::mock(Link::class);
        $fieldName = 'field';
        $this->sdkEntry
            ->shouldReceive('get')
            ->with($fieldName, $this->locale, false)
            ->andReturn($link);
        $this->setUpFieldOnSdkEntry($this->sdkEntry);
        $this->assertInstanceOf(LinkInterface::class, $this->adapted->getField($fieldName));
    }

    private function setUpFieldOnSdkEntry(m\MockInterface $entry)
    {
        $field = m::mock(Field::class)
            ->shouldReceive('isLocalized')
            ->andReturnTrue()
            ->getMock();
        $entry
            ->shouldReceive('getSystemProperties->getContentType->getField')
            ->andReturn($field);
    }
}
