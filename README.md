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
  and [Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/)
  .
* Includes Composer, Requirements micropackage to test environment requirements for your plugin, Codeception to do
  unit/acceptance testing, PHPCodeSniffer with WordPress Coding Standards to validate your code, TravisCI configuration
  for automatic testing & continuous integration, object-oriented code structure for better overview, an automatic class
  loader that automatically instantiate classes based on type of request.
* This can be combined with the [Webpack 5 workflow](https://github.com/wp-strap/wordpress-webpack-workflow) for
  front-end development using the npx quickstart script that includes the Webpack v5 bundler, BabelJS v7, BrowserSync
  v2, PostCSS v8, PurgeCSS v3, Autoprefixer, Eslint, Stylelint, SCSS processor, WPPot, and more.

## Quickstart

![Image](https://media2.giphy.com/media/xnkKvAdDteo70lliWF/giphy.gif)

```bash
# Should be run inside your plugins folder (wp-content/plugins).
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
├──classes                       # Holds all the plugin php classes
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
│   ├── Common                   # Utilities & helpers shared in the whole plugin application
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
    │   ├── scss                 # Holds the SCSS files
    │   │ ├─ frontend.scss       # For front-end styling
    │   │ └─ backend.scss        # For back-end / wp-admin styling
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
3. You can activate the plugin in WordPress and work on it straight away. Good luck!

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
- Set your plugin requirements in `classes/Config/Requirements.php` using a simple array
- It can test: PHP version, PHP Extensions, WordPress version, Active plugins, Current theme, DocHooks support
- If the plugin doesn't pass the test then it will be disabled automatically in WordPress and show a notification in the back-end
- Documentation can be found here: https://github.com/micropackage/requirements

### TravisCI
- Configure TravisCI in `.travis.yml`
- Currently it only validates the plugin code with PHPCodeSniffer during automated testing when being deployed
- A great article can be found here: https://stevegrunwell.com/blog/travis-ci-wordpress-plugins/

## Frontend/Webpack tooling
When using webpack then you can use the following for the front-end build process. ([Or read more here](https://github.com/wp-strap/wordpress-webpack-workflow))

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