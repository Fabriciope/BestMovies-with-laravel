<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Dimensions;
use Illuminate\Validation\Rules\File;
use Closure;
use Illuminate\Http\UploadedFile;

class UpdateProfileRequest extends FormRequest
{
    private CLosure $photoValidator;

    public function __construct()
    {
        $this->setPhotoValidator();
    }

    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'photo' => [
                Rule::imageFile()->max(12 * 1024),
                $this->getPhotoValidator()
            ],
            'name' => ['required', 'min:3', 'max:255'],
            'description' => 'max:1000'
        ];
    }

    public function getPhotoValidator(): Closure
    {
        return $this->photoValidator;
    }

    private function setPhotoValidator(): void
    {
        $this->photoValidator = function (string $attribute, UploadedFile $image, Closure $fail) {
            [$width, $height] = $image->dimensions();

            $maxWidth = ((132 * $height) / 100); // 132percent of $height
            $maxHeight = ((132 * $width) / 100); // 132 percent of $width

            if (($width >= $maxWidth) || ($height >= $maxHeight)) {
                $fail("The {$attribute} is invalid!");
            }
        };
    }
}
