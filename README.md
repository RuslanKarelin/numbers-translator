# numbers-translator
Translating numbers into English

**Composer**

```
$ composer require karelin/numbers-translator
```

**For example,**

```
<?php

require_once 'vendor/autoload.php';

use NumbersTranslator\Translator;

echo Translator::make(1560);

// result:
// one thousand five hundred and sixty
```

**Or**

```
<?php

require_once 'vendor/autoload.php';

use NumbersTranslator\Translator;

echo Translator::make(1560, 'usa');

// result:
// one thousand five hundred sixty
```
