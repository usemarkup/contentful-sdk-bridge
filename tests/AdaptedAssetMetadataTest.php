<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Core\Api\DateTimeImmutable;
use Contentful\Delivery\Resource\ContentType;
use Contentful\Delivery\Resource\Space;
use Contentful\Delivery\SystemProperties\Asset;
use Markup\Contentful\ContentTypeInterface;
use Markup\Contentful\MetadataInterface;
use Markup\Contentful\SpaceInterface;
use Markup\ContentfulSdkBridge\AdaptedAssetMetadata;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AdaptedAssetMetadataTest extends MockeryTestCase
{
    /**
     * @var Asset|m/MockInterface
     */
    private $assetSys;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var AdaptedAssetMetadata
     */
    private $metadata;

    protected function setUp()
    {
        $this->assetSys = m::spy(Asset::class);
        $this->locale = 'en_CA';
        $this->metadata = new AdaptedAssetMetadata(
            $this->assetSys,
            $this->locale
        );
    }

    public function testIsMetadata()
    {
        $this->assertInstanceOf(MetadataInterface::class, $this->metadata);
    }

    public function testGetId()
    {
        $id = '45645';
        $this->assetSys
            ->shouldReceive('getId')
            ->andReturn($id);
        $this->assertEquals($id, $this->metadata->getId());
    }

    public function testGetType()
    {
        $type = 'Symbol';
        $this->assetSys
            ->shouldReceive('getType')
            ->andReturn($type);
        $this->assertEquals($type, $this->metadata->getType());
    }

    public function testGetSpace()
    {
        $space = m::mock(Space::class);
        $this->assetSys
            ->shouldReceive('getSpace')
            ->andReturn($space);
        $this->assertInstanceOf(SpaceInterface::class, $this->metadata->getSpace());
    }

    public function testGetContentType()
    {
        $sdkContentType = m::mock(ContentType::class);
        $this->assetSys
            ->shouldReceive('getContentType')
            ->andReturn($sdkContentType);
        $this->assertInstanceOf(ContentTypeInterface::class, $this->metadata->getContentType());
    }

    public function testGetRevision()
    {
        $revision = 45;
        $this->assetSys
            ->shouldReceive('getRevision')
            ->andReturn($revision);
        $this->assertEquals($revision, $this->metadata->getRevision());
    }

    public function testGetLocale()
    {
        $this->assertEquals($this->locale, $this->metadata->getLocale());
    }

    public function testGetCreatedAt()
    {
        $created = m::mock(DateTimeImmutable::class);
        $this->assetSys
            ->shouldReceive('getCreatedAt')
            ->andReturn($created);
        $this->assertSame($created, $this->metadata->getCreatedAt());
    }

    public function testGetUpdatedAt()
    {
        $updated = m::mock(DateTimeImmutable::class);
        $this->assetSys
            ->shouldReceive('getUpdatedAt')
            ->andReturn($updated);
        $this->assertSame($updated, $this->metadata->getUpdatedAt());
    }
}
