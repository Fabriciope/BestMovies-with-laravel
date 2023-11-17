<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class StoreMovieRequest extends FormRequest
{
    private Closure $bannerValidator;

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->setBannerValidator();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'unique:movies,title'],
            'synopsis' => ['required', 'string'],
            'hours' => ['required', 'integer', 'digits_between:0,10'],
            'minutes' => ['integer', 'digits_between:0,60'],
            'trailer' => ['string', 'starts_with:https://youtu.be/'],
            'banner' => [
                Rule::imageFile()->max(12 * 1024),
                $this->getBannerValidator()
            ],
        ];
    }

    public function getBannerValidator(): Closure
    {
        return $this->bannerValidator;
    }

    public function setBannerValidator(): self
    {
        $this->bannerValidator = function (string $attribute, UploadedFile $image, Closure $fail) {
            [$width, $height] = $image->dimensions();

            $maxWidth = ((85 * $height) / 100); // 132 percent of $height
            $minHeight = ((132 * $width) / 100); // 132 percent of $width

            if (($width >= $maxWidth) || ($height <= $minHeight)) {
                $fail("The {$attribute} size is invalid!");
            }
        };

        return $this;
    }
}
