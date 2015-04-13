<?php

namespace Helpers;

use Mdb\Kata\Console\Command\CreateWorkspaceCommand;

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
        return sys_get_temp_dir().'/behat-kata/'.$path;
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
            sprintf('/%s/', CreateWorkspaceCommand::RESOURCES_PATH_PLACEHOLDER),
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
            sprintf('/%s/', CreateWorkspaceCommand::WORKSPACE_PATH_PLACEHOLDER),
            $workspacePath,
            $workspaceFile
        );

        return self::normalizeWorkspaceFilePath($path);
    }
}
