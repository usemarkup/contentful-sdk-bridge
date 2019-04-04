<?php
declare(strict_types=1);

namespace Markup\ContentfulSdkBridge\Component;

use Contentful\Core\File\UrlOptionsInterface;
use Markup\Contentful\ImageApiOptions;

class SdkUrlOptions implements UrlOptionsInterface
{
    /**
     * @var ImageApiOptions
     */
    private $imageApiOptions;

    public function __construct(ImageApiOptions $imageApiOptions)
    {
        $this->imageApiOptions = $imageApiOptions;
    }

    /**
     * The urlencoded query string for these options.
     *
     * @return string
     */
    public function getQueryString(): string
    {
        return http_build_query(
            $this->imageApiOptions->toArray(),
            '',
            '&',
            PHP_QUERY_RFC3986
        );
    }
}
