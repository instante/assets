<?php

namespace Instante\Tests\Sample;

use Instante\Assets\AssetMacroHelper;
use Instante\Assets\AssetMacros;
use Latte\Engine;
use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use Tester\Assert;

require_once '../bootstrap.php';

const WWW_FOLDER = '../www';
const BASE_PATH = 'http://localhost/test';

$storage = new FileStorage('../tmp');
$storage->clean([Cache::ALL => true]);

$engine = new Engine();
$engine->addProvider('assetHelper', new AssetMacroHelper($storage, WWW_FOLDER));

AssetMacros::install($engine->getCompiler());

Assert::equal('<test>http://localhost/test/test2.css</test>'.PHP_EOL, $engine->renderToString('../www/asset.latte', ['basePath' => BASE_PATH]));
Assert::equal('<test>http://localhost/test/test2.css?e97654fa4f8b2a31f22746fb7ee75729</test>'.PHP_EOL, $engine->renderToString('../www/hashedAssetVersion.latte', ['basePath' => BASE_PATH]));
