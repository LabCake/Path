<?php

/**
 * A class made in PHP7 inspired by nodes path module, for modify and create path strings, also read folder/file information
 * @author LabCake
 * @copyright 2018 LabCake
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace LabCake;
class Path
{
    /**
     * @var string
     */
    private static $SEPERATOR = DIRECTORY_SEPARATOR;

    /**
     * Resolve path string
     * @param mixed $args
     * @return string
     */
    public static function resolve($args)
    {
        $args = func_get_args();

        $path = implode(self::$SEPERATOR, $args);
        $basename = self::basename($path);
        $dir = self::dirname($path);
        $ext = self::extname($path);

        return ($dir !== "." ? self::$SEPERATOR . trim($dir, self::$SEPERATOR) . self::$SEPERATOR : "") . ($ext ? $basename : $basename . self::$SEPERATOR);
    }

    /**
     * Parse path
     * @param string $path
     * @param int $options
     * @return array|string
     */
    public static function parse(string $path, int $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME)
    {
        return pathinfo($path, $options);
    }

    /**
     * Get file extension
     * @param string $path
     * @return string
     */
    public static function extname(string $path)
    {
        return self::parse($path, PATHINFO_EXTENSION);
    }

    /**
     * Get file mime type of given file
     * @param string $path
     * @return null|string
     */
    public static function mimetype(string $path)
    {
        return self::exists($path) ? mime_content_type($path) : null;
    }

    /**
     * Get directory name of given path
     * @param $path
     * @return string
     */
    public static function dirname(string $path)
    {
        return dirname($path);
    }

    /**
     * Get basename of given path
     * @param $path
     * @param null|string $suffix [optional]
     * @return string
     */
    public static function basename(string $path, $suffix = null)
    {
        return basename($path, $suffix);
    }

    /**
     * Check if file or folder exists
     * @param string $path
     * @return bool
     */
    public static function exists(string $path)
    {
        return file_exists($path);
    }

    /**
     * Create recursive directories
     * @param $target
     * @return bool
     */
    public static function mkdir(string $target)
    {
        $target = rtrim($target, self::$SEPERATOR);
        if (empty($target))
            $target = '/';
        if (file_exists($target))
            return @is_dir($target);
        $target_parent = dirname($target);
        while ('.' != $target_parent && !is_dir($target_parent)) {
            $target_parent = dirname($target_parent);
        }
        if ($stat = @stat($target_parent)) {
            $dir_perms = $stat['mode'] & 0007777;
        } else {
            $dir_perms = 0777;
        }
        if (@mkdir($target, $dir_perms, true)) {
            if ($dir_perms != ($dir_perms & ~umask())) {
                $folder_parts = explode(self::$SEPERATOR, substr($target, strlen($target_parent) + 1));
                for ($i = 1, $c = count($folder_parts); $i <= $c; $i++) {
                    @chmod($target_parent . self::$SEPERATOR . implode(self::$SEPERATOR, array_slice($folder_parts, 0, $i)), $dir_perms);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @param string $dirPath
     * @return bool
     */
    public static function rmdir(string $dirPath)
    {
        if (!is_dir($dirPath))
            return false;

        if (substr($dirPath, strlen($dirPath) - 1, 1) != self::$SEPERATOR) {
            $dirPath .= self::$SEPERATOR;
        }
        $files = glob($dirPath . '{,.}[!.,!..]*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::rmdir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);

        return true;
    }
}