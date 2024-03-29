<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 13-05-18
 * Time: 16:48
 */

namespace edwrodrig\file_cache\exception;


use Exception;

/**
 * Class CacheAlreadyRegisteredException
 * @package edwrodrig\static_generator\exception
 * @api
 */
class CacheAlreadyRegisteredException extends Exception
{

    /**
     * CacheAlreadyRegisteredException constructor.
     * @internal
     * @param string $web_path
     */
    public function __construct(string $web_path)
    {
        parent::__construct($web_path);
    }
}