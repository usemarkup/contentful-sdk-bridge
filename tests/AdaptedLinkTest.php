<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Tests;

use Contentful\Core\Api\Link;
use Markup\Contentful\LinkInterface;
use Markup\ContentfulSdkBridge\AdaptedLink;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AdaptedLinkTest extends MockeryTestCase
{
    /**
     * @var Link|m\MockInterface
     */
    private $link;

    /**
     * @var string
     */
    private $space;

    /**
     * @var AdaptedLink
     */
    private $adapted;

    protected function setUp()
    {
        $this->link = m::spy(Link::class);
        $this->space = 'i_am_a_space';
        $this->adapted = new AdaptedLink(
            $this->link,
            $this->space
        );
    }

    public function testIsLink()
    {
        $this->assertInstanceOf(LinkInterface::class, $this->adapted);
    }

    public function testGetId()
    {
        $id = 'id42';
        $this->link
            ->shouldReceive('getId')
            ->andReturn($id);
        $this->assertEquals($id, $this->adapted->getId());
    }

    public function testGetLinkType()
    {
        $linkType = 'Asset';
        $this->link
            ->shouldReceive('getLinkType')
            ->andReturn($linkType);
        $this->assertEquals($linkType, $this->adapted->getLinkType());
    }

    public function testGetSpaceName()
    {
        $this->assertEquals($this->space, $this->adapted->getSpaceName());
    }
}
