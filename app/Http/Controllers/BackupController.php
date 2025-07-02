<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    // Muestra la lista de copias de seguridad
    public function index()
    {
        // Obtener todos los archivos de copias de seguridad
        $files = Storage::disk('local')->files('backups');
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'filename' => basename($file),
                'size' => $this->formatSize(Storage::disk('local')->size($file)),
                'url' => route('admin.backup.download', basename($file))
            ];
        }

        return view('admin.backup.index', compact('backups'));
    }

    // Crear una nueva copia de seguridad
    public function create()
    {
        // Nombre del archivo de la copia de seguridad con fecha y hora
        $filename = 'backup-' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';

        // Ruta para guardar la copia de seguridad
        $path = storage_path('app/backups/' . $filename);

        // Comando para generar la copia de seguridad
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST'),
            env('DB_DATABASE'),
            $path
        );

        // Ejecutar el comando
        $result = null;
        $output = [];
        exec($command, $output, $result);

        if ($result === 0) {
            return redirect()->route('admin.backup.index')->with('success', 'Copia de seguridad creada exitosamente.');
        } else {
            return redirect()->route('admin.backup.index')->with('error', 'Hubo un problema al crear la copia de seguridad.');
        }
    }

    // Descargar una copia de seguridad
    public function download($filename)
    {
        $path = 'backups/' . $filename;

        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->download($path);
        }

        return redirect()->route('admin.backup.index')->with('error', 'El archivo no existe.');
    }

    // Eliminar una copia de seguridad
    public function delete($filename)
    {
        $path = 'backups/' . $filename;

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
            return redirect()->route('admin.backup.index')->with('success', 'Copia de seguridad eliminada.');
        }

        return redirect()->route('admin.backup.index')->with('error', 'El archivo no existe.');
    }

    // Formato legible del tamaño del archivo
    private function formatSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $size >= 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    // Restaurar una copia de seguridad
    public function restore($filename)
    {
        $path = storage_path('app/backups/' . $filename);

        if (file_exists($path)) {
            // Comando para restaurar la base de datos
            $command = sprintf(
                'mysql --user=%s --password=%s --host=%s %s < %s',
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_HOST'),
                env('DB_DATABASE'),
                $path
            );

            // Ejecutar el comando
            $result = null;
            $output = [];
            exec($command, $output, $result);

            if ($result === 0) {
                return redirect()->route('admin.backup.index')->with('success', 'Base de datos restaurada exitosamente.');
            } else {
                return redirect()->route('admin.backup.index')->with('error', 'Hubo un problema al restaurar la base de datos.');
            }
        }

        return redirect()->route('admin.backup.index')->with('error', 'El archivo no existe.');
    }
}
