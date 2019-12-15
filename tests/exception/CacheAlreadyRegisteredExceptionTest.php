<?php
declare(strict_types=1);

namespace test\edwrodrig\file_cache\exception;

use edwrodrig\file_cache\exception\CacheAlreadyRegisteredException;
use PHPUnit\Framework\TestCase;

class CacheAlreadyRegisteredExceptionTest extends TestCase
{

    /**
     * @throws CacheAlreadyRegisteredException
     */
    public function test__construct()
    {
        $this->expectException(CacheAlreadyRegisteredException::class);
        $this->expectExceptionMessage("hola");

        throw new CacheAlreadyRegisteredException("hola");
    }
}
