# WordPress Plugin Boilerplate
An organized, object-oriented, and lightweight boilerplate for testable WordPress plugin development


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
* `classes/App/Cli` - code for cli integrations
* `classes/App/Cron` - code for cron events
* `classes/App/Rest` - code for rest API functionalities
* `classes/Config` - plugin configuration code
* `classes/Common` - utilities shared in the whole plugin application
* `classes/Integrations` - includes the integration with libraries, API's or other plugins
* `classes/Compatability` - 3rd party compatibility code
* `templates` - all the template files
* `tests` - all the tests using Codeception
* `assets` - all the assets files (css/js/images), can be extended with Webpack/Gulp for SCSS and babel etc.

### Acceptance & Unit Testing
  - Testing with Codeception works out of the box
  - Create test files with `composer generate:wpunit` or `composer generate:acceptance`
  - Write your test methods and run `composer run:wpunit` or `composer run:acceptance`