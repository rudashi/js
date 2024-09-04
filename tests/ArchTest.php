<?php

declare(strict_types=1);

arch()->preset()->php();

arch('strict types')
    ->expect('Rudashi\JavaScript')
    ->toUseStrictTypes();

arch('closed for extension')
    ->expect('Rudashi\JavaScript')
    ->classes()
    ->not->toBeAbstract()
    ->toBeReadonly()
    ->toExtendNothing()
    ->toBeFinal();

arch('annotations')
    ->expect('Rudashi\JavaScript')
    ->toHavePropertiesDocumented()
    ->toHaveMethodsDocumented();
