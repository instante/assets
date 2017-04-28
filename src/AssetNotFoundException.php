<?php

namespace Instante\Assets;

class AssetNotFoundException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct("Asset with file path `" . $filePath . '` not found.');
    }
}

