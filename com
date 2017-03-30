{
    "_readme": [
        "This file locks the dependencies of your project to a known state",
        "Read more about it at https://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file",
        "This file is @generated automatically"
    ],
    "content-hash": "219228a149b7a01cb8db2a703db8cb59",
    "packages": [
        {
            "name": "linecorp/line-bot-sdk",
            "version": "1.4.0",
            "source": {
                "type": "git",
                "url": "https://github.com/line/line-bot-sdk-php.git",
                "reference": "45e00a580524da0f614c91c5c61135d01bb338e1"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/line/line-bot-sdk-php/zipball/45e00a580524da0f614c91c5c61135d01bb338e1",
                "reference": "45e00a580524da0f614c91c5c61135d01bb338e1",
                "shasum": ""
            },
            "require": {
                "php": ">=5.6"
            },
            "require-dev": {
                "apigen/apigen": "~4.1",
                "phpmd/phpmd": "~2.4",
                "phpunit/phpunit": "^4.8.24",
                "squizlabs/php_codesniffer": "~2.6"
            },
            "type": "library",
            "autoload": {
                "psr-4": {
                    "LINE\\": "src/"
                }
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "Apache License Version 2.0"
            ],
            "authors": [
                {
                    "name": "MJ",
                    "email": "jen.zein@gmail.com"
                },
               
            ],
            "description": "SDK of the LINE BOT API for PHP",
            "homepage": "https://github.com/line/line-bot-sdk-php",
            "keywords": [
                "bot",
                "line",
                "sdk"
            ],
            "time": "2017-01-20T14:05:54+00:00"
        }
    ],
    "packages-dev": [],
    "aliases": [],
    "minimum-stability": "stable",
    "stability-flags": [],
    "prefer-stable": false,
    "prefer-lowest": false,
    "platform": [],
    "platform-dev": []
}
