<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Factory;

class PlainFactoryModelFactory extends Factory
{
    public string $model = PlainFactoryModel::class;

    public function definition(): array
    {
        return [
            'name' => 'definition',
        ];
    }

    public function setName(string $name): self
    {
        return $this->state(fn() => [
            'name' => $name
        ]);
    }
}