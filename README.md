DtcQueueBundle
==============

Generate sprite files given a image directory.

Documentation
-------------

The bulk of the documentation is stored in the `Resources/doc/index.md`

Installation
------------

Modify your composer.json to include the bundle:

	    "repositories": [
	      {
	          "type": "git",
	          "url": "git://github.com/dtee/SpriteBundle.git"
	      },
	    "require": {
	        ...
	        "dtc/sprite": "*",
	        ...
	    }


Download the bundle by running:

	php composer.phar update dtc/sprite

Modify AppKernel to include the bundle:

	new Dtc\SpriteBundle\DtcSpriteBundle()

Add an config entry for using document manager:

	dtc_sprite:
	    path: %kernel.root_dir%/../web/sprite
	    hash_algorithm: crc32   # defaults to file mod time + file size
	    sprites:
	        {name}:
	            folder: folder_name
	            type: png
	        ...


Register Controllers - edit routing.yml: (optional)

	SpriteBundle:
	    resource: "@DtcSpriteBundle/Resources/config/routing.yml"
	    prefix:   /

Usage
-----

To generate sprite css:     `dtc:sprite:generate`

If you registered the controller, you can view all sprites and class name:

	/sprite/

For usage example: `Resources/views/Sprite/index.html.twig`

License
-------

This bundle is under the MIT license.
