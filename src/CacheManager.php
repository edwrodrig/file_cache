<?php
declare(strict_types=1);

namespace edwrodrig\file_cache;

use Exception;

/**
 * Class CacheManager
 *
 * This class contains works as an interface to {@see CacheManager::update() generate} cache entries from {@see CacheableItem cacheable items}.
 * When caches are used in a context, they must be registered using {@see Context::registerContext()}
 * @api User must interact with this class
 * @package edwrodrig\static_generator\cache
 */
class CacheManager
{
    /**
     * The generation context of this cache
     * @var Context
     */
    private Context $context;

    /**
     * @var CacheIndex
     */
    private CacheIndex $index;

    /**
     * The cache target root path absolute.
     * @var string
     */
    protected string $target_root_path;

    /**
     * The target web path of the cache relative to the {@see Context::getTargetWebRoot() web root} of the context.
     * This value must be unique between caches in a {@see Context::registerContext() context}.
     * @var string
     */
    protected string $target_web_path = "cache";


    /**
     * CacheManager constructor.
     * @param string $target_root_path {@see CacheManager::$target_root_path}
     * @throws Exception
     * @api
     */
    public function __construct(string $target_root_path) {
        $this->target_root_path = $target_root_path;
        $this->index = new CacheIndex($this);
    }

    /**
     * Get the context of the cache.
     * @return Context
     */
    public function getContext() : Context {
        return $this->context;
    }

    /**
     * Set a new context.
     *
     * Useful when a cache is shared between different contexts
     * @param Context $context
     * @return CacheManager
     */
    public function setContext(Context $context) : CacheManager {
        $this->context = $context;
        return $this;
    }

    /**
     * Get the target web path of the cache manager.
     *
     * @see CacheManager::$target_web_path
     * @return string
     */
    public function getTargetWebPath() : string {
        return $this->target_web_path;
    }

    /**
     * Set the target web path.
     *
     * @api
     * @uses CacheManager::$target_web_path
     * @param string $target_web_path
     * @return $this
     */
    public function setTargetWebPath(string $target_web_path) {
        $this->target_web_path = $target_web_path;
        return $this;
    }

    /**
     * Get the target absolute path.
     *
     * Return the cache target absolute path in the current file system.
     *
     * @api
     * @return string
     */
    public function getTargetAbsolutePath() : string {
        return $this->target_root_path;
    }

    /**
     * Get the data target absolute path
     * The data target is the path where the cached data is stored. It is a folder named data in the same path than the {@see CacheIndex::getIndexAbsoluteFilePath() index path}
     * @return string
     */
    public function getDataTargetAbsolutePath() : string {
        return $this->getTargetAbsolutePath() . '/data';
    }

    /**
     * Update the index according a item
     *
     * This function always creates a new entry or update an existing one if needed.
     *
     * @api
     * @param CacheableItem $item
     * @return CacheEntry an updated cache entry
     */
    public function update(CacheableItem $item) : CacheEntry {
        return $this->index->update($item);
    }

    /**
     * Prepare a cache file.
     *
     * This functions should always be called before creating a cache file.
     * This create the respective folders if does not exist and return the absolute path to use.
     * This function is intended to be used in {@see CacheableItem::generate()}.
     *
     * @api
     * @param CacheableItem $item
     * @return string
     */
    public function prepareCacheFile(CacheableItem $item) : string {
        $absolute_path = $this->getDataTargetAbsolutePath() . '/' . $item->getTargetRelativePath();
        @mkdir(dirname($absolute_path), 0777, true);
        return $absolute_path;
    }

    /**
     * Save the cache index.
     *
     * @api
     * @uses CacheIndex::save()
     */
    public function save() {
        $absolute_path = $this->getTargetAbsolutePath() . '/dummy_file';
        $dir_name = dirname($absolute_path);
        if ( !file_exists($dir_name) )
            mkdir($dir_name, 0777, true);

        $this->index->save();
    }

    /**
     * Creates a symlink to the target output.
     *
     * If you don't do this the cached files will be not visible in the target output.
     *
     * @param string $targetPath
     * @uses CacheManager::getTargetWebPath()
     * @api
     */
    public function linkToTarget(string $targetPath) {
        $link = $targetPath . '/' . $this->getTargetWebPath();

        $dir_name = dirname($link);
        if ( !file_exists($dir_name) )
            mkdir($dir_name, 0777, true);

        symlink(
            $this->getDataTargetAbsolutePath(),
            $link
        );
    }
}
