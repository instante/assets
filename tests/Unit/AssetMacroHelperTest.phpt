<?php

namespace Instante\Tests\Sample;

use Instante\Assets\AssetMacroHelper;
use Instante\Assets\AssetNotFoundException;
use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use Tester\Assert;

require_once '../bootstrap.php';

const WWW_FOLDER = '../www';

$storage = new FileStorage('../tmp');

$assetMacroHelper = new AssetMacroHelper($storage, WWW_FOLDER);

// Asset macro helper test
Assert::equal('http://localhost/test/test.css', $assetMacroHelper->getAsset('test.css', 'http://localhost/test'));
Assert::exception(function () use ($assetMacroHelper) {
    $assetMacroHelper->getAsset('nonExist.css', 'http://localhost/test');
}, AssetNotFoundException::class);

// Hashed asset version helper test
$storage->clean([Cache::ALL => true]);
file_put_contents(WWW_FOLDER . '/test.css', '6hooi2e35s');

Assert::equal('http://localhost/test/test.css?a3779417967cbfcbc3b875523de50bfe', $assetMacroHelper->getHashedAssetVersion('test.css', 'http://localhost/test'));
file_put_contents(WWW_FOLDER . '/test.css', 'a4dl4ds8a4-');

// should stay same - cached
Assert::equal('http://localhost/test/test.css?a3779417967cbfcbc3b875523de50bfe', $assetMacroHelper->getHashedAssetVersion('test.css', 'http://localhost/test'));

// should be different after cache clear
$storage->clean([Cache::ALL => true]);
Assert::equal('http://localhost/test/test.css?60e3c15bc1c80ce758222740a46533a5', $assetMacroHelper->getHashedAssetVersion('test.css', 'http://localhost/test'));






