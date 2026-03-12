<?php

namespace Tests\Unit;

use App\Models\Portofolio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\CreatesDomainData;
use Tests\TestCase;

class ModelCascadeTest extends TestCase
{
    use CreatesDomainData;
    use RefreshDatabase;

    public function test_soft_delete_category_cascades_to_related_portofolio_data(): void
    {
        Storage::shouldReceive('disk')->with('cloudinary')->andReturnSelf();
        Storage::shouldReceive('delete')->andReturnTrue();

        $category = $this->createCategory();
        $portofolio = $this->createPortofolio($category);
        $image = $this->createPortofolioImage($portofolio);
        $description = $this->createPortofolioDescription($portofolio);

        $category->delete();

        $this->assertSoftDeleted('category_projects', ['id' => $category->id]);
        $this->assertSoftDeleted('portofolios', ['id' => $portofolio->id]);
        $this->assertSoftDeleted('portofolio_images', ['id' => $image->id]);
        $this->assertSoftDeleted('portofolio_descriptions', ['id' => $description->id]);
    }

    public function test_restore_category_restores_related_portofolio_data(): void
    {
        Storage::shouldReceive('disk')->with('cloudinary')->andReturnSelf();
        Storage::shouldReceive('delete')->andReturnTrue();

        $category = $this->createCategory();
        $portofolio = $this->createPortofolio($category);
        $image = $this->createPortofolioImage($portofolio);
        $description = $this->createPortofolioDescription($portofolio);

        $category->delete();
        $category->restore();

        $this->assertDatabaseHas('category_projects', ['id' => $category->id, 'deleted_at' => null]);
        $this->assertDatabaseHas('portofolios', ['id' => $portofolio->id, 'deleted_at' => null]);
        $this->assertDatabaseHas('portofolio_images', ['id' => $image->id, 'deleted_at' => null]);
        $this->assertDatabaseHas('portofolio_descriptions', ['id' => $description->id, 'deleted_at' => null]);
    }

    public function test_force_delete_portofolio_removes_related_records_permanently(): void
    {
        Storage::shouldReceive('disk')->with('cloudinary')->andReturnSelf();
        Storage::shouldReceive('delete')->andReturnTrue();

        $category = $this->createCategory();
        $portofolio = $this->createPortofolio($category);
        $image = $this->createPortofolioImage($portofolio);
        $description = $this->createPortofolioDescription($portofolio);

        $portofolio->forceDelete();

        $this->assertDatabaseMissing('portofolios', ['id' => $portofolio->id]);
        $this->assertDatabaseMissing('portofolio_images', ['id' => $image->id]);
        $this->assertDatabaseMissing('portofolio_descriptions', ['id' => $description->id]);
    }

    public function test_updating_portofolio_image_project_replaces_old_file_reference(): void
    {
        Storage::shouldReceive('disk')->with('cloudinary')->andReturnSelf();
        Storage::shouldReceive('delete')->once()->with('projects/old-image')->andReturnTrue();

        $category = $this->createCategory();
        $portofolio = $this->createPortofolio($category, ['image_project' => 'projects/old-image']);

        $portofolio->update(['image_project' => 'projects/new-image']);

        $this->assertDatabaseHas('portofolios', [
            'id' => $portofolio->id,
            'image_project' => 'projects/new-image',
        ]);
    }
}
