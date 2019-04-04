<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Component;

use Markup\Contentful\ContentTypeInterface;
use Markup\Contentful\SpaceInterface;

trait MetadataTrait
{
    abstract protected function getMetadata();

    /**
     * Gets the type of resource.
     *
     * @return string
     */
    public function getType()
    {
        return $this->getMetadata()->getType();
    }

    /**
     * Gets the unique ID of the resource.
     *
     * @return string
     */
    public function getId()
    {
        return $this->getMetadata()->getId();
    }

    /**
     * Gets the space this resource is associated with.
     *
     * @return SpaceInterface
     */
    public function getSpace()
    {
        return $this->getMetadata()->getSpace();
    }

    /**
     * Gets the content type for an entry. (Only applicable for Entry resources.)
     *
     * @return ContentTypeInterface|null
     */
    public function getContentType()
    {
        return $this->getMetadata()->getContentType();
    }

    /**
     * Gets the link type. (Only applicable for Link resources.)
     *
     * @return string|null
     */
    public function getLinkType()
    {
        return $this->getMetadata()->getLinkType();
    }

    /**
     * Gets the revision number of this resource.
     *
     * @return int
     */
    public function getRevision()
    {
        return $this->getMetadata()->getRevision();
    }

    /**
     * The time this resource was created.
     *
     * @return \DateTimeInterface}null
     */
    public function getCreatedAt()
    {
        return $this->getMetadata()->getCreatedAt();
    }

    /**
     * The time this resource was last updated.
     *
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt()
    {
        return $this->getMetadata()->getUpdatedAt();
    }

    /**
     * The single locale of this resource, if there is one.
     *
     * @return string|null
     */
    public function getLocale()
    {
        return $this->getMetadata()->getLocale();
    }
}
