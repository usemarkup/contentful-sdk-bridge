<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Component;

trait RevisionTrait
{
    abstract protected function getSdkObject();

    /**
     * Gets the revision number of this resource.
     *
     * @return int
     */
    public function getRevision()
    {
        return $this->getSdkObject()->getRevision();
    }
}
