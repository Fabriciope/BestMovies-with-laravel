<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class StoreMovieRequest extends FormRequest
{
    private Closure $posterValidator;

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->setPosterValidator();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'unique:movies,title'],
            'category_id' => ['required', 'integer'], // TODO: digits_between de quantas categoriaas teem
            'synopsis' => ['required', 'string'],
            'hours' => ['required', 'integer', 'digits_between:0,10'],
            'minutes' => ['integer', 'digits_between:0,60'],
            'trailer_link' => ['string', 'starts_with:https://youtu.be/'],
            'poster' => [
                'required',
                Rule::imageFile()->max(12 * 1024),
                $this->getPosterValidator()
            ],
        ];
    }

    public function getPosterValidator(): Closure
    {
        return $this->posterValidator;
    }

    public function setPosterValidator(): self
    {
        $this->posterValidator = function (string $attribute, UploadedFile $image, Closure $fail) {
            [$width, $height] = $image->dimensions();

            $maxWidth = ((85 * $height) / 100); // 85 percent of $height
            $minHeight = ((132 * $width) / 100); // 132 percent of $width

            if (($width >= $maxWidth) || ($height <= $minHeight)) {
                $fail("The {$attribute} size is invalid!");
            }
        };

        return $this;
    }
}
