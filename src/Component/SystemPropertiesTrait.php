<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Component;

trait SystemPropertiesTrait
{
    abstract protected function getSdkObject();

    /**
     * Gets the type of resource.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->getSdkObject()->getType();
    }

    /**
     * Gets the unique ID of the resource.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->getSdkObject()->getId();
    }
}
