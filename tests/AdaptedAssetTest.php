<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Core\File\File;
use Contentful\Core\File\FileInterface;
use Contentful\Core\File\ImageFile;
use Contentful\Core\File\UrlOptionsInterface;
use Contentful\Delivery\Resource\Asset;
use Markup\Contentful\AssetInterface;
use Markup\ContentfulSdkBridge\AdaptedAsset;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AdaptedAssetTest extends MockeryTestCase
{
    /**
     * @var Asset|m\MockInterface
     */
    private $sdkAsset;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var AdaptedAsset
     */
    private $adapted;

    protected function setUp()
    {
        $this->sdkAsset = m::spy(Asset::class);
        $this->locale = 'fr_FR';
        $this->adapted = new AdaptedAsset($this->sdkAsset, $this->locale);
    }

    public function testIsAsset()
    {
        $this->assertInstanceOf(AssetInterface::class, $this->adapted);
    }

    public function testGetLocale()
    {
        $this->assertEquals($this->locale, $this->adapted->getLocale());
    }

    public function testGetTitle()
    {
        $title = 'i am the asset title';
        $this->sdkAsset
            ->shouldReceive('getTitle')
            ->with($this->locale)
            ->andReturn($title);
        $this->assertEquals($title, $this->adapted->getTitle());
    }

    public function testGetDescription()
    {
        $description = 'it is a tall tower it is the eiffel tower';
        $this->sdkAsset
            ->shouldReceive('getDescription')
            ->with($this->locale)
            ->andReturn($description);
        $this->assertEquals($description, $this->adapted->getDescription());
    }

    public function testGetFilenameIfFileReturned()
    {
        $filename = 'filename.jpg';
        $file = m::mock(FileInterface::class);
        $file
            ->shouldReceive('getFileName')
            ->andReturn($filename);
        $this->sdkAsset
            ->shouldReceive('getFile')
            ->with($this->locale)
            ->andReturn($file);
        $this->assertEquals($filename, $this->adapted->getFilename());
    }

    public function testGetMimeType()
    {
        $mimeType = 'image/png';
        $file = m::mock(FileInterface::class);
        $file
            ->shouldReceive('getContentType')
            ->andReturn($mimeType);
        $this->sdkAsset
            ->shouldReceive('getFile')
            ->with($this->locale)
            ->andReturn($file);
        $this->assertEquals($mimeType, $this->adapted->getMimeType());
    }

    public function testGetWidth()
    {
        $width = 78;
        $file = m::mock(ImageFile::class);
        $file
            ->shouldReceive('getWidth')
            ->andReturn($width);
        $this->sdkAsset
            ->shouldReceive('getFile')
            ->with($this->locale)
            ->andReturn($file);
        $this->assertEquals($width, $this->adapted->getWidth());
    }

    public function testGetHeight()
    {
        $height = 87;
        $file = m::mock(ImageFile::class);
        $file
            ->shouldReceive('getHeight')
            ->andReturn($height);
        $this->sdkAsset
            ->shouldReceive('getFile')
            ->with($this->locale)
            ->andReturn($file);
        $this->assertEquals($height, $this->adapted->getHeight());
    }

    public function testGetFileSizeInBytes()
    {
        $fileSizeInBytes = 45667;
        $file = m::mock(File::class);
        $file
            ->shouldReceive('getSize')
            ->andReturn($fileSizeInBytes);
        $this->sdkAsset
            ->shouldReceive('getFile')
            ->with($this->locale)
            ->andReturn($file);
        $this->assertEquals($fileSizeInBytes, $this->adapted->getFileSizeInBytes());
    }

    public function testGetUrl()
    {
        $options = [
            'width' => 75,
            'height' => 125,
        ];
        $queryString = 'w=75&h=125';
        $url = 'the_url';
        $file = m::mock(ImageFile::class);
        $file
            ->shouldReceive('getUrl')
            ->with(m::on(function ($arg) use ($queryString) {
                return $arg instanceof UrlOptionsInterface && $arg->getQueryString() === $queryString;
            }))
            ->once()
            ->andReturn($url);
        $this->sdkAsset
            ->shouldReceive('getFile')
            ->with($this->locale)
            ->andReturn($file);
        $this->assertEquals($url, $this->adapted->getUrl($options));
    }
}
