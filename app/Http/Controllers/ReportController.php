<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show list of available reports
     */
    public function index()
    {
        // auto-discover report files under resources/views/reports
        $dir = resource_path('views/reports');
        $reports = [];
        if (is_dir($dir)) {
            foreach (scandir($dir) as $file) {
                if (in_array($file, ['.', '..', 'index.blade.php'])) continue;
                // strip extensions (.blade.php or .html)
                $base = preg_replace('/\.blade\.php$|\.php$|\.html$/', '', $file);
                if (empty($base)) continue;
                $reports[$base] = $base; // key -> base filename
            }
        }

        return view('reports.index', compact('reports'));
    }

    /**
     * Show a specific report by key
     */
    public function show(Request $request, $key)
    {
        // expected key is the base filename under resources/views/reports
        $dir = resource_path('views/reports');
        $bladeView = 'reports.' . $key;

        if (view()->exists($bladeView)) {
            return view($bladeView);
        }

        // fallback to raw HTML file if exists
        $htmlPath = $dir . DIRECTORY_SEPARATOR . $key . '.html';
        if (file_exists($htmlPath)) {
            return response(file_get_contents($htmlPath), 200)->header('Content-Type', 'text/html');
        }

        abort(404);
    }
}
