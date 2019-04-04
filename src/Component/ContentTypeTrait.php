<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Component;

use Markup\Contentful\ContentTypeInterface;
use Markup\ContentfulSdkBridge\AdaptedContentType;

trait ContentTypeTrait
{
    abstract protected function getSdkObject();

    /**
     * Gets the content type for an entry. (Only applicable for Entry resources.)
     *
     * @return ContentTypeInterface|null
     */
    public function getContentType()
    {
        return new AdaptedContentType($this->getSdkObject()->getContentType());
    }
}
