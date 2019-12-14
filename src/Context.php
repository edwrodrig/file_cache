<?php
declare(strict_types=1);

namespace edwrodrig\file_cache;

/**
 * Class Context
 * A class to hold the context of page generation.
 * @package edwrodrig\static_generator
 * @api
 */
interface Context
{
    public function logBegin(string $message);

    public function logEnd(string $message);

    /**
     * Get a url with absolute target path if needed.
     *
     * It is useful when the target web folder is not /, when you have different version of a site in different folder, for example, by languages
     * @api
     * @param string $path
     * @return string
     */
    public function getUrl(string $path) : string;
}