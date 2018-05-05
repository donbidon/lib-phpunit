# PHPUnit functionality extension
Implements debug functionality, allows to mark groups of tests as skipped  in PHPUnit context.

Allows to reset singleton instance.

Look [**donbidon/lib-phpunit docs**](https://donbidon.github.io/docs/packages/lib-phpunit).

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
        "donbidon/lib-phpunit": "v#0.1.0"
    }
```
and run `composer update`.

## Usage

### Mark tests as skipped
```php
class MyClass
{
     public function foo()
     {
     }

     public function bar()
     {
     }
}

class MyClassTest extends \donbidon\Lib\PHPUnit\TestCase
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

        echo sprintf("%s called%s", __METHOD__, PHP_EOL);
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
