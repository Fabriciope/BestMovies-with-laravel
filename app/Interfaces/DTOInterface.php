<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface DTOInterface
{
    public function __get(string $name): mixed;
    public function __set(string $name, mixed $value): void;
    public static function makeFromRequest(Request $request, ?int $userId = null): self;
    public static function makeFromArray(array $data): self;
    public function toArray(): array;
}