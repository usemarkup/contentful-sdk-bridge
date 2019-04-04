<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests\Component;

use Contentful\Core\File\UrlOptionsInterface;
use Markup\Contentful\ImageApiOptions;
use Markup\ContentfulSdkBridge\Component\SdkUrlOptions;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class SdkUrlOptionsTest extends MockeryTestCase
{
    /**
     * @var ImageApiOptions
     */
    private $apiOptions;

    /**
     * @var SdkUrlOptions
     */
    private $sdkOptions;

    protected function setUp()
    {
        $this->apiOptions = m::spy(ImageApiOptions::class);
        $this->sdkOptions = new SdkUrlOptions($this->apiOptions);
    }

    public function testIsUrlOptions()
    {
        $this->assertInstanceOf(UrlOptionsInterface::class, $this->sdkOptions);
    }

    public function testGetQueryString()
    {
        $apiOptions = new ImageApiOptions();
        $apiOptions->setWidth(80);
        $apiOptions->setHeight(100);
        $expectedString = 'w=80&h=100';
        $sdkOptions = new SdkUrlOptions($apiOptions);
        $this->assertEquals($expectedString, $sdkOptions->getQueryString());
    }
}
