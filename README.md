# Bitstream Iterator

---

## Installation
```sh
composer require dshepherd/bitstream-iterator
```

## Usage
```php

$bytes = [0xDE, 0xCA, 0xFB, 0xAD, 0xD0];

$iterator = new BitStreamIterator($bytes);

$message = dechex(bindec(implode('', $iterator->take(20))));
$message .= ' ' . dechex(bindec(implode('', $iterator->take(12))));
$flag = $iterator->take(1);
$options = $iterator->take(3);

printf('Message: %s' . PHP_EOL, $message);
printf('Flag is %s' . PHP_EOL, $flag ? 'set' : 'not set');

for ($x = 0; $x < 4; $x++) {
    printf('Bit %d is %s' . PHP_EOL, $x, ($options & pow($x, 2)) != 0 ? 'set' : 'not set');
}


```
