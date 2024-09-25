<?php

declare(strict_types=1);

namespace Tests;

arch()->preset()->php();

arch()->preset()->security();

arch('no debug')
    ->expect('Rudashi\JavaScript')
    ->not->toUse(['die', 'dd', 'dump']);

arch('strict types')
    ->expect('Rudashi\JavaScript')
    ->toUseStrictTypes();

arch('strict equality')
    ->expect('Rudashi\JavaScript')
    ->toUseStrictEquality();

arch('closed for extension')
    ->expect('Rudashi\JavaScript')
    ->classes()
    ->not->toBeAbstract()
    ->toExtendNothing()
    ->toBeFinal();

arch('annotations')
    ->expect('Rudashi\JavaScript')
    ->toHavePropertiesDocumented()
    ->toHaveMethodsDocumented();
