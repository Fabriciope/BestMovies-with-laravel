<?php

namespace Tests\Unit;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class PhotoValidationTest extends TestCase
{
    // public function test_validate_correct_image_size()
    // {        
    //     $request = new UpdateProfileRequest();
    //     $request->prepareForValidation();
    //     $photoValidator = $request->getPhotoValidator();

    //     $width = 100;
    //     $height = 120;
    //     $image = UploadedFile::fake()->image('test-image.png', $width, $height);
    //     $photoValidator(
    //         'photo',
    //         $image,
    //         function(string $message) {
    //             $this->assertFalse(isset($message));
    //         }
    //     );
    // }
    
    public function test_validate_incorrect_image_size()
    {
        $request = new UpdateProfileRequest();
        $request->prepareForValidation();
        $photoValidator = $request->getPhotoValidator();
        
        $width = 100;
        $height = 150;
        $image = UploadedFile::fake()->image('test-image.png', $width, $height);
        $photoValidator(
            'photo',
            $image,
            function(string $message) {
                $this->assertEquals('The photo size is invalid!', $message);
            }
        );
    }

    public function test_validate_incorrect_banner_size()
    {
        $request = new StoreMovieRequest();
        $request->prepareForValidation();
        $bannerValidator = $request->getBannerValidator();

        $width = 100;
        $height = 80;
        $image = UploadedFile::fake()->image('test-banner.png', $width, $height);
        $bannerValidator(
            'banner',
            $image,
            function(string $message) {
                $this->assertEquals('The banner size is invalid!', $message);
            }
        );
    }
}