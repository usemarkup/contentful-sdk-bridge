<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge;

use Contentful\Delivery\SystemProperties\Entry;
use Markup\Contentful\MetadataInterface;
use Markup\ContentfulSdkBridge\Component\ContentTypeTrait;
use Markup\ContentfulSdkBridge\Component\EditedTrait;
use Markup\ContentfulSdkBridge\Component\RevisionTrait;
use Markup\ContentfulSdkBridge\Component\SpaceTrait;
use Markup\ContentfulSdkBridge\Component\SystemPropertiesTrait;

class AdaptedEntryMetadata implements MetadataInterface
{
    use ContentTypeTrait;
    use EditedTrait;
    use RevisionTrait;
    use SpaceTrait;
    use SystemPropertiesTrait;

    /**
     * @var Entry
     */
    private $entrySys;

    /**
     * @var string|null
     */
    private $locale;

    public function __construct(Entry $entrySys, ?string $locale = null)
    {
        $this->entrySys = $entrySys;
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
        return $this->entrySys;
    }
}
