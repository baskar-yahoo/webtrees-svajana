<?php

/**
 * Webtrees Svajana Theme Module
 * Integration for WordPress Kadence Child Theme
 */

declare(strict_types=1);

namespace Webtrees\Modules\WebtreesSvajana;

// Since we are not using Composer to autoload this specific module,
// we explicitly require the main class file.
require __DIR__ . '/WebtreesSvajana.php';

return new WebtreesSvajana();
