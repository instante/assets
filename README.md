# Instante assets

Useful macros for latte assets

[![Build Status](https://travis-ci.org/instante/assets.svg?branch=master)](https://travis-ci.org/instante/assets)
[![Downloads this Month](https://img.shields.io/packagist/dm/instante/assets.svg)](https://packagist.org/packages/instante/assets)
[![Latest stable](https://img.shields.io/packagist/v/instante/assets.svg)](https://packagist.org/packages/instante/assets)

Requirements
------------

- PHP 5.6 or higher
- [Nette Framework](https://github.com/nette/nette) 2.4 or higher



Installation
------------

The best way to install Instante assets is using  [Composer](http://getcomposer.org/):

```sh
$ composer require instante/assets
```

Then add new extension to neon configuration
```neon
extensions:
    assets: Instante\Assets\DI\AssetMacrosExtension
```

Usage
-----

Instead of following code:
```html
<link rel="stylesheet" href="{$basePath}/css/main.min.css">
```
you should use:

```html
<link rel="stylesheet" href="{hashedAssetVersion 'css/main.min.css'}">
```

It will automatically generates MD5 hash of current asset to prevent unwanted caching.
Hash is regenerated after 1 week or after you manually clear cache.

To simply prepend $basePath url to asset, you can use macro `{asset 'path/to/file'}`.
