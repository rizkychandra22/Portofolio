<?php

namespace Tests\Unit;

use App\Services\FolderAwareCloudinaryAdapter;
use Cloudinary\Cloudinary;
use Tests\TestCase;

class FolderAwareCloudinaryAdapterTest extends TestCase
{
    private function makeAdapter(?string $prefix = null): FolderAwareCloudinaryAdapter
    {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => 'demo-cloud',
                'api_key' => 'key',
                'api_secret' => 'secret',
            ],
        ]);

        return new FolderAwareCloudinaryAdapter($cloudinary, null, $prefix);
    }

    public function test_get_url_generates_image_url_without_api_call(): void
    {
        $adapter = $this->makeAdapter();
        $url = $adapter->getUrl('projects/sample-image.jpg');

        $this->assertSame(
            'https://res.cloudinary.com/demo-cloud/image/upload/f_auto,q_auto/projects/sample-image',
            $url
        );
    }

    public function test_get_url_generates_video_url(): void
    {
        $adapter = $this->makeAdapter();
        $url = $adapter->getUrl('videos/intro.mp4');

        $this->assertSame(
            'https://res.cloudinary.com/demo-cloud/video/upload/videos/intro',
            $url
        );
    }

    public function test_get_url_generates_raw_url_with_prefix_for_non_media_file(): void
    {
        $adapter = $this->makeAdapter('portfolio');
        $url = $adapter->getUrl('docs/specification.pdf');

        $this->assertSame(
            'https://res.cloudinary.com/demo-cloud/raw/upload/portfolio/docs/specification',
            $url
        );
    }

    public function test_get_transformed_url_applies_transformation_string(): void
    {
        $adapter = $this->makeAdapter();
        $url = $adapter->getTransformedUrl('projects/sample-image.jpg', 'w_600,h_400,c_fill');

        $this->assertSame(
            'https://res.cloudinary.com/demo-cloud/image/upload/w_600,h_400,c_fill/projects/sample-image',
            $url
        );
    }

    public function test_file_exists_is_true_only_for_non_empty_path(): void
    {
        $adapter = $this->makeAdapter();

        $this->assertTrue($adapter->fileExists('anything'));
        $this->assertFalse($adapter->fileExists(''));
    }
}
