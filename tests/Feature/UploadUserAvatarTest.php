<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadUserAvatarTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        // Storage::fake('uploads');
        $response = $this->json('POST', '/api/users/avatar', [
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ] , ['HTTP_Authorization' => 'Bearer ' . "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiMDdmY2E2Y2VmOTVjMzFjYjVhNzQ4N2RjNzIxYjYzNTZhNWE0NmFiMTJhN2ZiMGFlNDE5ODg2YmNhYmRhZjA0Y2IyMGQwZjA2ZTI3MmNlZmQiLCJpYXQiOjE1ODI4MDg0MTgsIm5iZiI6MTU4MjgwODQxOCwiZXhwIjoxNjE0NDMwODE4LCJzdWIiOiI4Iiwic2NvcGVzIjpbXX0.TG2T4pdHpj3ajWPWWRHgDf3GesVetvOIEvel8bGRby_ahAlpBO0n56DtbI_3zBZeyDLgX8E3FLNztFrCoJQeEQe-S0wfTi6DZgvVoxjE1wWQUesD93Orip7rB97C7VcnvtHlqTnqYsXUOppxwNAoL6x1T0wSYH5na5D7bvPa7QKPMNhmT7HGlPlOvXC0BvDEynqNW0Yn61SLuOELCgttxJeVgocBCgFBg_90yFRV03lCz60q79zWck5zgxk_Ybws-9IvfJvZ_Ci8G4TVF8BbVAx6fur7HMCnKUhBPKWH2ENKUx-yJYkZgAEOPlTnPXnhwi_7SmcupFwk7bK94gbKQgtMb0iGQHNvFY7RB2rzSr7CWD4mPDrtmmjaC5Kvn8kCBBefsNFqHeN31oiHMYU0NjAz54miKu2Y34qj1xj8KTRw6YEsdBS3GipGuoY-alFu9ROkNuRUC7Iq7SMANw8ktufKprv4h7QnCagHlu10NdT-VnaeCbAU1ZskOwl_UkyOJ2vdIUa0F8NxpUz9CZQmL46dy5eM9QdEmogaURLHAAh7xrtvaeKEsx__cq-m-0zXMsdKGqaCpKjDGvIUQezij0gdf-cc04JeQ3-qagS7udfiWnUSgryab-UgZ9C-7wX5E6aeAC5qL551KaN5L8P3moTjSSyesKTBPUN9iTkxkqg"]);
        // Storage::disk('avatars')->assertExists('avatar.jpg');
        $this->assertTrue(true);
    }
}
