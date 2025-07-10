<?php

namespace App\Http\Controllers;

use App\Models\SystemConfig;
use App\Helpers\ConfigHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SystemConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage-system-config');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configs = SystemConfig::orderBy('group')->orderBy('key')->get();
        $groups = $configs->groupBy('group');
        
        return view('system-config.index', compact('groups', 'configs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('system-config.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:system_configs,key',
            'value' => 'nullable|string',
            'type' => 'required|in:string,boolean,integer,json',
            'group' => 'required|string',
            'description' => 'nullable|string',
            'is_public' => 'boolean'
        ]);

        SystemConfig::create($request->all());
        
        // Limpar cache de configurações
        ConfigHelper::clearCache();
        
        return redirect()->route('system-config.index')
            ->with('success', 'Configuração criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $config = SystemConfig::findOrFail($id);
        return view('system-config.show', compact('config'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $config = SystemConfig::findOrFail($id);
        return view('system-config.edit', compact('config'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $config = SystemConfig::findOrFail($id);
        
        $request->validate([
            'value' => 'nullable|string',
            'type' => 'required|in:string,boolean,integer,json',
            'group' => 'required|string',
            'description' => 'nullable|string',
            'is_public' => 'boolean'
        ]);

        $config->update($request->all());
        
        // Limpar cache de configurações
        ConfigHelper::clearCache();
        
        return redirect()->route('system-config.index')
            ->with('success', 'Configuração atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $config = SystemConfig::findOrFail($id);
        $config->delete();
        
        // Limpar cache de configurações
        ConfigHelper::clearCache();
        
        return redirect()->route('system-config.index')
            ->with('success', 'Configuração removida com sucesso!');
    }

    /**
     * Atualizar múltiplas configurações
     */
    public function updateMultiple(Request $request)
    {
        $request->validate([
            'configs' => 'required|array',
            'configs.*.id' => 'required|exists:system_configs,id',
            'configs.*.value' => 'nullable|string',
            'logo_upload' => 'nullable|file|mimes:png,jpg,jpeg,svg|max:1024',
            'favicon_upload' => 'nullable|file|mimes:ico,png,svg|max:256',
            'slider_image_upload_1' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'slider_image_upload_2' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'slider_image_upload_3' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        // Upload de logo
        if ($request->hasFile('logo_upload')) {
            $file = $request->file('logo_upload');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);
            $logoUrl = '/storage/images/' . $filename;
            \App\Models\SystemConfig::setValue('logo_url', $logoUrl, 'string', 'frontend', 'URL do logo da empresa');
        }

        // Upload de favicon
        if ($request->hasFile('favicon_upload')) {
            $file = $request->file('favicon_upload');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);
            $faviconUrl = '/storage/images/' . $filename;
            \App\Models\SystemConfig::setValue('favicon_url', $faviconUrl, 'string', 'frontend', 'URL do favicon do sistema');
        }

        // Upload de imagens do slider
        for ($i = 1; $i <= 3; $i++) {
            $inputName = 'slider_image_upload_' . $i;
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $filename = 'slider_' . $i . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $filename);
                $sliderUrl = '/storage/images/' . $filename;
                \App\Models\SystemConfig::setValue('home_slider_image_' . $i, $sliderUrl, 'string', 'frontend', 'Imagem do slider da home ' . $i);
            }
        }

        // Atualizar demais configurações (exceto logo_url e favicon_url)
        foreach ($request->configs as $configData) {
            if (isset($configData['id']) && isset($configData['value'])) {
                $config = \App\Models\SystemConfig::find($configData['id']);
                if ($config && !in_array($config->key, ['logo_url', 'favicon_url'])) {
                    $config->update(['value' => $configData['value']]);
                }
            }
        }

        // Limpar cache de configurações
        \App\Helpers\ConfigHelper::clearCache();

        return redirect()->route('system-config.index')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }
}
