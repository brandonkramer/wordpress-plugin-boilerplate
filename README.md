# WordPress Plugin Boilerplate

[![Build Status](https://api.travis-ci.org/wp-strap/wordpress-plugin-boilerplate.svg?branch=master&status=passed)](https://travis-ci.org/github/wp-strap/wordpress-plugin-boilerplate)
![PHP 7.1+](https://img.shields.io/badge/PHP-7.1%2B-brightgreen)
<table width='100%' align="center">
    <tr>
        <td align='left' width='100%' colspan='2'>
            <strong>Plugin boilerplate with modern tools to kickstart your WordPress project</strong><br />
            This includes common and modern tools to facilitate plugin development and testing with an organized, object-oriented structure and kick-start a build-workflow for your WordPress plugins. 
        </td>
    </tr>
</table>

* The Boilerplate is based on the [Plugin API](https://codex.wordpress.org/Plugin_API)
  , [Coding Standards](https://codex.wordpress.org/WordPress_Coding_Standards),
  and [Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/).
* Includes Composer, Requirements micropackage to test environment requirements for your plugin, Codeception to do
  unit/acceptance testing, PHPCodeSniffer with WordPress Coding Standards to validate your code, TravisCI configuration
  for automatic testing & continuous integration, object-oriented code structure for better overview, an automatic class
  loader that automatically instantiate classes based on type of request.
* This can be combined with the [Webpack 5 workflow](https://github.com/wp-strap/wordpress-webpack-workflow) for
  front-end development using the npx quickstart script that includes the Webpack v5 bundler, BabelJS v7, BrowserSync
  v2, PostCSS v8, PurgeCSS v3, Autoprefixer, Eslint, Stylelint, SCSS processor, WPPot, and more.

## Quickstart

![Image](https://media.giphy.com/media/2Fb95iB53xkOAlYeTv/source.gif)

Should be run inside your plugins folder (wp-content/plugins).
```bash
npx wp-strap plugin
```

You can also use the npx script with predefined answers to get a quicker start
```bash
npx wp-strap plugin "projectName:Your plugin name" "description:Test the plugin" "pluginVersion:1.0.0" license:MIT "author:The Dev Company" authorEmail:hello@the-dev-company.com url:the-dev-company.com webpack:Y codesniffer:Y codeception:Y travisCi:Y css:Sass+PostCSS
```

It will take a couple of minutes to install after your terminal input; it will clone the git repo's, search and replace
all the plugin data, do a `composer install`, and when it's combined with the Webpack workflow then it wil also do
a `npm install `

<a href="#what-to-configure">Read more about the configuration & build scripts</a>
## Features & benefits

### Backend

**Composer** (Namespaces + PSR4 autoloader + Dependency manager)
>- [**Namespace**](https://www.php.net/manual/en/language.namespaces.rationale.php) support to group all of your code under a custom name. That way, your classes, functions, and so on don’t clash with other people’s code running on the site at the same time
>- [**PSR-4 Autoloader**](https://www.php-fig.org/psr/psr-4/) to autoload files and directories in connection with namespaces
>- Includes a [**dependency manager**](https://getcomposer.org/doc/00-intro.md#dependency-management) to easily load in 3rd party libraries from [**packagist**](https://packagist.org/), locked onto specific versions

**Object-oriented & classes autoloader**
>- Includes a [**OOP-style**](https://developer.wordpress.org/plugins/plugin-basics/best-practices/#object-oriented-programming-method) structure for building a high-quality PHP development
>- Classes are being [auto-instantiated](https://github.com/wp-strap/wordpress-plugin-boilerplate/blob/master/src/Bootstrap.php#L79) by extending the PSR-4 Autoloader from Composer and [based on type of request and folder structure](https://github.com/wp-strap/wordpress-plugin-boilerplate/blob/master/src/Config/Classes.php#L28) for which you can add the [types of request here](https://github.com/wp-strap/wordpress-plugin-boilerplate/blob/master/src/Common/Traits/Requester.php#L30). So you can add your own new class files by naming them correctly and putting the files in the most appropriate location and work in it straight away without having to include them or instantiate them manually. Composer's Autoloader and the Bootstrap class will auto include your file and instantiate the class.
>- The structure follows the the [Plugin API](https://codex.wordpress.org/Plugin_API)
   , [Coding Standards](https://codex.wordpress.org/WordPress_Coding_Standards),
   and [Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/)

**PHPCodeSniffer + WordPress Coding Standards + Automattic's phpcs-neutron-ruleset** 
>- [**PHP CodeSniffer**](https://github.com/squizlabs/PHP_CodeSniffer) is built in with predefined configuration for proper linting. PHP_CodeSniffer is an essential development tool that ensures your code remains clean and consistent.
>- PHPCS is extended with the [**WordPress Coding Standards**](https://github.com/WordPress/WordPress-Coding-Standards) & [**PHPCompatibilityWP**](https://github.com/PHPCompatibility/PHPCompatibilityWP) for PHP_CodeSniffer which is a collection of PHP_CodeSniffer rules (sniffs) to validate code developed for WordPress. It ensures code quality and adherence to coding conventions, especially the official WordPress Coding Standards.
>- PHPCS is also extented with [**Automattic's phpcs-neutron-ruleset**](https://github.com/Automattic/phpcs-neutron-ruleset) which is a set of modern (PHP >7) linting guidelines for WordPress development. 

**Codeception (unit/acceptance testing)**
>- [**Codeception**](https://codeception.com/for/wordpress) is built in which combines all testing levels (acceptance, functional, integration, unit) with  WordPress defined functions, constants, classes and methods in any test.
>- With a flexible set of included modules, tests are easy to write, easy to use, and easy to maintain.


**Plugin requirements**
>- [**Requirements micropackage**](https://github.com/micropackage/requirements) is built in that allows you to test environment requirements to run your plugin. It can test: PHP version, PHP Extensions, WordPress version, Active plugins, Current theme, DocHooks support
>- Easily to configure using a [**simple array**](https://github.com/wp-strap/wordpress-plugin-boilerplate/blob/master/src/Config/Requirements.php#L35)
>- If the plugin doesn't pass the test then it will disable the plugin automatically for the user in WordPress and show a notification in the back-end


**TravisCI**
>- Ready to use [**TravisCI**](https://travis-ci.org/) configuration for automatic testing & continuous integration which currently only validates the plugin code with PHPCodeSniffer during automated testing when being deployed, but can also be extended to test unit/acceptance cases from Codeception

**Prettified errors & Classes debug array**
>- Includes a function called `Errors::wpDie` to show a [prettified WP_DEBUG error](https://i.imgur.com/PFoIwxD.png) with the plugin information and file source
>- Includes a function called `Errors::pluginDie` to kill the plugin and show a [prettified admin notification](https://i.imgur.com/WGE9sBv.png) with the plugin information and file source
>- Includes a [function if set true](https://github.com/wp-strap/wordpress-plugin-boilerplate/blob/master/src/Bootstrap.php#L43) to [debug the bootstrap's class loader and see](https://i.imgur.com/Rg2bSEq.png) which classes are loaded, if they load on the requested page, in which order and to check the execution time of the code run in each class


### Frontend (Webpack)
For front-end tooling the webpack workflow is being cloned. Read more about this workflow here: https://github.com/wp-strap/wordpress-webpack-workflow

**Styling (CSS)**

>- **Minification** in production mode handled by Webpack
>- [**PostCSS**](http://postcss.org/) for handy tools during post CSS transformation using Webpack's [**PostCSS-loader**](https://webpack.js.org/loaders/postcss-loader/)
>- **Auto-prefixing** using PostCSS's [**autoprefixer**](https://github.com/postcss/autoprefixer) to parse CSS and add vendor prefixes to CSS rules using values from [Can I Use](https://caniuse.com/). It is [recommended](https://developers.google.com/web/tools/setup/setup-buildtools#dont_trip_up_with_vendor_prefixes) by Google and used in Twitter and Alibaba.
>- [**PurgeCSS**](https://github.com/FullHuman/purgecss) which scans your php (template) files to remove unused selectors from your css when in production mode, resulting in smaller css files.
>- **Sourcemaps** generation for debugging purposes with [various styles of source mapping](https://webpack.js.org/configuration/devtool/) handled by WebPack
>- [**Stylelint**](https://stylelint.io/) that helps you avoid errors and enforce conventions in your styles. It includes a [linting tool for Sass](https://github.com/kristerkari/stylelint-scss).

**Styling when using PostCSS-only**
>- Includes [**postcss-import**](https://github.com/postcss/postcss-import) to consume local files, node modules or web_modules with the @import statement
>- Includes [**postcss-import-ext-glob**](https://github.com/dimitrinicolas/postcss-import-ext-glob) that extends postcss-import path resolver to allow glob usage as a path
>- Includes [**postcss-nested**](https://github.com/postcss/postcss-nested) to unwrap nested rules like how Sass does it.
>- Includes [**postcss-nested-ancestors**](https://github.com/toomuchdesign/postcss-nested-ancestors) that introduces ^& selector which let you reference any parent ancestor selector with an easy and customizable interface
>- Includes [**postcss-advanced-variables**](https://github.com/jonathantneal/postcss-advanced-variables) that lets you use Sass-like variables, conditionals, and iterators in CSS.


**Styling when using Sass+PostCSS**
> - **Sass to CSS conversion** using Webpack's [**sass-loader**](https://webpack.js.org/loaders/sass-loader/)
>- Includes [**Sass magic importer**](https://github.com/maoberlehner/node-sass-magic-importer) to do lot of fancy things with Sass @import statements


**JavaScript**
> - [**BabelJS**](https://babeljs.io/) Webpack loader to use next generation Javascript with a  **BabelJS Configuration file**
>- **Minification** in production mode
>- [**Code Splitting**](https://webpack.js.org/guides/code-splitting/), being able to structure JavaScript code into modules & bundles
>- **Sourcemaps** generation for debugging purposes with [various styles of source mapping](https://webpack.js.org/configuration/devtool/) handled by WebPack
>- [**ESLint**](https://eslint.org/) find and fix problems in your JavaScript code with a  **linting configuration** including configurations and custom rules for WordPress development.
>- [**Prettier**](https://prettier.io/) for automatic JavaScript / TypeScript code **formatting**

**Images**

> - [**ImageMinimizerWebpackPlugin**](https://webpack.js.org/plugins/image-minimizer-webpack-plugin/) + [**CopyWebpackPlugin**](https://webpack.js.org/plugins/copy-webpack-plugin/)
    to optimize (compress) all images using
>- _File types: `.png`, `.jpg`, `.jpeg`, `.gif`, `.svg`_

**Translation**

> - [**WP-Pot**](https://github.com/wp-pot/wp-pot-cli) scans all the files and generates `.pot` file automatically for i18n and l10n

**BrowserSync, Watcher & WebpackBar**

> - [**Watch Mode**](https://webpack.js.org/guides/development/#using-watch-mode), watches for changes in files to recompile
>- _File types: `.css`, `.html`, `.php`, `.js`_
>- [**BrowserSync**](https://browsersync.io/), synchronising browsers, URLs, interactions and code changes across devices and automatically refreshes all the browsers on all devices on changes
>- [**WebPackBar**](https://github.com/nuxt/webpackbar) so you can get a real progress bar while development which also includes a **profiler**

**Configuration**

> - All configuration files `.prettierrc.js`, `.eslintrc.js`, `.stylelintrc.js`, `babel.config.js`, `postcss.config.js` are organised in a single folder
>- The Webpack configuration is divided into 2 environmental config files for the development and production build/environment

## Requirements
- [Composer](https://getcomposer.org/doc/00-intro.md)
- [Node.js](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [Yarn](https://classic.yarnpkg.com/en/docs/install/#mac-stable)

## File structure
You can add your own new class files by naming them correctly and putting the files in the most appropriate location,
see other files for examples. Composer's Autoloader and the Bootstrap class will auto include your file and instantiate
the class. The idea of this organisation is to be more conscious of structuring your code.

```bash
│ ## First level files
├──the-plugin-name.php           # Main entry file for the plugin
├──composer.json                 # Composer dependencies & scripts
├──phpcs.xml.dist                # PHPCodeSniffer configuration
├──codeception.dist.yml          # Codeception testing configuration
├──.env.testing                  # Codeception testing environment configuration
├──.travis.yml                   # TravisCI configuration for automatic testing & continuous integration
├──package.json                  # (incl. when using webpack) Node.js dependencies & scripts (NPM functions)
├──webpack.config.js             # (incl. when using webpack) Holds all the base Webpack configurations
│
│ ## Folders
├──src                           # Holds all the plugin php classes
│   ├── Bootstrap.php            # Bootstraps the plugin and auto-instantiate classes
│   ├── App                      # Holds the plugin application-specific functionality
│   │   ├── Frontend             # All public-facing hooks/functionality
│   │   ├── Backend              # All admin-specific hooks/functionality
│   │   ├── General              # Hooks/functionality shared between the back-end and frontend
│   │   ├── Cli                  # Code for cli commands
│   │   ├── Cron                 # Code for cron events
│   │   ├── Rest                 # Code for rest api functionalities
│   ├── Config                   # Plugin configuration code
│   │   ├── Classes.php          # Defines the folders and order of classes to init
│   │   ├── I18n.php             # Internationalization and localization definitions
│   │   ├── Plugin.php           # Plugin data which are used through the plugin
│   │   ├── Requirements.php     # Defines the requirements that are needed to run this plugin.
│   │   ├── Setup.php            # Plugin setup hooks (activation, deactivation, uninstall)
│   ├── Common                   # Utilities & helpers shared in the whole plugin 
│   │   ├── Abstracts            # Here you can add abstract classes to extend your php classes
│   │   │   ├── Base.php         # A base class which all classes extends to load in default methods, currently the plugin data is only being injected
│   │   ├── Traits               # Here you can add handy traits to extend your php classes
│   │   │   ├── Requester.php    # The requester trait to determine what we request; used to determine which classes we instantiate in the Bootstrap class
│   │   │   ├── Singleton.php    # The singleton skeleton trait to instantiate the class only once
│   │   ├── Utils                # Here you can add helper/utiliy functions, eg: array functions
│   │   │   ├── Errors.php       # Utility class for the prettified errors and to write debug logs as string or array
│   │   ├── Functions.php        # Main function class for external/global functions, eg: "plugin_name()->your_function"
│   ├── Integrations             # Includes the integration with libraries, api's or other plugins
│   ├── Compatibility            # 3rd party compatibility code
├──tests                         # Codeception test files
├──templates                     # Folder to include all the template files
│   ├── test-template.php        # Example template file
├──languages                     # WordPress default language map in Plugins & Themes
│   ├── the-plugin-name.pot      # Boilerplate POT File that gets overwritten by WP-Pot 
├──webpack                       # (incl. when using webpack) Holds all the sub-config files for webpack
│   ├── .prettierrc.js           # Configuration for Prettier
│   ├── .eslintrc.js             # Configuration for Eslint
│   ├── .stylelintrc.js          # Configuration for Stylelint
│   ├── babel.config.js          # Configuration for BabelJS
│   ├── postcss.config.js        # Configuration for PostCSS
│   ├── config.base.js           # Base config for Webpack's development & production mode
│   ├── config.development.js    # Configuration for Webpack in development mode
│   └── config.production.js     # Configuration for Webpack in production mode
└──assets
    ├── src                      # (incl. when using webpack) Holds all the source files
    │   ├── images               # Uncompressed images
    │   ├── scss/pcss            # Holds the Sass/PostCSS files
    │   │ ├─ frontend.scss/pcss  # For front-end styling
    │   │ └─ backend.scss/pcss   # For back-end / wp-admin styling
    │   └── js                   # Holds the JS files
    │     ├─ frontend.js         # For front-end scripting
    │     └─ backend.js          # For back-end / wp-admin scripting
    │
    └── public
        ├── images               # Optimized (compressed) images
        ├── css                  # Compiled CSS files with be generated here
        └── js                   # Compiled JS files with be generated here
```

## What to configure

1. When using codeception; configure the environments settings in `.env.testing`, other configurations can be found in `codeception.dist.yml`
2. When using Webpack; edit the BrowserSync settings in `webpack.config.js` which applies to your local/server environment
    - You can also disable BrowserSync, Eslint & Stylelint in `webpack.config.js`
    - You may want to configure the files in `/webpack/` and `webpack.config.js` to better suite your needs
3. You can activate the plugin in WordPress and work on it straight away. 

### Acceptance & Unit Testing

- Testing with Codeception works out of the box
- Create test files with `composer generate:wpunit` or `composer generate:acceptance`
- Write your test methods and run `composer run:wpunit` or `composer run:acceptance`
- Extensive documentation can be found here https://codeception.com/for/wordpress

### PHPCodeSniffer

- Run PHPCodeSniffer with  `composer phpcs` to validate your plugin code
- Configure PHPCodeSniffer in `phpcs.xm.dist`
- Documentation can be found here:
  - https://github.com/WordPress/WordPress-Coding-Standards
  - https://github.com/Dealerdirect/phpcodesniffer-composer-installer
  - https://github.com/Automattic/phpcs-neutron-ruleset
  - https://github.com/PHPCompatibility/PHPCompatibilityWP

### Plugin requirements
- Set your plugin requirements in `src/Config/Requirements.php` using a simple array
- It can test: PHP version, PHP Extensions, WordPress version, Active plugins, Current theme, DocHooks support
- If the plugin doesn't pass the test then it will be disabled automatically in WordPress and show a notification in the back-end
- Documentation can be found here: https://github.com/micropackage/requirements

### TravisCI
- Configure TravisCI in `.travis.yml`
- Currently it only validates the plugin code with PHPCodeSniffer during automated testing when being deployed
- A great article can be found here: https://stevegrunwell.com/blog/travis-ci-wordpress-plugins/

## Frontend/Webpack tooling
When using webpack then you can use the following for the front-end build process. [Read here more](https://github.com/wp-strap/wordpress-webpack-workflow) for more information about this workflow.

### Developing Locally

To work on the project locally (with Eslint, Stylelint & Prettier active), run:

```bash
yarn dev
```

Or run with watcher & browserSync

```bash
yarn dev:watch
```

This will open a browser, watch all files (php, scss, js, etc) and reload the browser when you press save.

### Building for Production

To create an optimized production build (purged with PurgeCSS & fully minified CSS & JS files), run:

```bash
yarn prod
```

Or run with watcher & browserSync

```bash
yarn prod:watch
```

### More Scripts/Tasks

```bash
# To scan for text-domain functions and generate WP POT translation file
yarn translate

# To find problems in your JavaScript code
yarn eslint 

# To find fix problems in your JavaScript code
yarn eslint:fix

# To find problems in your sass/css code
yarn stylelint

# To find fix problems in your sass/css code
yarn stylelint:fix

# To make sure files in assets/src/js are formatted
yarn prettier

# To fix and format the js files in assets/src/js
yarn prettier:fix
```

## Composer.json dependencies

<table>
	<thead>
	<tr>
		<th>Depedency</th>
		<th>Description</th>
		<th>Version</th>
	</tr>
	</thead>
	<thead>
	<tr>
		<th></th>
		<th>Plugin Requirements</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<tr>
		<td>micropackage/requirements</td>
		<td>Allows you to test environment requirements to run your plugin.</td>
		<td>1.0</td>
	</tr>
    </tbody>
	<thead>
	<tr>
		<th></th>
		<th>PHPCodeSniffer</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>dealerdirect/phpcodesniffer-composer-installer</td>
		<td>Allows for easy installation of PHP_CodeSniffer coding standards (rulesets)</td>
		<td>0.7.1</td>
	</tr>
	<tr>
		<td>wp-coding-standards/wpcs</td>
		<td>Collection of PHP_CodeSniffer rules (sniffs) to validate code developed for WordPress</td>
		<td>*</td>
	</tr>
	<tr>
		<td>automattic/phpcs-neutron-ruleset</td>
		<td>Set of modern (PHP >7) linting guidelines for WordPress development</td>
		<td>3.3</td>
	</tr>
	<tr>
		<td>phpcompatibility/phpcompatibility-wp</td>
		<td>Analyse the codebase of a WordPress-based project for PHP cross-version compatibility</td>
		<td>2.1</td>
	</tr>
    </tbody>
	<thead>
	<tr>
		<th></th>
		<th>Codeception</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>lucatume/function-mocker</td>
		<td>A Patchwork powered function mocker to mock function for testing</td>
		<td>1.0</td>
	</tr>
	<tr>
		<td>lucatume/wp-browser</td>
		<td>Provides easy acceptance, functional, integration and unit testing for WordPress plugins, themes and whole sites using Codeception</td>
		<td>3.0</td>
	</tr>
	<tr>
		<td>Codeception/lib-innerbrowser</td>
		<td>Parent library for all Codeception framework modules and PhpBrowser.</td>
		<td>1.0</td>
	</tr>
	<tr>
		<td>codeception/module-asserts</td>
		<td>A Codeception module containing various assertions</td>
		<td>1.0</td>
	</tr>
	<tr>
		<td>codeception/module-phpbrowser</td>
		<td>Use to perform web acceptance tests with non-javascript browser</td>
		<td>1.0</td>
	</tr>
	<tr>
		<td>codeception/module-webdriver</td>
		<td>Run tests in real browsers using the W3C WebDriver protocol.</td>
		<td>1.0</td>
	</tr>
	<tr>
		<td>codeception/module-db</td>
		<td>A database module for Codeception.</td>
		<td>1.0</td>
	</tr>
	<tr>
		<td>codeception/module-filesystem</td>
		<td>A Codeception module for testing local filesystem.</td>
		<td>1.0</td>
	</tr>
	<tr>
		<td>codeception/module-cli</td>
		<td>A Codeception module for testing basic shell commands and shell output.</td>
		<td>1.0</td>
	</tr>
	<tr>
		<td>codeception/module-rest</td>
		<td>A REST module for Codeception</td>
		<td>1.2</td>
	</tr>
	<tr>
		<td>codeception/util-universalframework</td>
		<td>Mock framework module used in internal Codeception tests</td>
		<td>1.0</td>
	</tr>
	<tr>
		<td>codeception/codeception-progress-reporter</td>
		<td>Reporter for codeception with a progress bar</td>
		<td>4.0.2</td>
	</tr>
	</tbody>
</table>

## Package.json dependencies
https://github.com/wp-strap/wordpress-webpack-workflow#packagejson-dependencies

## Boilerplate's Changelog

Documenting this project's progress...
#### January 15, 2021
* refactor: (webpack/frontend) Migrated from NPM to Yarn for speed, `install` went from 183.281s to 65.76s-90.02s.
#### January 14, 2021
* feat: Added `POT` File with all the translation strings
* refactor: Moved classes array to own config file
* feat: Added `npx` CLI build script + docs
#### January 9, 2021
* refactor: Rename plugin (meta) data to replace-able names
#### January 8, 2021
* feat: Added `PHP_CodeSniffer` with `WordPress-Coding-Standards` including configuration file
* feat(`.travis.yml`): added TravisCI configuration file
* feat: Added bootstrap classes debugger method
* feat: `README.md` file
