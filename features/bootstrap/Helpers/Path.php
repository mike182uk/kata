<?php

namespace Helpers;

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
        return sprintf('%s/%s', self::getResourcesPath(), $resourceFile);
    }

    /**
     * @param string $workspacePath
     * @param string $workspaceFile
     *
     * @return string
     */
    public static function getWorkspaceFilePath($workspacePath, $workspaceFile)
    {
        return sprintf('%s/%s', $workspacePath, $workspaceFile);
    }
}
