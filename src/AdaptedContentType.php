<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge;

use Contentful\Delivery\Resource\ContentType;
use Markup\Contentful\ContentTypeFieldInterface;
use Markup\Contentful\ContentTypeInterface;
use Markup\ContentfulSdkBridge\Component\EditedTrait;
use Markup\ContentfulSdkBridge\Component\SpaceTrait;
use Markup\ContentfulSdkBridge\Component\SystemPropertiesTrait;

class AdaptedContentType implements ContentTypeInterface
{
    use EditedTrait;
    use SpaceTrait;
    use SystemPropertiesTrait;

    /**
     * @var ContentType
     */
    private $sdkContentType;

    public function __construct(ContentType $sdkContentType)
    {
        $this->sdkContentType = $sdkContentType;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->sdkContentType->getName();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->sdkContentType->getDescription();
    }

    /**
     * Returns the content type fields, keyed by ID.
     *
     * @return ContentTypeFieldInterface[]
     */
    public function getFields()
    {
        return array_map(
            function (ContentType\Field $field) {
                return new AdaptedField($field);
            },
            $this->sdkContentType->getFields()
        );
    }

    /**
     * Returns the content type field matching the passed ID, or null if field does not exist.
     *
     * @param string $fieldId
     * @return ContentTypeFieldInterface|null
     */
    public function getField($fieldId)
    {
        $field = $this->sdkContentType->getField($fieldId);
        if ($field === null) {
            return null;
        }

        return new AdaptedField($field);
    }

    /**
     * @return ContentTypeFieldInterface|null
     */
    public function getDisplayField()
    {
        $field = $this->sdkContentType->getDisplayField();
        if ($field === null) {
            return null;
        }

        return new AdaptedField($field);
    }

    /**
     * Gets the content type for an entry. (Only applicable for Entry resources.)
     *
     * @return ContentTypeInterface|null
     */
    public function getContentType()
    {
        return $this;
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
     * The single locale of this resource, if there is one.
     *
     * @return string|null
     */
    public function getLocale()
    {
        return null;
    }

    protected function getSdkObject()
    {
        return $this->sdkContentType;
    }
}
