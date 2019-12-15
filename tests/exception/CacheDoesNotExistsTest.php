<?php
declare(strict_types=1);

namespace test\edwrodrig\file_cache\exception;

use edwrodrig\file_cache\exception\CacheDoesNotExists;
use PHPUnit\Framework\TestCase;

class CacheDoesNotExistsTest extends TestCase
{

    /**
     * @throws CacheDoesNotExists
     */
    public function test__construct()
    {
        $this->expectException(CacheDoesNotExists::class);
        $this->expectExceptionMessage("hola");

        throw new CacheDoesNotExists("hola");
    }
}
