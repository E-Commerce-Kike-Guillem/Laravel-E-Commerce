<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use App\Models\User;
use App\Imports\ProductsImport;

class ImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_excel_file()
    {
        Excel::fake(); // Falsegem l'Excel per no necessitar un fitxer real físic

        $admin = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->create('productes.xlsx'); // Creem un fitxer fals a la memòria

        // Fem POST al teu controlador d'importació
        // Nota: Assegura't que la ruta és '/import' o '/admin/import' segons el teu web.php
        // Segons el que vam fer al C4 era una ruta protegida fora del grup admin, o dins?
        // Assumiré que vas fer servir el ProductImportController a /import
        $response = $this->actingAs($admin)->post('/import', [
            'file' => $file
        ]);

        // Verifiquem que s'ha cridat a la classe d'importació
        Excel::assertImported('productes.xlsx'); 
        
        $response->assertRedirect(); // Normalment redirigeix "back"
        $response->assertSessionHas('success'); // El missatge de "S'han importat..."
    }
}