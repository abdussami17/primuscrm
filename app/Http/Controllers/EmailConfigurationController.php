<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailConfiguration;
use Illuminate\Support\Facades\Storage;

class EmailConfigurationController extends Controller
{
    private function getConfig()
    {
        return EmailConfiguration::firstOrCreate([]);
    }

    public function save(Request $request)
    {
        $conf = $this->getConfig();


        $conf->include_logo_header = $request->input('include_logo_header', 0);
        $conf->include_logo_footer = $request->input('include_logo_footer', 0);
        $conf->confidentiality_notice = $request->input('confidentiality_notice', '');

        if ($request->hasFile('header_logo')) {
            $conf->header_logo_path = $request->file('header_logo')->store('logos', 'public');
        }
        if ($request->hasFile('footer_logo')) {
            $conf->footer_logo_path = $request->file('footer_logo')->store('logos', 'public');
        }
        // Save other fields if needed
        $conf->save();

        return redirect()->back()->with('success', 'Email configuration saved successfully!');
    }

    public function uploadLogo(Request $request)
    {
        $config = $this->getConfig();

        $request->validate([
            'type' => 'required|in:header,footer',
            'logo' => 'required|image|max:2048'
        ]);

        $path = $request->file('logo')->store('email_logos', 'public');

        if ($request->type === 'header') {
            $config->update(['header_logo_path' => $path]);
        } else {
            $config->update(['footer_logo_path' => $path]);
        }

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $path)
        ]);
    }

    public function saveSocial(Request $request)
    {
        $config = $this->getConfig();

        $request->validate([
            'platform' => 'required|in:facebook,instagram,twitter,youtube,reddit',
            'url' => 'nullable|url'
        ]);

        $field = $request->platform . '_url';

        $config->update([
            $field => $request->url
        ]);

        return response()->json(['success' => true]);
    }
}
