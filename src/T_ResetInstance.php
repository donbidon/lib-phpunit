<?php
/**
 * Functionality allowing to reset singleton instance.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

namespace donbidon\Lib\PHPUnit;

/**
 * Implements functionality allowing to reset singleton instance.
 *
 * ```php
 * class Foo
 * {
 *     use \donbidon\Lib\PHPUnit\T_ResetInstance;
 *
 *     protected static $myInstance;
 *
 *     public static function getInstance()
 *     {
 *         if (!is_object(self::$myInstance)) {
 *             self::$myInstance = new self;
 *         }
 *
 *         return self::$myInstance;
 *     }
 *
 *     protected function __construct()
 *     {
 *         self::setInstancePropertyName('myInstance');
 *         $this->allowToResetInstance();
 *
 *         echo sprintf("%s called%s", __METHOD__, PHP_EOL);
 *     }
 * }
 *
 * Foo::getInstance();
 * Foo::resetInstance();
 * Foo::getInstance();
 * ```
 * outputs
 * ```
 * Foo::__construct() called
 * Foo::__construct() called
 * ```
 */
trait T_ResetInstance
{
    /**
     * Singleton instance property name
     *
     * @var string
     */
    private static $instancePropertyName = 'instance';

    /**
     * Allow to reset singleton instance flag
     *
     * @var bool
     */
    private $allowToResetInstance = FALSE;

    /**
     * Resets static instance.
     *
     * @return void
     * @throws \RuntimeException  If resetting of instance disallowed
     */
    public static function resetInstance()
    {
        $name = self::$instancePropertyName;
        if (is_object(self::$$name)) {
            if (self::$$name->allowToResetInstance) {
                self::$$name = null;
            } else {
                throw new \RuntimeException(
                    "Resetting of singleton instance disallowed"
                );
            }
        }
    }

    /**
     * Sets instance property name.
     *
     * @param  string $name
     * @return void
     */
    protected static function setInstancePropertyName($name)
    {
        self::$instancePropertyName = (string)$name;
    }

    /**
     * Allows or disallows to reset instance.
     *
     * @param  bool $allow
     * @return void
     */
    protected function allowToResetInstance($allow = TRUE)
    {
        $this->allowToResetInstance = (bool)$allow;
    }
}
