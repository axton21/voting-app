<?php namespace VotingApp\Http\Controllers;

use Illuminate\Http\Request;
use VotingApp\Models\Setting;
use Cache;

class SettingsController extends Controller
{

    protected $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;

        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     * GET /settings
     *
     * @return \Illuminate\View\View;
     */
    public function index()
    {
        $settingsList = $this->setting->get();
        return view('settings.index', compact('settingsList'));
    }

    /**
     * Show the form for editing the specified resource.
     * GET /settings/{id}/edit
     *
     * @param Setting $setting
     * @return \Illuminate\View\View;
     */
    public function edit(Setting $setting)
    {
        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /settings/{id}
     *
     * @param Request $request
     * @param Setting $setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Setting $setting)
    {
        // If this is a text field, ensure it is not blank
        if($setting->type === 'text') {
            $this->validate($request, ['value' => 'required']);
        }

        $setting->value = $request->get('value');
        $setting->save();

        Cache::forget('settings');

        return redirect()->route('settings.index')->withFlashMessage('Setting updated.');
    }

}
