<?php

namespace Zerotoprod\ServiceModel;

use Closure;


class Factory
{
    public string $model;
    protected array $states;

    public function __construct(?array $states = null)
    {
        $this->states = $states ?: [];
    }


    public function definition(): array
    {
        return [];
    }

    public function make(callable|array $attributes = []): object
    {
        if (!empty($attributes)) {
            return $this->state($attributes)->make();
        }

        return $this->newModel($this->getExpandedAttributes());
    }


    protected function getExpandedAttributes(): array
    {
        return $this->expandAttributes($this->getRawAttributes());
    }


    protected function getRawAttributes(): array
    {
        return array_reduce($this->states, function (array $carry, array|callable $state) {
            if ($state instanceof Closure) {
                $state = $state->bindTo($this);
            }

            return array_merge($carry, (array)$state($carry));
        }, $this->definition());
    }

    protected function expandAttributes(array $definition): array
    {
        foreach ($definition as $key => &$attribute) {
            if (is_callable($attribute) && !is_string($attribute) && !is_array($attribute)) {
                $attribute = $attribute($definition);
            }

            $definition[$key] = $attribute;
        }

        return $definition;
    }

    public function newModel(array $attributes = []): object
    {
        $model = $this->model;

        return $model::make($attributes);
    }

    public function state(callable|array $state): static
    {
        return $this->newInstance([
            'states' => array_merge($this->states, [is_callable($state) ? $state : fn() => $state])
        ]);
    }

    protected function newInstance(array $arguments = []): static
    {
        return new static(...array_values(array_merge([
            'states' => $this->states,
        ], $arguments)));
    }
}
