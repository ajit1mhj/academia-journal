<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    // All manageable pages with their keys and display names
    private function getPages(): array
    {
        return [
            'home'               => 'Homepage',
            'about'              => 'About Journal',
            'aim-scope'          => 'Aim & Scope',
            'publication-ethics' => 'Publication Ethics',
            'editorial-policies' => 'Editorial Policies',
            'contact'            => 'Contact Page',
        ];
    }

    public function index()
    {
        $pages = $this->getPages();

        // Load saved content for each page
        $pageData = [];
        foreach ($pages as $key => $label) {
            $path = "cms/{$key}.json";
            $pageData[$key] = [
                'label'        => $label,
                'key'          => $key,
                'last_updated' => Storage::exists($path)
                                    ? date('d M Y H:i', Storage::lastModified($path))
                                    : 'Never',
            ];
        }

        return view('admin.cms.index', compact('pageData'));
    }

    public function edit(string $page)
    {
        $pages = $this->getPages();

        if (!array_key_exists($page, $pages)) {
            abort(404, 'Page not found.');
        }

        $content = $this->loadPage($page);
        $label   = $pages[$page];

        return view('admin.cms.edit', compact('page', 'label', 'content'));
    }

    public function update(Request $request, string $page)
    {
        $pages = $this->getPages();

        if (!array_key_exists($page, $pages)) {
            abort(404, 'Page not found.');
        }

        // Validate based on which page is being edited
        $rules = $this->getValidationRules($page);
        $request->validate($rules);

        $data = $request->except(['_token', '_method']);

        // Handle image uploads per page
        $data = $this->handleImageUploads($request, $page, $data);

        // Save to JSON file in storage
        Storage::put("cms/{$page}.json", json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('admin.cms.index')
                         ->with('success', "{$pages[$page]} updated successfully.");
    }

    // Load page content from storage or return defaults
    public function loadPage(string $page): array
    {
        $path = "cms/{$page}.json";

        if (Storage::exists($path)) {
            return json_decode(Storage::get($path), true) ?? [];
        }

        return $this->getDefaults($page);
    }

    // Handle file uploads in CMS pages
    private function handleImageUploads(Request $request, string $page, array $data): array
    {
        $imageFields = ['banner_image', 'logo', 'cover_image', 'background_image'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if exists
                $existing = $this->loadPage($page);
                if (!empty($existing[$field])) {
                    Storage::disk('public')->delete($existing[$field]);
                }
                $data[$field] = $request->file($field)->store("cms/{$page}", 'public');
            }
        }

        return $data;
    }

    // Validation rules per page
    private function getValidationRules(string $page): array
    {
        $common = [
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];

        $rules = [
            'home' => array_merge($common, [
                'hero_title'    => 'required|string|max:255',
                'hero_subtitle' => 'nullable|string|max:500',
                'hero_button'   => 'nullable|string|max:100',
                'banner_image'  => 'nullable|image|max:3072',
                'section1_title' => 'nullable|string|max:255',
                'section1_body'  => 'nullable|string',
            ]),

            'about' => array_merge($common, [
                'title'          => 'required|string|max:255',
                'body'           => 'required|string',
                'founded_year'   => 'nullable|digits:4',
                'issn'           => 'nullable|string|max:20',
                'eissn'          => 'nullable|string|max:20',
                'cover_image'    => 'nullable|image|max:2048',
            ]),

            'aim-scope' => array_merge($common, [
                'title'      => 'required|string|max:255',
                'body'       => 'required|string',
                'topics'     => 'nullable|string',
            ]),

            'publication-ethics' => array_merge($common, [
                'title' => 'required|string|max:255',
                'body'  => 'required|string',
            ]),

            'editorial-policies' => array_merge($common, [
                'title' => 'required|string|max:255',
                'body'  => 'required|string',
            ]),

            'contact' => array_merge($common, [
                'address'      => 'nullable|string|max:500',
                'email'        => 'nullable|email|max:255',
                'phone'        => 'nullable|string|max:50',
                'map_embed'    => 'nullable|string',
                'office_hours' => 'nullable|string|max:255',
            ]),
        ];

        return $rules[$page] ?? $common;
    }

    // Default content for each page
    private function getDefaults(string $page): array
    {
        $defaults = [
            'home' => [
                'hero_title'    => 'Welcome to Academia Journal',
                'hero_subtitle' => 'A peer-reviewed academic journal for research excellence.',
                'hero_button'   => 'Submit Manuscript',
                'section1_title' => 'About the Journal',
                'section1_body'  => '',
                'meta_title'     => 'AJMS - Academia Journal Management System',
                'meta_description' => '',
            ],

            'about' => [
                'title'        => 'About the Journal',
                'body'         => '',
                'founded_year' => '',
                'issn'         => '',
                'eissn'        => '',
                'meta_title'   => 'About - AJMS',
            ],

            'aim-scope' => [
                'title'  => 'Aim & Scope',
                'body'   => '',
                'topics' => '',
            ],

            'publication-ethics' => [
                'title' => 'Publication Ethics',
                'body'  => '',
            ],

            'editorial-policies' => [
                'title' => 'Editorial Policies',
                'body'  => '',
            ],

            'contact' => [
                'address'      => '',
                'email'        => '',
                'phone'        => '',
                'map_embed'    => '',
                'office_hours' => 'Monday - Friday, 9:00 AM - 5:00 PM',
            ],
        ];

        return $defaults[$page] ?? [];
    }
}