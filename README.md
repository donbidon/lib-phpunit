# PHPUnit functionality extension
Allows to mark group of tests as skipped.

Resetting singleton instance functionality.

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
        "donbidon/lib-phpunit": "dev-master"
    }
```
and run `composer update`.

## Usage

### Mark tests as skipped

```php
class MyTest extends \donbidon\Lib\PHPUnit\TestCase
{
    public function testFoo()
    {
        $expected = 1;
        $actual   = 2;
        if ($expected !== $actual) {
            // Mark group of tests as skipped
            self::skipGroup('someGroup');
        }
        // Failed assertion
        self::assertEquals($expected, $actual);
    }

    public function testBar()
    {
        // Skip test
        self::checkGroupIfSkipped('someGroup');
        // Following code won't run
        self::assertEquals(1, 1);
    }
}
```
outputs
```
FAILURES!
Tests: 2, Assertions: 1, Failures: 1, Skipped: 1.
```

### Resetting singleton instance
```php
class Foo
{
    use \donbidon\Lib\PHPUnit\T_ResetInstance;

    protected static $myInstance;

    public static function getInstance()
    {
        if (!is_object(self::$myInstance)) {
            self::$myInstance = new self;
        }

        return self::$myInstance;
    }

    protected function __construct()
    {
        self::setInstancePropertyName('myInstance');
        $this->allowToResetInstance();

        echo sprintf(
            "%s called\n",
            __METHOD__
        );
    }
}

Foo::getInstance();
Foo::resetInstance();
Foo::getInstance();
```
outputs
```
Foo::__construct() called
Foo::__construct() called
```
