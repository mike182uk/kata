<?php

namespace Helpers;

use Mdb\Kata\Console\Utility\PathNormalizer;

class Path
{
    /**
     * @var array
     */
    private static $createdPaths = [];

    /**
     * @return array
     */
    public static function getCreatedPaths()
    {
        return self::$createdPaths;
    }

    /**
     * @param $path
     */
    public static function registerCreatedPath($path)
    {
        self::$createdPaths[] = $path;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function normalizeWorkspaceFilePath($path)
    {
        return sprintf('%s/behat-mdb-kata/%s', sys_get_temp_dir(), $path);
    }

    /**
     * @return string
     */
    public static function getResourcesPath()
    {
        return self::normalizeWorkspaceFilePath('resources');
    }

    /**
     * @param string $resourceFile
     *
     * @return string
     */
    public static function getResourceFilePath($resourceFile)
    {
        return preg_replace(
            sprintf('/%s/', PathNormalizer::RESOURCES_PATH_PLACEHOLDER),
            self::getResourcesPath(),
            $resourceFile
        );
    }

    /**
     * @param string $workspacePath
     * @param string $workspaceFile
     *
     * @return string
     */
    public static function getWorkspaceFilePath($workspacePath, $workspaceFile)
    {
        $path = preg_replace(
            sprintf('/%s/', PathNormalizer::WORKSPACE_PATH_PLACEHOLDER),
            $workspacePath,
            $workspaceFile
        );

        return self::normalizeWorkspaceFilePath($path);
    }
}
