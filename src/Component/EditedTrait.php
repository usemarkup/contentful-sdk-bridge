<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Component;

trait EditedTrait
{
    abstract protected function getSdkObject();

    /**
     * The time this resource was created.
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt()
    {
        return $this->getSdkObject()->getCreatedAt();
    }

    /**
     * The time this resource was last updated.
     *
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt()
    {
        return $this->getSdkObject()->getUpdatedAt();
    }
}
