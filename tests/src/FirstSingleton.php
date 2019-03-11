<?php
/**
 * T_ResetInstance trait unit tests.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\Lib\PHPUnit;

/**
 * Class used to test T_ResetInstance trait.
 */
class FirstSingleton
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
    public static function getInstance(): FirstSingleton
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
    public static function getCount(): int
    {
        return self::$count;
    }

    /**
     * Returns instance property name.
     *
     * @return string
     */
    public function getInstancePropertyName(): string
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
