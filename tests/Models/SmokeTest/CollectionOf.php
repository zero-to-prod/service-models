<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Zerotoprod\AppServiceModel\Tests\Models\SmokeTest;

use Attribute;
use Zerotoprod\ServiceModel\Contracts\CanParse;

#[Attribute]
class CollectionOf implements CanParse
{
    public function __construct(public readonly string $class)
    {
    }

    public function parse(array $values): Collection
    {
        return new Collection(array_map(fn(array $item) => $this->class::make($item), $values));
    }
}