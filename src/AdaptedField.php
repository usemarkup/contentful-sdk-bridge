<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge;

use Contentful\Delivery\Resource\ContentType\Field;
use Markup\Contentful\ContentTypeFieldInterface;
use Markup\ContentfulSdkBridge\Component\SystemPropertiesTrait;

class AdaptedField implements ContentTypeFieldInterface
{
    use SystemPropertiesTrait;

    /**
     * @var Field
     */
    private $sdkField;

    public function __construct(Field $sdkField)
    {
        $this->sdkField = $sdkField;
    }

    public function getName(): string
    {
        return $this->sdkField->getName();
    }

    public function getItems(): array
    {
        $itemType = $this->sdkField->getItemsType();
        $items = [];
        if ($itemType === null) {
            return $items;
        }
        $items['type'] = $itemType;
        if ($itemType === 'Link') {
            $items['linkType'] = $this->sdkField->getItemsLinkType();
        }

        return $items;
    }

    public function isLocalized(): bool
    {
        return $this->sdkField->isLocalized();
    }

    public function isRequired(): bool
    {
        return $this->sdkField->isRequired();
    }

    protected function getSdkObject()
    {
        return $this->sdkField;
    }
}
