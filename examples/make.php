<?php

include_once __DIR__ . '/../vendor/autoload.php';

use edwrodrig\file_cache\CacheManager;
use edwrodrig\file_cache\ImageItem;

class Context implements \edwrodrig\file_cache\Context {

    public function logBegin(string $message) { echo $message , "\n"; }
    public function logEnd(string $message) { echo $message , "\n"; }
    public function getUrl(string $path): string { return  "//test" . $path; }
}

$cache  = new CacheManager(__DIR__ . '/cache/images');
    $cache->setContext(new Context());
    $cache->setTargetWebPath('cache/images');

echo $cache->update(new ImageItem(__DIR__ . '/data', 'amelia.jpg'));
echo "\n";
echo $cache->update((new ImageItem(__DIR__ . '/data', 'amelia.jpg'))->resizeContain(100,100));
echo "\n";
//SEE DATA FOLDER TO VIEW CACHED FILES

$cache->save();







