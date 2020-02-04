# phpower

[![Latest Stable Version](https://poser.pugx.org/ngyuki/phpower/v/stable)](https://packagist.org/packages/ngyuki/phpower)
[![Latest Unstable Version](https://poser.pugx.org/ngyuki/phpower/v/unstable)](https://packagist.org/packages/ngyuki/phpower)
[![License](https://poser.pugx.org/ngyuki/phpower/license)](https://packagist.org/packages/ngyuki/phpower)

`phpower` is php assertion library like [Power Assert](https://github.com/power-assert-js/power-assert).

## Install

```sh
composer require --dev phpunit/phpunit ngyuki/phpower:dev-master
```

## Example

Write test code with `assert`.

```php
<?php
namespace Test;

use PHPUnit\Framework\TestCase;

class SomeTest extends TestCase
{
    public function test_01()
    {
        $a = 1;
        $b = 2;
        $c = 3;
        assert(($a + ($b + 3)) === ($c * 3));
    }

    public function test_02()
    {
        $s = "x\ny\nz";
        assert("a\nb\nc" === strrev($s));
    }

    public function test_03()
    {
        $a = [1,2,3];
        $b = [7,8,9];
        assert($a == array_reverse($b));
    }

    public function test_ok()
    {
        $a = [1,2,3];
        $b = [3,2,1];
        assert($a == array_reverse($b));
    }
    public function test_04()
    {
        $a = [
            'name' => 'alice',
            'uid' => 1000,
            'gid' => 1000,
        ];
        assert($a == [
            'name' => 'bob',
            'uid' => 2000,
            'gid' => 2000,
        ]);
    }
}
```

Run the test.

```sh
vendor/bin/phpunit tests/example/
```

The following result is displayed.

```
PHPUnit 8.5.2 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.4.2
Configuration: /path/to/phpower/phpunit.xml.dist

FFF.F                                                               5 / 5 (100%)

Time: 261 ms, Memory: 4.00 MB

There were 4 failures:

1) Test\SomeTest::test_01
Assertion failed ($a + ($b + 3)) === ($c * 3) -> false
# $a -> 1
# $b -> 2
# $b + 3 -> 5
# $a + ($b + 3) -> 6
# $c -> 3
# $c * 3 -> 9

/path/to/phpower/tests/example/SomeTest.php:13

2) Test\SomeTest::test_02
Assertion failed "a\nb\nc" === strrev($s) -> false
# $s -> "x\ny\nz"
# strrev($s) -> "z\ny\nx"

/path/to/phpower/tests/example/SomeTest.php:19

3) Test\SomeTest::test_03
Assertion failed $a == array_reverse($b) -> false
# $a
#  -> [
#       1,
#       2,
#       3,
#     ]
#
# $b
#  -> [
#       7,
#       8,
#       9,
#     ]
#
# array_reverse($b)
#  -> [
#       9,
#       8,
#       7,
#     ]
#

/path/to/phpower/tests/example/SomeTest.php:26

4) Test\SomeTest::test_04
Assertion failed $a == ['name'=>'bob','uid'=>2000,'gid'=>2000,] -> false
# $a
#  -> [
#       "name" => "alice",
#       "uid" => 1000,
#       "gid" => 1000,
#     ]
#

/path/to/phpower/tests/example/SomeTest.php:46

FAILURES!
Tests: 5, Assertions: 5, Failures: 4.
```

## Restriction

Only for phpunit installed locally in project with composer (phpunit.phar is not supported).

## LICENCE

- [MIT License](http://www.opensource.org/licenses/mit-license.php)
