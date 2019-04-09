<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge;

use Contentful\Core\Api\Link;
use Contentful\Delivery\Resource\Entry as SdkEntry;
use Markup\Contentful\DisallowArrayAccessMutationTrait;
use Markup\Contentful\EntryInterface as MarkupEntry;
use Markup\Contentful\EntryUnknownMethodTrait;
use Markup\ContentfulSdkBridge\Component\MetadataTrait;

class AdaptedEntry implements MarkupEntry
{
    use DisallowArrayAccessMutationTrait;
    use EntryUnknownMethodTrait;
    use MetadataTrait;

    /**
     * @var SdkEntry
     */
    private $sdkEntry;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $space;

    /**
     * @var AdaptedEntryMetadata
     */
    private $metadata;

    public function __construct(SdkEntry $sdkEntry, string $locale, string $space)
    {
        $this->sdkEntry = $sdkEntry;
        $this->locale = $locale;
        $this->space = $space;
        $this->metadata = new AdaptedEntryMetadata($sdkEntry->getSystemProperties(), $locale);
    }

    public function offsetExists($offset)
    {
        return $this->sdkEntry->has($offset, $this->locale, false);
    }

    public function offsetGet($offset)
    {
        return $this->getField($offset);
    }

    /**
     * Gets the list of field values in the entry, keyed by fields. Could be scalars, DateTime objects, or links.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->sdkEntry->all($this->locale, false);

    }

    /**
     * Gets an individual field value, or null if the field is not defined.
     *
     * @return mixed
     */
    public function getField($key)
    {
        $value = $this->sdkEntry->get(
            $key,
            ($this->isFieldLocalized($key)) ? $this->locale : null,
            false
        );
        if ($value instanceof Link) {
            return new AdaptedLink($value, $this->space);
        }

        return $value;
    }

    protected function getMetadata(): AdaptedEntryMetadata
    {
        return $this->metadata;
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

    private function isFieldLocalized($key): bool
    {
        $field = $this->sdkEntry
            ->getSystemProperties()
            ->getContentType()
            ->getField($key, true);
        if (!$field) {
            return false;
        }

        return $field->isLocalized();
    }
}
