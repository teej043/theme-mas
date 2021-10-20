
# Boilerplate Custom Theme

This theme is using Timber, Twig, ACF Blocks and Patternlab. It also meant to be a permanent theme for the site as soon as the site uses the blocks that these theme provides.

## Requirements

### Technology Stack

##### Server:

PHP 7.4 or greater
MySQL 5.6 or greater OR MariaDB 10.1 or greater
Nginx or Apache with mod_rewrite module
HTTPS support

##### Development:

Wordpress - A very popular PHP based Content Management System, it is the primary platform of the solution.

NodeJS - Brings along NPM which is a package manager, and an environment for creating automation of tasks using GulpJS.

Composer - A PHP based package manager. Used to install Timber and probably other dependencies.

GIT - A version control system, allows to track changes on the source code from a collaborative development team.

GulpJS - A task runner for creating a system of processes for automation, optimization and deployments. The build system tasks will be discussed in later section.

Timber - Timber enables Wordpress to use Twig files, it is a great tool to turn Wordpress templating workflow into a setup similar to Model-View-Controller; it separates handling of logic, data away from the rendering of displays which will dramatically improve maintanability and scalability of the development, and promotes manageability among collaborators. Timber is installed using Composer.

Twig - The PHP Templating Engine.

Patternlab - A self generating automated styleguide static site, used for when showcasing or discussing ui design patterns with the client and collaborators. Works hand in hand with Timber to integrate with Wordpress.

### Wordpress Plugins

Essential Wordpress plugins are required to work hand in hand with the Theme.

`advanced-custom-field` Advanced Custom Field PRO is primarily the most important plugin, it gives power to the CMS to create custom data.

`crop-thumbnails` A tried and tested cropper tool for Wordpress image uploads.

There are also utility or situational plugins that may be used but can be safely removed.

`wordpress-importer` A standard plugin for exporting and importing existing content.

Specific site functionality plugins will be added here...


### Frontend Vendor Librarires

Some vendor libraries will be used, but most of them will be determined per project basis, but the most common starter libraries will be listed here:

`splidejs` A powerful lightweight slider library, with no js framework dependencies.


## Further Development Installation Guide

Make sure to clone this onto your themes folder, the folder and text domain by default is "mas", should you want to rename this to anything else just search and replace instances of "mas".


### Prerequisites

Steps to do first right after you clone this from the repo.

1. (Optional) Rename the theme root folder "mas".
2. (Optional) Rename the text domain "mas" using search and replace all.
3. (Optional) Change the theme information indicated on the "style.css" file.
4. Install node_modules `npm run install`
5. If you are using POEdit for translations, just open the theme folder in POEdit.

## What's here?

`source/` is where sass, svg, and Patternlab specific files are located.

`inc/` is some PHP files that handles the initialization of the theme are located. It is required by the `functions.php` of Wordpress. It handles anything about ACF, blocks and Custom Post Type setups.

`static/` or `assets/` is where you can keep your static front-end scripts, styles, or images. It is also a place where transformed or generated files (from dynamic sources such as "sass" and "svg") are stored.

`templates/` or `views/` contains all of your Twig templates. These pretty much correspond 1 to 1 with the PHP files that respond to the WordPress template hierarchy. At the end of each PHP template, you'll notice a `Timber::render()` function whose first parameter is the Twig file where that data (or `$context`) will be used. Just an FYI.

`bin/` and `tests/` ... basically don't worry about (or remove) these unless you know what they are and want to.

`composer.json` and `package.json` are files that store the information of all the dependencies this project are using. In particular, the `package.json` also holds the scripts definitions for Patternlab related tasks.

`gulpfile.js` holds the task runners for watching source files and transforming them to static assets.

`alter-twig.php` a Patternlab specific php file that allows you to put custom functions or filters to the Twig templating engine that Patternlab is using.

`*.php` these other php files on the root folder are Wordpress templates, but with Timber we only use them merely as controllers that handles data and just pass these data as `$context` variable to Twig renderers.

### What is Patternlab?

Patternlab provides an environment (using the Twig templating engine) to help you build, test and showcase the design components and styling you develop for the theme. It has a local development host that shows it's own frontend ui that you can view in your browser, it updates itself for every modifications you make on your views (.twig) files.

It can also build a separate static version of the frontend that you can deploy on any hosting allowing your clients to view it.

### What is Twig?

Twig is a templating engine for PHP. While you can do everything on PHP for Wordpress alone, templating engine such as Twig helps you to understand the modern concepts of templating widely used today, but more importantly in this case, as mentioned Patternlab works with Twig files and will be a requirement for developing this theme.

### What is Timber?

Timber is a PHP plugin specifically made for Wordpress that provides the capability to use Twig templating system, ultimately allowing Patternlab and Wordpress to share the same views files. However, with the use of Timber you will also learn the concept of separating the logic handling and the display; it let's your PHP files to focus on data and logic handling while Twig files will handle the display on your frontend, this is a modern technique that gives you clean and maintainable source base.                                                                             

### What is ACF?

ACF stands for Advanced Custom Fields, a very popular Wordpress plugin that makes default Wordpress a blogging system to a great content management system. It has been an invaluable tool to create more possibilities on extending the data on your site to anything you want. We use ACF to create Gutenberg Blocks and Site Options, which pretty much makes up the entire content system of the theme.

### What is Gutenberg Blocks?

With the introduction of Wordpress' Gutenberg Editor along comes the "Blocks" 
which componentize the content, meaning you can build your site's content using blocks. It is now easier more than ever for your content creators to build pages because Wordpress' new editor can now render live previews. It is now your job to create meaningful blocks using ACF for manufacturing the fields of your blocks and Patternlab to design the aesthetics of your blocks.

## The Workflow

Right now Patternlab (views; twig files) and Assets Preprocessors (sass, svg) do not share the same build system; Patternlab has its own NPM task runner scripts while Assets uses Gulp task runner. It's a little bit of a convenience, but once we found a way to make the Gulp edition of Patternlab to work with Twig + Timber setup then we might someday be able to create task runners using Gulp alone. But for now, you need to open up two terminals:

### Development

1. To modify your views twig file open a terminal and enter `npm run start`
2. To work on your stylesheet and icons assets open a new terminal and enter `gulp`

### Debugging

1. Patternlab is configured to already have debug mode enabled.
2. For Wordpress, you need to modify the "WP_DEBUG" to `true` on its wp_config.php file.

### Building Patternlab

To create a deployable instance of your Patternlab to any webhost just run `npm run build` on your terminal, the `public/` folder will be updated and is ready to be pushed or uploaded to a webhost.

TODO:

1. Create gulp task to deploy on Surge.sh for quick free site hosting upload.

### Building Production for Wordpress

TODO: 

Running `gulp build --production` will set the environment to production mode making the build system to use optimizations on the transformed source files outputted to the `assets/` folder.


## TODOS

1. Gulp task to deploy on Surge.sh
2. Gulp production mode
3. Optimization: Gulp Critical CSS Path


## Other Resources

* [Patternlab](https://patternlab.io/docs/overview-of-patterns/)  
* [Twig for Timber Cheatsheet](http://notlaura.com/the-twig-for-timber-cheatsheet/)
* [Timber and Twig Reignited My Love for WordPress](https://css-tricks.com/timber-and-twig-reignited-my-love-for-wordpress/) on CSS-Tricks
* [A real live Timber theme](https://github.com/laras126/yuling-theme).
* [Timber Video Tutorials](http://timber.github.io/timber/#video-tutorials) and [an incomplete set of screencasts](https://www.youtube.com/playlist?list=PLuIlodXmVQ6pkqWyR6mtQ5gQZ6BrnuFx-) for building a Timber theme from scratch.

