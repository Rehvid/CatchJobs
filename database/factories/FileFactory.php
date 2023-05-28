<?php

namespace Database\Factories;

use http\Message\Body;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $collections = [
            'logo',
            'cover',
            'gallery'
        ];

        $dimensions = [
            'logo' => ['width' => '100', 'height' => '100'],
            'cover' => ['width' => '1200', 'height' => '400'],
            'gallery' => ['width' => '540', 'height' => '360']
        ];

        $collection = $this->faker->randomElement($collections);

        if (!Storage::exists('public/' . $collection)) {
            Storage::makeDirectory('public/' . $collection);
        }

        $image =  $this->faker->image(
            storage_path('app/public/' . $collection),
            $dimensions[$collection]['width'],
            $dimensions[$collection]['height'],
            fullPath: false
        );

        $path = $collection . '/' . $image;
        $fullpath = storage_path('app/public/' . $collection . '/' . $image);

        return [
            'name' => $image,
            'disk' =>  config('app.uploads.disk'),
            'path' => $path,
            'mime_type' => getimagesize($fullpath)['mime'],
            'collection' => $collection,
        ];
    }
}
