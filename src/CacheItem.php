<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 26-03-18
 * Time: 10:23
 */

namespace edwrodrig\file_cache;

use DateTime;
/**
 * Interface Cacheitem
 * An interface that must implement every Item suitable for caching.
 * This is readed from {@see CacheEntry::createFromItem() the index} to create an cache entry}
 * @package edwrodrig\static_generator\cache
 * @api
 */
interface CacheItem
{

    /**
     * Get the unique key of this item.
     * @api
     * @return string
     */
    public function getKey() : string;

    /**
     * Return the last time the item was modified.
     *
     * It is use to determine if the file has changed from previous time.
     * @api
     * @return DateTime
     */
    public function getLastModificationTime() : DateTime;

    /**
     * Get the target relative path.
     *
     * This must return the target relative path to the {@see CacheManager::getDataTargetRootPath() target root path of the context}
     * Example you want to generate a file as cache/folder/img_24x24.jpg.
     * Sometimes is a good idea that the file is salted to
     * @api
     * {@see https://developers.google.com/web/fundamentals/performance/optimizing-content-efficiency/http-caching#invalidating_and_updating_cached_responses help caching efficience}
     * @return string
     */
    public function getTargetRelativePath() : string;


    /**
     * Get additional data.
     *
     * Cache stored information is limited. It only stores modification dates and source target file paths.
     * Sometimes other information are needed according the nature of the cache. For example, for a image cache is useful to have the width and height of the cached image.
     * This function is used to store arbitrary information in the cache in the form of an array.
     * @return array
     */
    public function getAdditionalData() : array;
}