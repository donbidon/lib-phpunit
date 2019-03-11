<?php
/**
 * PHPUnit functionality extension.
 *
 * Allows to mark group of tests as skipped.<br />
 * Contains debug functionality.
 *
 * @copyright <a href="http://donbidon.rf.gd/" target="_blank">donbidon</a>
 * @license   https://opensource.org/licenses/mit-license.php
 */

declare(strict_types=1);

namespace donbidon\Lib\PHPUnit;

error_reporting(E_ALL);

/**
 * PHPUnit functionality extension.
 *
 * Implements debug functionality (<a href="#method__e">self::_e()</a> and etc).
 * <br />
 * Allows to mark groups of tests as skipped.
 * ```php
 * class MyClass
 * {
 *      public function foo()
 *      {
 *      }
 *
 *      public function bar()
 *      {
 *      }
 * }
 *
 * class MyClassTest extends \donbidon\Lib\PHPUnit\TestCase
 * {
 *     public function testFoo()
 *     {
 *         $expected = 1;
 *         $actual   = 2;
 *         if ($expected !== $actual) {
 *             // Mark group of tests as skipped
 *             self::skipGroup('someGroup');
 *         }
 *         // Failed assertion
 *         self::assertEquals($expected, $actual);
 *     }
 *
 *     public function testBar()
 *     {
 *         // Skip test
 *         self::checkGroupIfSkipped('someGroup');
 *         // Following code won't run
 *         self::assertEquals(1, 1);
 *     }
 * }
 * ```
 * outputs
 * ```
 * FAILURES!
 * Tests: 2, Assertions: 1, Failures: 1, Skipped: 1.
 * ```
 * <!-- move: index.html -->
 * <ul>
 *     <li><a href="classes/donbidon.Lib.PHPUnit.TestCase.html">
 * \donbidon\Lib\PHPUnit\TestCase</a> implements debug functionality, allows to
 * mark groups of tests as skipped.</ li>
 *     <li><a href="classes/donbidon.Lib.PHPUnit.T_ResetInstance.html">
 * \donbidon\Lib\PHPUnit\T_ResetInstance</a> implements functionality allowing
 * to reset singleton instance.</ li>
 * </ul>
 * <!-- /move -->
 *
 * @todo Cover by unit tests.
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Groups of tests to skip
     *
     * @var array
     */
    private static $groupsToSkip = [];

    /**
     * Sets up group to skip.
     *
     * @param string $group
     * @param bool   $isolate  Flag specifying to isolate groups by current
     *                         class name
     *
     * @return void
     */
    protected static function skipGroup(string $group, bool $isolate = TRUE): void
    {
        static::modifyGroup($group, $isolate);
        static::$groupsToSkip[$group] = TRUE;
    }

    /**
     * Marks test skipped if group of tests has to be skipped.
     *
     * @param string $group
     * @param bool   $isolate  Flag specifying to isolate groups by current
     *                         class name
     *
     * @return void
     */
    protected static function checkGroupIfSkipped(
        string $group, bool $isolate = TRUE
    ): void
    {
        static::modifyGroup($group, $isolate);
        if (isset(static::$groupsToSkip[(string)$group])) {
            static::markTestSkipped(sprintf(
                "[SKIPPED] Some previous tests from '%s' group are skipped or incomplete",
                $group
            ));
        }
    }

    /**
     * Skips test by OS.
     *
     * @param string $regExp   Regexp for PHP_OS constant value
     * @param string $message  Message
     * @param string $group
     * @param bool   $isolate
     *
     * @return void
     *
     * @link http://php.net/manual/en/reserved.constants.php  PHP_OS constant
     * @see  self::skipGroup() $group and $isolate args
     */
    protected static function skipByOS(
        string $regExp, string $message = "", string $group = "", bool $isolate = TRUE
    ): void
    {
        if (preg_match($regExp, PHP_OS)) {
            static::markTestSkipped(sprintf(
                "[SKIPPED][OS][%s]%s",
                PHP_OS,
                "" === $message ? "" : sprintf(" %s", $message)
            ));
            if ("" !== $group) {
                static::skipGroup($group, $isolate);
            }
        }
    }


    /**
     * Modifies group name according to arguments.
     *
     * @param &string $group
     * @param bool $isolate     Flag specifying to isolate groups by current
     *                          class name
     *
     * @return void
     *
     * @internal
     */
    protected static function modifyGroup(string &$group, bool $isolate): void
    {
        $group = (string)$group;
        if ($isolate) {
            $group = sprintf("%s@%s", __CLASS__, $group);
        }
    }

    /**
     * Outputs string.
     *
     * @param string $string
     *
     * @return void
     *
     * @link http://php.net/manual/en/function.echo.php  echo
     */
    protected static function _e(string $string): void
    {
        fwrite(STDERR, $string);
    }

    /**
     * Prints human-readable information about a variable.
     *
     * @param mixed $expression
     *
     * @return void
     *
     * @link http://php.net/manual/en/function.print-r.php  print_r()
     */
    protected static function _pr($expression): void
    {
        static::_e(print_r($expression, TRUE));
    }

    /**
     * Dumps information about a variable.
     *
     * @param mixed $expression
     *
     * @return void
     *
     * @link http://php.net/manual/en/function.var-dump.php  var_dump()
     */
    protected static function _vd($expression): void
    {
        ob_start();
        var_dump($expression);
        $string = ob_get_contents();
        ob_end_clean();
        static::_e($string);
    }

    /**
     * Outputs a parsable string representation of a variable.
     *
     * @param mixed $expression
     *
     * @return void
     *
     * @link http://php.net/manual/en/function.var-export.php  var_export()
     */
    protected static function _ve($expression): void
    {
        static::_e(var_export($expression, TRUE));
    }
}
