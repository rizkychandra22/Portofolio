<?php

namespace Tests\Unit;

use App\Livewire\PortofolioDetail;
use Tests\TestCase;

class PortofolioDetailComponentTest extends TestCase
{
    public function test_mount_sets_project_id_and_locale(): void
    {
        $component = new PortofolioDetail();

        $component->mount(42, 'id');

        $this->assertSame(42, $component->projectId);
        $this->assertSame('id', app()->getLocale());
    }
}
