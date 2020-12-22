[![Build Status](https://travis-ci.org/elliotjon/weather-module.svg?branch=master)](https://travis-ci.org/elliotjon/weather-module)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/elliotjon/weather-module/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/elliotjon/weather-module/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/elliotjon/weather-module/badges/build.png?b=master)](https://scrutinizer-ci.com/g/elliotjon/weather-module/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/elliotjon/weather-module/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/elliotjon/weather-module/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/elliotjon/weather-module/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

# Weather Module
This module is a part of course 'Webbaserade ramverk 1' at Blekinge Institute of Technology. The Weather Module  is a package for framework Anax.

## Default instructions
Instructions on how to implement the module into an existing Anax installation. Either with composer or scaffolding.

### Composer install
`composer require elliotjon/weather-module`

### Scaffolding install
Add this to your existing composer.json file:  
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/elliotjon/weather-module"
    }
],
"require": {
    "anax/anax-ramverk1-me": "^1.0.0",
    "elliotjon/weather-module": "dev-master"
}
```

Run `composer update`

#### Installation script
The weather module contains a installation script, for installing required files into anax.  
`bash vendor/elliotjon/weather-module/.anax/scaffold/postprocess.d/600_weather_module.bash`

Or do it manually with the following:  

#### Config
Copy config files into anax  
`rsync -av vendor/elliotjon/weather-module/config ./`

#### View
Copy view files into anax  
`rsync -av vendor/elliotjon/weather-module/view ./`

#### Src
Copy src files into anax  
`rsync -av vendor/elliotjon/weather-module/src ./`

#### Test
Copy test files into anax  
`rsync -av vendor/elliotjon/weather-module/test ./`


### Access
If you have remembered to add your access keys in config/accesss.php,  
the module can now be reached at `/geo`