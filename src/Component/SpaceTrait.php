<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Component;

use Markup\Contentful\SpaceInterface;
use Markup\ContentfulSdkBridge\AdaptedSpace;

trait SpaceTrait
{
    abstract protected function getSdkObject();

    /**
     * Gets the space this resource is associated with.
     *
     * @return SpaceInterface
     */
    public function getSpace()
    {
        return new AdaptedSpace($this->getSdkObject()->getSpace());
    }
}
