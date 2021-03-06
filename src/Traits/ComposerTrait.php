<?php

namespace CleaniqueCoders\Console\Traits;

trait ComposerTrait
{
    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    public function findComposer()
    {
        if (file_exists(getcwd() . '/composer.phar')) {
            return '"' . PHP_BINARY . '" composer.phar';
        }
        return 'composer';
    }

    /**
     * Get Composer Configuration
     * @param  string $path
     * @return json
     */
    public function getComposerConfig($path)
    {
        $composerJson = file_get_contents($path . DIRECTORY_SEPARATOR . 'composer.json');
        return json_decode($composerJson);
    }

    /**
     * Get Qualified Namespace from Path Given
     * @param  string $path
     * @return string
     */
    public function getQualifiedNamespaceFromPath($path)
    {
        $json               = $this->getComposerConfig($path);
        $qualifiedNamespace = key((array) $json->autoload->{'psr-4'});
        return $qualifiedNamespace;
    }

    /**
     * Install Package Dependencies
     * @return void
     */
    public function composerInstall()
    {
        exec($this->findComposer() . ' install --no-progress --no-suggest');
    }

}
