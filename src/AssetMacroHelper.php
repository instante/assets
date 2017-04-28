<?php

namespace Instante\Assets;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;

class AssetMacroHelper
{
    /** @var string */
    private $wwwDir;

    /** @var Cache */
    private $cache;

    public function __construct(IStorage $storage, $wwwDir)
    {
        $this->wwwDir = $wwwDir;
        $this->cache = new Cache($storage, 'instante/assets');
    }

    /**
     * Check if file exists. If yes, return its local path. If no, throw AssetNotFoundException.
     *
     * @param string $filePath
     * @return string
     * @throws AssetNotFoundException
     */
    private function getLocalFilePath($filePath)
    {
        $localFilePath = $this->wwwDir . '/' . $filePath;
        if (!file_exists($localFilePath)) {
            throw new AssetNotFoundException($localFilePath);
        }

        return $localFilePath;
    }

    /**
     * Get file path with prepended basePath.
     *
     * @param string $filePath
     * @param string $basePath
     * @return string
     */
    private function getRenderPath($filePath, $basePath)
    {
        return $basePath . '/' . $filePath;
    }

    /**
     * Add file's MD5 hash after file path.
     *
     * @param $filePath
     * @param $basePath
     * @return string
     * @throws AssetNotFoundException
     */
    public function getHashedAssetVersion($filePath, $basePath)
    {
        $localFilePath = $this->getLocalFilePath($filePath);

        $hash = $this->cache->load($localFilePath, function (& $dependencies) use ($localFilePath) {
            $dependencies = [Cache::EXPIRE => '1 week'];

            return md5_file($localFilePath);
        });

        return $this->getRenderPath($filePath, $basePath) . '?' . $hash;
    }

    /**
     * Check if file exists and prepend basePath to filePath
     *
     * @param string $filePath
     * @param string $basePath
     * @return string
     * @throws AssetNotFoundException
     */
    public function getAsset($filePath, $basePath)
    {
        $this->getLocalFilePath($filePath);

        return $this->getRenderPath($filePath, $basePath);
    }

}

