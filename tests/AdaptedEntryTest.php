<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Delivery\Resource\Entry;
use Markup\Contentful\EntryInterface as MarkupEntry;
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
     * @var AdaptedEntry
     */
    private $adapted;

    protected function setUp()
    {
        $this->sdkEntry = m::spy(Entry::class);
        $this->locale = 'en_GB';
        $this->adapted = new AdaptedEntry($this->sdkEntry, $this->locale);
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
        $this->assertEquals($fieldValue, $this->adapted[$fieldName]);
    }
}