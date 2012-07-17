<?php

/*
 * This file is a part of dflydev/placeholder-resolver.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\PlaceholderResolver;

interface PlaceholderResolverInterface
{
    /**
     * Resolve a placeholder
     *
     * @param string $placeholder
     *
     * @return string|null
     */
    public function resolvePlaceholder($placeholder);
}
