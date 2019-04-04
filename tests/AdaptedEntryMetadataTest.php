<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Core\Api\DateTimeImmutable;
use Contentful\Delivery\Resource\ContentType;
use Contentful\Delivery\Resource\Space;
use Contentful\Delivery\SystemProperties\Entry;
use Markup\Contentful\ContentTypeInterface;
use Markup\Contentful\MetadataInterface;
use Markup\Contentful\SpaceInterface;
use Markup\ContentfulSdkBridge\AdaptedEntryMetadata;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AdaptedEntryMetadataTest extends MockeryTestCase
{
    /**
     * @var Entry|m\MockInterface
     */
    private $entrySys;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var AdaptedEntryMetadata
     */
    private $metadata;

    protected function setUp()
    {
        $this->entrySys = m::spy(Entry::class);
        $this->locale = 'sv_SE';
        $this->metadata = new AdaptedEntryMetadata($this->entrySys, $this->locale);
    }

    public function testIsMetadata()
    {
        $this->assertInstanceOf(MetadataInterface::class, $this->metadata);
    }

    public function testGetType()
    {
        $type = 'i_am_a_type';
        $this->entrySys
            ->shouldReceive('getType')
            ->andReturn($type);
        $this->assertEquals($type, $this->metadata->getType());
    }

    public function testGetId()
    {
        $id = 'it_is_42';
        $this->entrySys
            ->shouldReceive('getId')
            ->andReturn($id);
        $this->assertEquals($id, $this->metadata->getId());
    }

    public function testGetRevision()
    {
        $revision = 667;
        $this->entrySys
            ->shouldReceive('getRevision')
            ->andReturn($revision);
        $this->assertEquals($revision, $this->metadata->getRevision());
    }

    public function testGetLocale()
    {
        $this->assertEquals($this->locale, $this->metadata->getLocale());
    }

    public function testGetSpace()
    {
        $sdkSpace = m::mock(Space::class);
        $this->entrySys
            ->shouldReceive('getSpace')
            ->andReturn($sdkSpace);
        $this->assertInstanceOf(SpaceInterface::class, $this->metadata->getSpace());
    }

    public function testGetContentType()
    {
        $sdkContentType = m::mock(ContentType::class);
        $this->entrySys
            ->shouldReceive('getContentType')
            ->andReturn($sdkContentType);
        $this->assertInstanceOf(ContentTypeInterface::class, $this->metadata->getContentType());
    }

    public function testGetCreatedAt()
    {
        $created = m::mock(DateTimeImmutable::class);
        $this->entrySys
            ->shouldReceive('getCreatedAt')
            ->andReturn($created);
        $this->assertSame($created, $this->metadata->getCreatedAt());
    }

    public function testGetUpdatedAt()
    {
        $updated = m::mock(DateTimeImmutable::class);
        $this->entrySys
            ->shouldReceive('getUpdatedAt')
            ->andReturn($updated);
        $this->assertSame($updated, $this->metadata->getUpdatedAt());
    }
}
