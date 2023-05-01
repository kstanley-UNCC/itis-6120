<?php
declare(strict_types=1);

namespace Itis6120\Project2;

interface EntityInterface
{
    public static function getFields(): array;
    public function toArray(): array;
}
