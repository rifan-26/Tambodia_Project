<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LandingPageLayoutTest extends TestCase
{
    /**
     * Test that landing page loads successfully
     */
    public function test_landing_page_loads_successfully()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs('landingpage');
    }

    /**
     * Test that the 2x2 grid structure is present
     */
    public function test_grid_structure_is_present()
    {
        $response = $this->get('/');
        
        // Check for gallery container
        $response->assertSee('class="gallery"', false);
        
        // Check for 4 gallery items (default structure)
        $response->assertSeeInOrder([
            'gallery-item',
            'gallery-item', 
            'gallery-item',
            'gallery-item'
        ], false);
    }

    /**
     * Test that CSS grid styles are included
     */
    public function test_css_grid_styles_are_included()
    {
        $response = $this->get('/');
        
        // Check for grid CSS properties
        $response->assertSee('grid-template-columns: 1fr 1fr', false);
        $response->assertSee('grid-template-rows: 1fr 1fr', false);
        $response->assertSee('aspect-ratio: 9 / 16', false);
        $response->assertSee('aspect-ratio: 1 / 1', false);
    }

    /**
     * Test responsive breakpoints are defined
     */
    public function test_responsive_breakpoints_are_defined()
    {
        $response = $this->get('/');
        
        // Check for mobile breakpoint
        $response->assertSee('@media (max-width: 480px)', false);
        $response->assertSee('@media (max-width: 768px)', false);
    }

    /**
     * Test aspect ratio fallbacks are present
     */
    public function test_aspect_ratio_fallbacks_are_present()
    {
        $response = $this->get('/');
        
        // Check for aspect-ratio fallback
        $response->assertSee('@supports not (aspect-ratio: 1)', false);
        $response->assertSee('padding-bottom: 177.78%', false);
        $response->assertSee('padding-bottom: 100%', false);
    }

    /**
     * Test that default images are properly structured
     */
    public function test_default_images_structure()
    {
        $response = $this->get('/');
        
        // Should have 4 default images when no media configured
        $response->assertSee('img/1.jpg', false);
        $response->assertSee('img/2.jpg', false);
        $response->assertSee('img/3.jpg', false);
        $response->assertSee('img/4.jpg', false);
    }

    /**
     * Test grid positioning classes
     */
    public function test_grid_positioning_classes()
    {
        $response = $this->get('/');
        
        // Check for nth-child positioning rules
        $response->assertSee('.gallery-item:nth-child(1)', false);
        $response->assertSee('.gallery-item:nth-child(2)', false);
        $response->assertSee('.gallery-item:nth-child(3)', false);
        $response->assertSee('.gallery-item:nth-child(4)', false);
        
        // Check grid positioning
        $response->assertSee('grid-column: 1 / 2', false);
        $response->assertSee('grid-column: 2 / 3', false);
        $response->assertSee('grid-row: 1 / 2', false);
        $response->assertSee('grid-row: 2 / 3', false);
    }
}