<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Core\Api\Link;
use Contentful\Delivery\Resource\ContentType\Field;
use Contentful\Delivery\Resource\Entry;
use GuzzleHttp\Promise\FulfilledPromise;
use Markup\Contentful\EntryInterface as MarkupEntry;
use Markup\Contentful\EntryInterface;
use Markup\Contentful\LinkInterface;
use Markup\Contentful\ResourceEnvelopeInterface;
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
     * @var ResourceEnvelopeInterface|m\MockInterface
     */
    private $resourceEnvelope;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $space;

    /**
     * @var callable
     */
    private $resolveLinkFunction;

    /**
     * @var AdaptedEntry
     */
    private $adapted;

    protected function setUp()
    {
        $this->sdkEntry = m::spy(Entry::class);
        $this->resourceEnvelope = m::mock(ResourceEnvelopeInterface::class);
        $this->locale = 'en_GB';
        $this->space = 'i_am_a_space';
        $this->resolveLinkFunction = function (LinkInterface $link, $locale = null) {
            return new FulfilledPromise(m::mock(EntryInterface::class));
        };
        $this->adapted = new AdaptedEntry(
            $this->sdkEntry,
            $this->locale,
            $this->space,
            $this->resolveLinkFunction
        );
        $field = m::mock(Field::class)
            ->shouldReceive('isLocalized')
            ->andReturnTrue()
            ->getMock();
        $this->sdkEntry
            ->shouldReceive('getSystemProperties->getContentType->getField')
            ->andReturn($field);
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

    public function testAdaptsLink()
    {
        $linkedId = '456';
        $link = m::mock(Link::class)
            ->shouldReceive('getLinkType')
            ->andReturn('Entry')
            ->getMock()
            ->shouldReceive('getId')
            ->andReturn($linkedId)
            ->getMock();
        $fieldName = 'field';
        $this->sdkEntry
            ->shouldReceive('get')
            ->with($fieldName, $this->locale, false)
            ->andReturn($link);
        $this->assertInstanceOf(EntryInterface::class, $this->adapted->getField($fieldName));
    }

    public function testAdaptsArrayOfLinks()
    {
        $linkedId = '567';
        $link = m::mock(Link::class)
            ->shouldReceive('getLinkType')
            ->andReturn('Entry')
            ->getMock()
            ->shouldReceive('getId')
            ->andReturn($linkedId)
            ->getMock();
        $links = [$link, $link];
        $fieldName = 'field';
        $this->sdkEntry
            ->shouldReceive('get')
            ->with($fieldName, $this->locale, false)
            ->andReturn($links);
        $output = $this->adapted->getField($fieldName);
        $this->assertIsArray($output);
        $this->assertCount(2, $output);
        $this->assertContainsOnlyInstancesOf(EntryInterface::class, $output);
    }
}
