<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 11-05-18
 * Time: 16:09
 */

namespace test\edwrodrig\file_cache;

use edwrodrig\file_cache\CacheManager;
use edwrodrig\file_cache\ImageItem;
use Exception;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class ImageItemTest extends TestCase
{

    private vfsStreamDirectory $root;

    public function setUp() : void {
        $this->root = vfsStream::setup();
    }


    function testGetCachedFile() {
        $f = new ImageItem('http://edwin.cl', 'hola.jpg');
        $this->assertEquals('hola.jpg', $f->getTargetRelativePath());
    }

    /**
     * @throws Exception
     */
    function testHappy() {
        $context = new DummyContext();

        $manager = new CacheManager( $this->root->url() . '/cache');
        $manager->setContext($context);

        $item = new ImageItem(__DIR__ . '/files/image', 'rei.jpg');
        $item->resizeCover(100, 100);
        $this->assertEquals('rei_100x100_cover.jpg', $item->getTargetRelativePath());
        $this->assertEquals([ 'width' => 100, 'height' => 100], $item->getAdditionalData());

        $manager->update($item);
        $manager->update($item);

        $this->assertFileExists($this->root->url() .'/cache/data/' . $item->getTargetRelativePath());

        $item = new ImageItem(__DIR__ . '/files/image', 'rei.jpg');
        $item->resizeContain(200, 100);
        $this->assertEquals('rei_200x100_contain.jpg', $item->getTargetRelativePath());
        $this->assertEquals([ 'width' => 200, 'height' => 100], $item->getAdditionalData());

        $manager->update($item);
        $this->assertFileExists($this->root->url() .'/cache/data/' . $item->getTargetRelativePath());

        $expected_log = [
"New cache entry [rei_100x100_cover]",
  "Generating cache file [rei_100x100_cover.jpg]...","GENERATED","",
"New cache entry [rei_200x100_contain]",
  "Generating cache file [rei_200x100_contain.jpg]...","GENERATED",""
];

        $this->assertEquals($expected_log, $context->logs);
    }

    /**
     * @throws Exception
     */
    function testNoTransformation() {
        $context = new DummyContext();

        $manager = new CacheManager( $this->root->url() . '/cache');
        $manager->setContext($context);

        $item = new ImageItem(__DIR__ . '/files/image', 'rei.jpg');
        $this->assertEquals('rei.jpg', $item->getTargetRelativePath());

        $manager->update($item);

        $this->assertEquals([ 'width' => 630, 'height' => 474], $item->getAdditionalData());

        $this->assertFileExists($this->root->url() .'/cache/data/' . $item->getTargetRelativePath());

        $expected_log = [
"New cache entry [rei]",
  "Generating cache file [rei.jpg]...","GENERATED",""
];

        $this->assertEquals($expected_log, $context->logs);
    }


}
