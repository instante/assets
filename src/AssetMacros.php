<?php

namespace Instante\Assets;

use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

class AssetMacros extends MacroSet
{
    public static function install(Compiler $compiler)
    {
        $me = new static($compiler);

        $me->addMacro('hashedAssetVersion', [$me, 'macroHashedAssetVersion']);
        $me->addMacro('asset', [$me, 'macroAsset']);
    }

    public function macroHashedAssetVersion(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write('echo $this->global->assetHelper->getHashedAssetVersion(' . $writer->formatArgs() . ', $basePath);');
    }

    public function macroAsset(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write('echo $this->global->assetHelper->getAsset(' . $writer->formatArgs() . ', $basePath);');
    }
}

