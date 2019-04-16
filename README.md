# contentful-sdk-bridge
A small bridge library to convert resources from the official Contentful SDK into resources compatible with the markup/contentful library.

[![Build Status](https://api.travis-ci.org/usemarkup/contentful-sdk-bridge.png?branch=master)](http://travis-ci.org/usemarkup/contentful-sdk-bridge)

## Installation

The Markup contentful-sdk-bridge bundle can be installed via [Composer](http://getcomposer.org) by 
requiring the`markup/contentful-sdk-bridge` package in your project's `composer.json`:

```json
{
    "require": {
        "markup/contentful-sdk-bridge": "0.1"
    }
}
```

## Usage

The package provides some simple adapters enabling resources emitted from the [official Contentful SDK](https://github.com/contentful/contentful.php) to be used as if they are resources emitted from [Markup's Contentful library](https://github.com/usemarkup/contentful).

Examples:

```php
use Markup\ContentfulSdkBridge\AdaptedAsset;
use Markup\ContentfulSdkBridge\AdaptedContentType;
use Markup\ContentfulSdkBridge\AdaptedEntry;

$space = 'content_space';
$locale = 'en-US';

/** @var \Contentful\Delivery\Resource\Entry $sdkEntry */

$markupEntry = new AdaptedEntry(
    $sdkEntry,
    $locale,
    $space
);

/** @var \Contentful\Delivery\Resource\Asset $sdkAsset */

$markupAsset = new AdaptedAsset(
    $sdkAsset,
    $locale
);

/** @var \Contentful\Delivery\Resource\ContentType $sdkContentType */

$markupContentType = new AdaptedContentType($sdkContentType);
```
