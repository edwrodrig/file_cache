<?php
declare(strict_types=1);


namespace test\edwrodrig\file_cache;


use edwrodrig\file_cache\Context;

class DummyContext implements Context
{

    public array $logs = [];

    public function logBegin(string $message)
    {
        $this->logs[] = $message;
    }

    public function logEnd(string $message)
    {
        $this->logs[] = $message;
    }

    /**
     * @inheritDoc
     */
    public function getUrl(string $path): string
    {
        return "///test:" . $path;
    }
}