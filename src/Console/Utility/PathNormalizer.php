<?php

namespace Mdb\Kata\Console\Utility;

class PathNormalizer
{
    const RESOURCES_PATH_PLACEHOLDER = '%resources%';
    const WORKSPACE_PATH_PLACEHOLDER = '%workspace%';

    /**
     * @param string $resourcesPath
     * @param string $resourceFile
     *
     * @return string
     */
    public static function normalizeResourceFilePath($resourcesPath, $resourceFile)
    {
        return preg_replace(
            sprintf('/%s/', self::RESOURCES_PATH_PLACEHOLDER),
            $resourcesPath,
            $resourceFile
        );
    }

    /**
     * @param string $workspacePath
     * @param string $workspaceFile
     *
     * @return string
     */
    public static function normalizeWorkspaceFilePath($workspacePath, $workspaceFile)
    {
        return preg_replace(
            sprintf('/%s/', self::WORKSPACE_PATH_PLACEHOLDER),
            $workspacePath,
            $workspaceFile
        );
    }
}
