# WordPress Plugin Boilerplate 

[![Build Status](https://api.travis-ci.org/wp-strap/wordpress-plugin-boilerplate.svg?branch=master&status=passed)](https://travis-ci.org/github/wp-strap/wordpress-plugin-boilerplate)
![PHP 7.1+](https://img.shields.io/badge/PHP-7.1%2B-brightgreen)
<table width='100%' align="center">
    <tr>
        <td align='left' width='100%' colspan='2'>
            <strong>Plugin boilerplate with modern tools to kickstart your WordPress project</strong><br />
            This includes common and modern tools to facilitate plugin development and testing with an organized, object-oriented structure for testable WordPress plugin development and kick-start a build-workflow for your WordPress plugins. 
        </td>
    </tr>

</table>

* The Boilerplate is  based on the [Plugin API](https://codex.wordpress.org/Plugin_API), [Coding Standards](https://codex.wordpress.org/WordPress_Coding_Standards), and [Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/).
* Includes Composer, Requirements micropackage to test environment requirements for your plugin, Codeception to do unit/acceptance testing, PHPCodeSniffer with WordPress Coding Standards to validate your code, TravisCI configuration for automatic testing & continuous integration, object oriented code structure, an automatic class loader that automatically instantiate classes based on type of request and more.
* This can be combined with the [Webpack 5 workflow](https://github.com/wp-strap/wordpress-webpack-workflow) for front-end development using the npx script that includes the Webpack v5 bundler, BabelJS v7, BrowserSync v2, PostCSS v8, PurgeCSS v3, Autoprefixer, Eslint, Stylelint, SCSS processor, WPPot, and more.

## Installation
Install directly into the plugins folder of a WordPress installation and then rename from `wordpress-plugin-boilerplate` to whatever you want your plugin to be named:

    composer create-project wpstrap/wordpress-plugin-boilerplate

Currently a lot of Find and Replace is needed.

### Plugin Structure

You can add your own new class files by naming them correctly and putting the files in the most appropriate location, see other files for examples. Composer's Autoloader and the Bootstrap class will auto include your file and instantiate the class. The idea of this organisation is to be more conscious of structuring your code.

* `classes/App` - holds the plugin application-specific functionality
* `classes/App/Frontend` - all public-facing functionality
* `classes/App/Backend` - all admin-specific functionality
* `classes/App/General` - functionality shared between the back-end and frontend
* `classes/App/Cli` - code for cli commands
* `classes/App/Cron` - code for cron events
* `classes/App/Rest` - code for rest api functionalities
* `classes/Config` - plugin configuration code
* `classes/Common` - utilities shared in the whole plugin application
* `classes/Integrations` - includes the integration with libraries, api's or other plugins
* `classes/Compatability` - 3rd party compatibility code
* `templates` - all the template files
* `tests` - all the tests using Codeception
* `assets` - all the assets files (css/js/images), can be extended with Webpack/Gulp for SCSS and babel etc.

### Acceptance & Unit Testing
  - Testing with Codeception works out of the box
  - Configure the environments settings in `.env.testing`
  - Create test files with `composer generate:wpunit` or `composer generate:acceptance`
  - Write your test methods and run `composer run:wpunit` or `composer run:acceptance`
  - Extensive documentation can be found here https://codeception.com/for/wordpress  