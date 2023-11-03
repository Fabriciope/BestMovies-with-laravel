<?php

namespace App\Traits;

trait DTO
{
    public function __get(string $name): mixed
    {
        return $this->{$name} ?? null;
    }

    public function __set($name, $value): void
    {
        $this->{$name} = $value;
    }

    public function toArray(): array
    {
        $data = array();
        foreach (get_class_vars(self::class) as $attribute => $value) {
            if (!is_null($this->{$attribute})) {
                $data[$attribute] = $this->{$attribute};
            }
        }

        return $data;
    }
}
