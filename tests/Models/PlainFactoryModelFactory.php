<?php

namespace Zerotoprod\AppServiceModel\Tests\Models;

use Zerotoprod\ServiceModel\Factory;

class PlainFactoryModelFactory extends Factory
{
    public string $model = FactoryModel::class;

    public function definition(): array
    {
        return [
            FactoryModel::name => 'definition',
            FactoryModel::Child => [
                FactoryModelChild::name => 'child'
            ]
        ];
    }

    public function setName(string $name): self
    {
        return $this->state(fn() => [
            FactoryModel::name => $name
        ]);
    }
}