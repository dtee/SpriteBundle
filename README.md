DtcQueueBundle
==============

Generate sprite files given a image directory.

Documentation
-------------

The bulk of the documentation is stored in the `Resources/doc/index.md`

Installation
------------

Update composer.json to include the bundle

	    "repositories": [
	      {
	          "type": "git",
	          "url": "git://github.com/dtee/SpriteBundle.git"
	      },
	    "require": {
	        ...
	        "dtc/queue": "*",
	        ...
	    }

Update AppKernel to include the bundle

	new Dtc\SpriteBundle\DtcSpriteBundle()

Add an config entry for using document manager

	dtc_sprite:
	    sprites:
	        {name}:
	            folder: folder_name
	            type: png


Register Controllers (optional)

	SpriteBundle:
	    resource: "@DtcSpriteBundle/Resources/config/routing.yml"
	    prefix:   /

Usage
-----

To generate sprite css:     dtc:sprite:generate_css
To generate sprite images:  dtc:sprite:generate_image

License
-------

This bundle is under the MIT license.