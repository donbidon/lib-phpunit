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
 * T_ResetInstance trait unit tests.
 */
class T_ResetInstance_Test extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests functionality.
     *
     * @return void
     *
     * @cover donbidon\Lib\PHPUnit\T_ResetInstance::resetInstance()
     * @cover donbidon\Lib\PHPUnit\T_ResetInstance::setInstancePropertyName()
     * @cover donbidon\Lib\PHPUnit\T_ResetInstance::allowToResetInstance()
     */
    public function testFunctionality(): void
    {
        FirstSingleton::getInstance();
        FirstSingleton::resetInstance();
        $first = FirstSingleton::getInstance();
        $second = SecondSingleton::getInstance();
        $this->assertEquals(
            "donbidon\\Lib\\PHPUnit\\FirstSingleton",
            get_class($first),
            "Invalid singleton instance"
        );
        $this->assertEquals(
            "donbidon\\Lib\\PHPUnit\\SecondSingleton",
            get_class($second),
            "Invalid singleton instance"
        );
        $this->assertEquals(
            2,
            FirstSingleton::getCount(),
            "Invalid number of times when constructor was called"
        );
        $this->assertEquals(
            1,
            SecondSingleton::getCount(),
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
