<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Product; // Tu modelo de producto
use Illuminate\Support\Facades\Log;

class ImportProducts extends Command
{
    /**
     * El nombre y la firma del comando en la consola.
     * {file} es un argumento opcional. Si no se pone, busca 'productes.xlsx'.
     */
    protected $signature = 'import:products {file=productes.xlsx}';

    /**
     * Descripción del comando.
     */
    protected $description = 'Importa productos desde un archivo Excel ubicado en storage/app/';

    /**
     * Ejecuta el comando.
     */
    public function handle()
    {
        $fileName = $this->argument('file');
        $path = storage_path('app/' . $fileName);

        // 1. Validar que el archivo existe
        if (!file_exists($path)) {
            $this->error("❌ El archivo no existe: $path");
            $this->info("💡 Pista: Sube tu archivo Excel a la carpeta 'laravel/storage/app/'");
            return 1; // Código de error
        }

        $this->info("📂 Leyendo archivo: $fileName...");

        try {
            // 2. Cargar el Excel
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(); // Convertir a array PHP nativo

            $totalRows = count($rows) - 1; // Restamos la cabecera
            $this->info("📊 Se han encontrado $totalRows productos para procesar.");
            
            // Iniciamos barra de progreso
            $this->output->progressStart($totalRows);

            $imported = 0;
            $errors = 0;
            $headerSkipped = false;

            // 3. Recorrer filas
            foreach ($rows as $index => $row) {
                // Saltar la primera fila (cabeceras)
                if (!$headerSkipped) {
                    $headerSkipped = true;
                    continue;
                }

                // Mapear columnas (Ajusta estos índices según tu Excel real)
                $sku = $row[0] ?? null;
                $name = $row[1] ?? null;
                $desc = $row[2] ?? '';
                $image = $row[3] ?? '';
                $price = $row[4] ?? 0;
                $stock = $row[5] ?? 0;
                

                // 4. Validaciones (El enunciado pide validar campos obligatorios y numéricos)
                if (empty($sku) || empty($name)) {
                    $this->newLine();
                    $this->error("⚠️ Fila $index saltada: SKU o Nombre vacíos.");
                    Log::warning("Importación fallida en fila $index: Datos incompletos.");
                    $errors++;
                    continue;
                }

                if (!is_numeric($price) || !is_numeric($stock)) {
                    $this->newLine();
                    $this->error("⚠️ Fila $index saltada (SKU: $sku): Precio o Stock no son números.");
                    Log::warning("Importación fallida SKU $sku: Formato numérico incorrecto.");
                    $errors++;
                    continue;
                }

                // 5. Guardar en Base de Datos (UpdateOrCreate evita duplicados)
                Product::updateOrCreate(
                    ['sku' => $sku], // Busca por este campo
                    [
                        'name' => $name,
                        'description' => $desc,
                        'price' => (float)$price,
                        'stock' => (int)$stock,
                        'image' => $image,
                    ]
                );

                $imported++;
                $this->output->progressAdvance();
            }

            $this->output->progressFinish();
            
            // 6. Resumen final
            $this->table(
                ['Resultado', 'Cantidad'],
                [
                    ['✅ Importados/Actualizados', $imported],
                    ['❌ Errores/Saltados', $errors],
                ]
            );

            Log::info("Importación completada: $imported procesados, $errors errores.");

        } catch (\Exception $e) {
            $this->error("🔥 Error crítico: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}