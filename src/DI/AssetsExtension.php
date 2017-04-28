<?php

namespace Instante\DI\Assets;

use Instante\Assets\AssetMacroHelper;
use Instante\Assets\AssetMacros;
use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;

class AssetsExtension extends CompilerExtension
{
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $macros = AssetMacros::class;
        $builder->addDefinition($this->prefix('assetHelper'))
            ->setClass(AssetMacroHelper::class)
            ->setArguments(['@cacheStorage', $builder->parameters['wwwDir']]);

        $builder->getDefinition('latte.latteFactory')
            ->addSetup("?->onCompile[] = function() use (?) { $macros::install(?->getCompiler()); }",
                ['@self', '@self', '@self',])
            ->addSetup("?->addProvider('assetHelper', ?)", [
                '@self',
                $this->prefix('@assetHelper'),
            ]);
    }

    public static function register(Configurator $config)
    {
        $config->onCompile[] = function (Configurator $config, Compiler $compiler) {
            $compiler->addExtension('assetMacros', new self());
        };
    }
}

