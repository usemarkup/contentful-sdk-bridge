<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge;

use Contentful\Core\Api\Link;
use Markup\Contentful\LinkInterface;

class AdaptedLink implements LinkInterface
{
    /**
     * @var Link
     */
    private $link;

    /**
     * @var string
     */
    private $space;

    public function __construct(Link $link, string $space)
    {
        $this->link = $link;
        $this->space = $space;
    }

    public function getId()
    {
        return $this->link->getId();
    }

    public function getLinkType()
    {
        return $this->link->getLinkType();
    }

    public function getSpaceName()
    {
        return $this->space;
    }
}
