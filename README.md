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

Convert number to Indonesian text.

```php
<?php

use NTLAB\Lib\Common\Terbilang;

echo Terbilang::from(1001); // SERIBU SATU
```

### Gelar

A title stripper.

```php
<?php

use NTLAB\Lib\Common\Gelar;

echo Gelar::strip('Drs. IHSAN SAPUTRA, M.Si'); // IHSAN SAPUTRA
```

## Identity Library

### NIK

NIK encoder/decoder.

```php
<?php

use NTLAB\Lib\Identity\Ids\Nik;

$nik = new Nik('3515155202000005');
echo $nik->getWilayah(); // 351515
echo $nik->getTglLahir()->format('d-m-Y'); // 12-02-2000
echo $nik->getGender(); // P
echo $nik->getUrut(); // 5
```

### NIP

NIP encoder/decoder.

```php
<?php

use NTLAB\Lib\Identity\Ids\Nip;

$nip = new Nip('199909272020011004');
echo $nip->getTglLahir()->format('d-m-Y'); // 27-09-1999
echo $nip->getTmtCapeg()->format('d-m-Y'); // 01-01-2020
echo $nip->getType(); // 1
echo $nip->getGender(); // 1
echo $nip->getUrut(); // 4
```

### NRP

NRP encoder/decoder.

```php
<?php

use NTLAB\Lib\Identity\Ids\Nrp;

$nrp = new Nrp('96090050');
echo $nrp->getLahir()->format('d-m-Y'); // 01-09-1996
echo $nrp->getUrut(); // 50
```
