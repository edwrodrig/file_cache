<?php

namespace test\edwrodrig\file_cache;

use DateTime;
use edwrodrig\file_cache\CacheManager;
use Exception;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class CacheManagerTest extends TestCase
{

    private vfsStreamDirectory $root;

    public function setUp() : void {
        $this->root = vfsStream::setup();
    }


    /**
     * @throws Exception
     */
    public function testManager() {

        $context = new DummyContext();

        $manager = new CacheManager( $this->root->url() . '/cache');
        $manager->setContext($context);

        $item = new CacheableItem('abc', new DateTime('2015-01-01'), 'salt');
        $manager->update($item);

        $manager->update($item);

        $item = new CacheableItem('abc', new DateTime('2016-01-01'), 'salt');

        $manager->update($item);

        $expected_log = [
"New cache entry [abc]",
  "Generating cache file [abc_salt]...","GENERATED","",
"Outdated cache entry [abc] FOUND!",
  "Removing file [abc_salt]...","REMOVED",
  "Generating cache file [abc_salt]...","GENERATED",""
];

        $this->assertEquals($expected_log, $context->logs);
    }


    /**
     * @throws Exception
     */
    public function testManagerSaveAndRestored() {
        $context = new DummyContext();

        $manager = new CacheManager( $this->root->url() . '/cache');
        $manager->setContext($context);

        $item = new CacheableItem('abc', new DateTime('2015-01-01'), 'salt');
        $this->assertEquals(['hola' => 1, 'chao' => 2], $item->getAdditionalData());
        $manager->update($item);

        $expected_log = [
"New cache entry [abc]",
  "Generating cache file [abc_salt]...","GENERATED",""
];
        $this->assertEquals($expected_log, $context->logs);

        $manager->save();

        $context = new DummyContext();

        $manager = new CacheManager( $this->root->url() . '/cache');
        $manager->setContext($context);

        $cache_item = $manager->update($item);
        $this->assertEquals(['hola' => 1, 'chao' => 2], $cache_item->getAdditionalData());

        $item = new CacheableItem('abc', new DateTime('2016-01-01'), 'salt');

        $manager->update($item);

        $expected_log = [
"Outdated cache entry [abc] FOUND!",
  "Removing file [abc_salt]...","REMOVED",
  "Generating cache file [abc_salt]...","GENERATED",""
];

        $this->assertEquals($expected_log, $context->logs);


    }


    /**
     * @throws Exception
     */
    public function testManagerUnused() {
        $context = new DummyContext();

        $manager = new CacheManager( $this->root->url() . '/cache');
        $manager->setContext($context);

        $item_1 = new CacheableItem('abc', new DateTime('2015-01-01'), 'salt');
        $item_2 = new CacheableItem('zxc', new DateTime('2016-01-01'), 'salt');

        $manager->update($item_1);
        $manager->update($item_2);

        $manager->save();

        $expected_log = [
"New cache entry [abc]",
  "Generating cache file [abc_salt]...","GENERATED","",
"New cache entry [zxc]",
  "Generating cache file [zxc_salt]...","GENERATED",""
];
        $this->assertEquals($expected_log, $context->logs);


        $context = new DummyContext();

        $manager = new CacheManager( $this->root->url() . '/cache');
        $manager->setContext($context);

        $manager->update($item_1);
        $manager->save();

        $expected_log = [
"Unused cache entry [zxc] FOUND!",
  "Removing file [zxc_salt]...","REMOVED",""
];

        $this->assertEquals($expected_log, $context->logs);

        $context = new DummyContext();

        $manager = new CacheManager( $this->root->url() . '/cache');
        $manager->setContext($context);

        $manager->update($item_1);
        $manager->update($item_2);
        $manager->save();

        $expected_log = [
"New cache entry [zxc]",
  "Generating cache file [zxc_salt]...","GENERATED",""
];

        $this->assertEquals($expected_log, $context->logs);


    }

    /**
     * @throws Exception
     */
    public function testManagerNoEntries() {
        $context = new DummyContext();

        $manager = new CacheManager( $this->root->url() . '/cache');
        $manager->setContext($context);
        $manager->save();

        $this->assertFileExists($manager->getTargetAbsolutePath());
    }

    /**
     * @throws Exception
     */
    public function testManagerMultipleCaches() {
        $context = new DummyContext();

        $manager1 = new CacheManager( $this->root->url() . '/cache');
        $manager1->setContext($context);

        $manager2 = new CacheManager( $this->root->url() . '/cache');
        $manager2->setContext($context);

        $manager1->save();
        $manager2->save();

        $this->assertFileExists($manager1->getTargetAbsolutePath());
        $this->assertFileExists($manager2->getTargetAbsolutePath());
    }

}