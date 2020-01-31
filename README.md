# phpower

`phpower` is php assertion library like [Power Assert](https://github.com/power-assert-js/power-assert).

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
        $a = 'abc';
        $b = 'xyz';
        assert($a == strrev($b));
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
}
```

Run the test.

```sh
vendor/bin/phpunit --dont-report-useless-tests tests/example/
```

The following result is displayed.

```
PHPUnit 8.5.2 by Sebastian Bergmann and contributors.

FFF.                                                                4 / 4 (100%)

Time: 293 ms, Memory: 4.00 MB

There were 3 failures:

1) Test\SomeTest::test_01
Assertion failed.
# ($a + ($b + 3)) === ($c * 3)
#   -> false
# $c * 3
#   -> 9
# $c
#   -> 3
# $a + ($b + 3)
#   -> 6
# $b + 3
#   -> 5
# $b
#   -> 2
# $a
#   -> 1
 in /path/to/phpower/tests/example/SomeTest.php:13

2) Test\SomeTest::test_02
Assertion failed.
# $a == strrev($b)
#   -> false
# strrev($b)
#   -> "zyx"
# $b
#   -> "xyz"
# $a
#   -> "abc"
 in /path/to/phpower/tests/example/SomeTest.php:20

3) Test\SomeTest::test_03
Assertion failed.
# $a == array_reverse($b)
#   -> false
# array_reverse($b)
#   -> [
#        9,
#        8,
#        7,
#      ]
# $b
#   -> [
#        7,
#        8,
#        9,
#      ]
# $a
#   -> [
#        1,
#        2,
#        3,
#      ]
 in /path/to/phpower/tests/example/SomeTest.php:27

FAILURES!
Tests: 4, Assertions: 3, Failures: 3.
```

## LICENCE

- [MIT License](http://www.opensource.org/licenses/mit-license.php)
