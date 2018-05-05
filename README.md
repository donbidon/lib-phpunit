# PHPUnit functionality extension
Implements debug functionality, allows to mark groups of tests as skipped  in PHPUnit context.

Allows to reset singleton instance.

Look <a href="//donbidon.github.io/docs/packages/lib-phpunit/" target="_blank">API documentation</a>.

## Installing
Add following code to your "composer.json" file
```json
    "repositories": [
        {
            "type": "vcs",
            "url":  "https://github.com/donbidon/lib-phpunit.git"
        }
    ],
    "require": {
        "donbidon/lib-phpunit": "#v0.1.0"
    }
```
and run `composer update`.
