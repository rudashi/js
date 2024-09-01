<?php

declare(strict_types=1);

arch()->preset()->php();

arch('strict types')
    ->expect('src')
    ->toUseStrictTypes();