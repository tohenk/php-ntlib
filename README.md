# PHP Library

## Common Library

### Beautifier

Provide text beautifier functionality with integrated Roman number checker.

```php
<?php

use NTLAB\Lib\Common\Beautifier;

echo Beautifier::beautify('SEKOLAH DASAR NEGERI II'); // Sekolah Dasar Negeri II
```

### Roman

Roman converts number to roman and vice versa.

```php
<?php

use NTLAB\Lib\Common\Roman;

echo Roman::asInteger('XXVI'); // 26
echo Roman::asRoman(51); // LI
```

### Terbilang

Number to text for Indonesian.

```php
<?php

use NTLAB\Lib\Common\Terbilang;

echo Terbilang::getInstance()->convert(1001); // SERIBU SATU
```

### Gelar

An Indonesian title stripper.

```php
<?php

use NTLAB\Lib\Common\Gelar;

echo Gelar::strip('Drs. IHSAN SAPUTRA, M.Si'); // IHSAN SAPUTRA
```
