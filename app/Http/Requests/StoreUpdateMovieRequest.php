<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class StoreUpdateMovieRequest extends FormRequest
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
        $rules = [
            'title' => ['required', 'string', 'unique:movies,title'],
            'category_id' => ['required', 'integer'],
            'synopsis' => ['required', 'string'],
            'hours' => ['required', 'integer', 'between:0,10'],
            'minutes' => ['integer', 'between:0,60'],
            'trailer_link' => ['string', 'starts_with:https://youtu.be/'],
            'poster' => [
                'required',
                Rule::imageFile()->max(12 * 1024),
                $this->getPosterValidator()
            ]
        ];

        if ($this->method() == 'PUT') {
            unset($rules['poster'][0]);
            $rules['title'][2] = Rule::unique('movies', 'title')->ignore($this->movie->id, 'id');
        }

        return $rules;
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
