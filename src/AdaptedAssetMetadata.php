<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge;

use Contentful\Delivery\SystemProperties\Asset;
use Markup\Contentful\MetadataInterface;
use Markup\ContentfulSdkBridge\Component\ContentTypeTrait;
use Markup\ContentfulSdkBridge\Component\EditedTrait;
use Markup\ContentfulSdkBridge\Component\RevisionTrait;
use Markup\ContentfulSdkBridge\Component\SpaceTrait;
use Markup\ContentfulSdkBridge\Component\SystemPropertiesTrait;

class AdaptedAssetMetadata implements MetadataInterface
{
    use ContentTypeTrait;
    use EditedTrait;
    use RevisionTrait;
    use SpaceTrait;
    use SystemPropertiesTrait;

    /**
     * @var Asset
     */
    private $assetSys;

    /**
     * @var string
     */
    private $locale;

    public function __construct(Asset $assetSys, string $locale)
    {
        $this->assetSys = $assetSys;
        $this->locale = $locale;
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
     * The single locale of this resource, if there is one.
     *
     * @return string|null
     */
    public function getLocale()
    {
        return $this->locale;
    }

    protected function getSdkObject()
    {
        return $this->assetSys;
    }
}
