<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 26-03-18
 * Time: 10:23
 */

namespace edwrodrig\file_cache;

/**
 * Interface CacheableItem
 * An interface that must implement every Item suitable for caching.
 * This is readed from {@see CacheEntry::createFromItem() the index} to create an cache entry}
 * @package edwrodrig\static_generator\cache
 * @api
 */
interface CacheableItem extends CacheItem
{
    /**
     * Generates this cache entry.
     *
     * This must generate a cache file. All cache files must be generated in to {@see CacheManager::getTargetAbsolutePath() target root path}.
     * For convenience this method should call {@see CacheManager::prepareCacheFile()} to get the target filename.
     * This function should not delete the previous entry, because it is removed internally.
     * ```
     *   $absolute_path = $manager->prepareCacheFile();
     *   file_put_contents($absolute_path, 'content');
     * ```
     * @api
     * @param CacheManager $manager to retrieve the {@see CacheManager::prepareCacheFile() target root path}
     */
    public function generate(CacheManager $manager);
}