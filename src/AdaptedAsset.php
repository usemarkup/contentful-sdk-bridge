<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge;

use Contentful\Core\File\File;
use Contentful\Core\File\ImageFile;
use Contentful\Delivery\Resource\Asset;
use Markup\Contentful\AssetInterface;
use Markup\Contentful\ImageApiOptions;
use Markup\ContentfulSdkBridge\Component\MetadataTrait;
use Markup\ContentfulSdkBridge\Component\SdkUrlOptions;

class AdaptedAsset implements AssetInterface
{
    use MetadataTrait;

    /**
     * @var Asset
     */
    private $asset;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var AdaptedAssetMetadata
     */
    private $metadata;

    public function __construct(Asset $asset, string $locale)
    {
        $this->asset = $asset;
        $this->locale = $locale;
        $this->metadata = new AdaptedAssetMetadata($asset->getSystemProperties(), $locale);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->asset->getTitle($this->locale) ?: '';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->asset->getDescription($this->locale) ?: '';
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        $file = $this->asset->getFile($this->locale);
        if (!$file) {
            return '';
        }

        return $file->getFileName();
    }

    /**
     * Gets the "contentType" of the asset. This is a MIME type, *not* a Contentful content type.
     *
     * @return string
     */
    public function getMimeType()
    {
        $file = $this->asset->getFile($this->locale);
        if (!$file) {
            return '';
        }

        return $file->getContentType();
    }

    /**
     * @param array|ImageApiOptions $imageApiOptions Options for rendering the image using the Image API @see http://docs.contentfulimagesapi.apiary.io/
     * @return string
     */
    public function getUrl($imageApiOptions = null)
    {
        $file = $this->asset->getFile($this->locale);
        if (!$file instanceof ImageFile) {
            return '';
        }
        if (!$imageApiOptions) {
            return $file->getUrl();
        }

        return $file->getUrl(new SdkUrlOptions(
            ($imageApiOptions instanceof ImageApiOptions)
                ? $imageApiOptions
                : ImageApiOptions::createFromHumanOptions($imageApiOptions)
        ));
    }

    /**
     * @return array
     */
    public function getDetails()
    {
        $details = [];
        $width = $this->getWidth();
        $height = $this->getHeight();
        if ($width && $height) {
            $details['image'] = [
                'width' => $width,
                'height' => $height,
            ];
        }
        $fileSize = $this->getFileSizeInBytes();
        if ($fileSize) {
            $details['size'] = $fileSize;
        }

        return $details;
    }

    /**
     * @return int
     */
    public function getFileSizeInBytes()
    {
        $file = $this->asset->getFile($this->locale);
        if (!$file instanceof File) {
            return 0;
        }

        return $file->getSize();
    }

    /**
     * @return int|null
     */
    public function getWidth()
    {
        $file = $this->asset->getFile($this->locale);
        if (!$file instanceof ImageFile) {
            return null;
        }

        return $file->getWidth();
    }

    /**
     * @return int|null
     */
    public function getHeight()
    {
        $file = $this->asset->getFile($this->locale);
        if (!$file instanceof ImageFile) {
            return null;
        }

        return $file->getHeight();
    }

    /**
     * @return float|null
     */
    public function getRatio()
    {
        $width = $this->getWidth();
        $height = $this->getHeight();
        if (!$width || !$height) {
            return null;
        }

        return (float) $width/$height;
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

    protected function getMetadata()
    {
        return $this->metadata;
    }
}
