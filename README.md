edwrodrig\file_cache
========
System for cache images and files for websites

[![Latest Stable Version](https://poser.pugx.org/edwrodrig/file_cache/v/stable)](https://packagist.org/packages/edwrodrig/file_cache)
[![Total Downloads](https://poser.pugx.org/edwrodrig/file_cache/downloads)](https://packagist.org/packages/edwrodrig/file_cache)
[![License](https://poser.pugx.org/edwrodrig/file_cache/license)](https://packagist.org/packages/edwrodrig/file_cache)
[![Build Status](https://travis-ci.org/edwrodrig/file_cache.svg?branch=master)](https://travis-ci.org/edwrodrig/file_cache)
[![codecov.io Code Coverage](https://codecov.io/gh/edwrodrig/file_cache/branch/master/graph/badge.svg)](https://codecov.io/github/edwrodrig/file_cache?branch=master)
[![Code Climate](https://codeclimate.com/github/edwrodrig/file_cache/badges/gpa.svg)](https://codeclimate.com/github/edwrodrig/file_cache)

 
## My use cases

 * Store result of image generation through different page generations.
 * Salt the path of the files.
 * Store different image formats.
 * Modular and easy integration with other systems.
 * Optimize and cache some assets like images and large file.
 * I want to maintain the things as [simple as possible](https://en.wikipedia.org/wiki/KISS_principle)  

My infrastructure is targeted to __Ubuntu 16.04__ machines with last __php7.2__ installed from [ppa:ondrej/php](https://launchpad.net/~ondrej/+archive/ubuntu/php).
I use some unix commands for some process like __cp__ or __ln__.
I'm sure that there are way to make it compatible with windows but I don't have time to program it and testing,
but I'm open for pull requests to make it more compatible.

## Documentation
The source code is documented using [phpDocumentor](http://docs.phpdoc.org/references/phpdoc/basic-syntax.html) style,
so it should pop up nicely if you're using IDEs like [PhpStorm](https://www.jetbrains.com/phpstorm) or similar.

![alt text](https://github.com/edwrodrig/file_cache/raw/master/docs/images/arch.png "Architecture")
![alt text](https://github.com/edwrodrig/file_cache/raw/master/docs/images/quick_reference.jpg "Quick Reference")

### Examples

There is a [example page](https://github.com/edwrodrig/file_cache/tree/master/examples) how to use the cache. I have to add some other more clear cases.


## Composer
```
composer require edwrodrig/file_cache
```

## Testing
The test are built using PhpUnit. It generates images and compare the signature with expected ones. Maybe some test fails due metadata of some generated images, but at the moment I haven't any reported issue.

## License
MIT license. Use it as you want at your own risk.

## About language
I'm not a native english writer, so there may be a lot of grammar and orthographical errors on text, I'm just trying my best. But feel free to correct my language, any contribution is welcome and for me they are a learning instance.

