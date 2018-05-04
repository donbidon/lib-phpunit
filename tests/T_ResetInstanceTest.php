<?php
/**
 * T_ResetInstance trait unit tests.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\Lib\PHPUnit;

/**
 * Class used to test T_ResetInstance trait.
 */
class T_ResetInstance_FirstSingleton
{
    use T_ResetInstance;

    /**
     * Number of times when constructor was called
     *
     * @var int
     */
    protected static $count = 0;

    /**
     * Instance
     *
     * @var self
     */
    protected static $oneInstance;

    /**
     * Returns singleton instance.
     *
     * @return self
     */
    public static function getInstance()
    {
        if (!is_object(self::$oneInstance)) {
            self::$oneInstance = new self;
        }

        return self::$oneInstance;
    }

    /**
     * Returns number of times when constructor was called.
     *
     * @return int
     */
    public static function getCount()
    {
        return self::$count;
    }

    /**
     * Returns instance property name.
     *
     * @return string
     */
    public function getInstancePropertyName()
    {
        return self::$instancePropertyName;
    }

    /**
     * Constructor.
     */
    protected function __construct()
    {
        self::setInstancePropertyName("oneInstance");
        $this->allowToResetInstance();
        self::$count++;
    }
}

/**
 * Class used to test T_ResetInstance trait.
 */
class T_ResetInstance_SecondSingleton
{
    use T_ResetInstance;

    /**
     * Number of times when constructor was called
     *
     * @var int
     */
    protected static $count = 0;

    /**
     * Instance
     *
     * @var self
     */
    protected static $otherInstance;

    /**
     * Returns singleton instance.
     *
     * @return self
     */
    public static function getInstance()
    {
        if (!is_object(self::$otherInstance)) {
            self::$otherInstance = new self;
        }

        return self::$otherInstance;
    }

    /**
     * Returns number of times when constructor was called.
     *
     * @return int
     */
    public static function getCount()
    {
        return self::$count;
    }

    /**
     * Returns instance property name.
     *
     * @return string
     */
    public function getInstancePropertyName()
    {
        return self::$instancePropertyName;
    }

    /**
     * Constructor.
     */
    protected function __construct()
    {
        self::setInstancePropertyName("otherInstance");
        $this->allowToResetInstance();
        self::$count++;
    }
}

/**
 * T_ResetInstance trait unit tests.
 */
class T_ResetInstanceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests functionality.
     *
     * @return void
     * @covers donbidon\Lib\PHPUnit\T_ResetInstance::resetInstance
     * @covers donbidon\Lib\PHPUnit\T_ResetInstance::setInstancePropertyName
     * @covers donbidon\Lib\PHPUnit\T_ResetInstance::allowToResetInstance
     */
    public function testFunctionality()
    {
        T_ResetInstance_FirstSingleton::getInstance();
        T_ResetInstance_FirstSingleton::resetInstance();
        $first = T_ResetInstance_FirstSingleton::getInstance();
        $second = T_ResetInstance_SecondSingleton::getInstance();
        $this->assertEquals(
            "donbidon\\Lib\\PHPUnit\\T_ResetInstance_FirstSingleton",
            get_class($first),
            "Invalid singleton instance"
        );
        $this->assertEquals(
            "donbidon\\Lib\\PHPUnit\\T_ResetInstance_SecondSingleton",
            get_class($second),
            "Invalid singleton instance"
        );
        $this->assertEquals(
            2,
            T_ResetInstance_FirstSingleton::getCount(),
            "Invalid number of times when constructor was called"
        );
        $this->assertEquals(
            1,
            T_ResetInstance_SecondSingleton::getCount(),
            "Invalid number of times when constructor was called"
        );
        $this->assertEquals(
            "oneInstance",
            $first->getInstancePropertyName(),
            "Invalid singleton instance property name"
        );
        $this->assertEquals(
            "otherInstance",
            $second->getInstancePropertyName(),
            "Invalid singleton instance property name"
        );
    }
}
