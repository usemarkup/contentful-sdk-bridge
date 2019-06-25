<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge;

use Contentful\Delivery\Resource\Space;
use Markup\Contentful\ContentTypeInterface;
use Markup\Contentful\Locale;
use Markup\Contentful\SpaceInterface;

class AdaptedSpace implements SpaceInterface
{
    /**
     * @var Space
     */
    private $sdkSpace;

    public function __construct(Space $sdkSpace)
    {
        $this->sdkSpace = $sdkSpace;
    }

    /**
     * Gets the type of resource.
     *
     * @return string
     */
    public function getType()
    {
        return $this->sdkSpace->getType();
    }

    /**
     * Gets the unique ID of the resource.
     *
     * @return string
     */
    public function getId()
    {
        return $this->sdkSpace->getId();
    }

    /**
     * Gets the space this resource is associated with.
     *
     * @return SpaceInterface
     */
    public function getSpace()
    {
        return $this;
    }

    /**
     * Gets the content type for an entry. (Only applicable for Entry resources.)
     *
     * @return ContentTypeInterface|null
     */
    public function getContentType()
    {
        return null;
    }

    /**
     * Gets the link type. (Only applicable for Link resources.)
     *
     * @return string|null
     */
    public function getLinkType()
    {
        return null;
    }

    /**
     * Gets the revision number of this resource.
     *
     * @return int
     */
    public function getRevision()
    {
        return 1;
    }

    /**
     * The time this resource was created.
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt()
    {
        return null;
    }

    /**
     * The time this resource was last updated.
     *
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt()
    {
        return null;
    }

    /**
     * The single locale of this resource, if there is one.
     *
     * @return string|null
     */
    public function getLocale()
    {
        return null;
    }

    /**
     * Gets the name of the space.
     *
     * @return string
     */
    public function getName()
    {
        return $this->sdkSpace->getName();
    }

    /**
     * Gets the locales associated with the space.
     *
     * @return Locale[]
     */
    public function getLocales()
    {
        throw new \BadMethodCallException(__METHOD__.' not implemented');
    }

    /**
     * Gets the default locale.
     *
     * @return Locale
     */
    public function getDefaultLocale()
    {
        throw new \BadMethodCallException(__METHOD__.' not implemented');
    }

    public function getSpaceName(): string
    {
        return $this->getName();
    }
}
