<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $env_files = [
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_DRIVER' => env('MAIL_DRIVER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),

        ];
        $settings = Setting::all();
        $notify = User::with('result')
            ->whereHas('result')
            ->where('notify', 1)
            ->get();
        if ($request->ajax()) {
            return view('admin.settings', compact('settings', 'notify', 'env_files'))->renderSections()['content'];
        }
        return view('admin.settings', compact('settings', 'notify', 'env_files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);


        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg',
            'favicon' => 'mimes:ico',
        ]);

        $input = $request->all();

        if ($file = $request->file('logo')) {

            $name = 'logo_' . time() . $file->getClientOriginalName();
            unlink(public_path() . '/assessment/images/logo/' . $setting->logo);
            $file->move('images/logo/', $name);
            $input['logo'] = $name;
        }

        if ($file2 = $request->file('favicon')) {

            $name2 = $file2->getClientOriginalName();
            unlink(public_path() . '/assessment/images/logo/' . $setting->favicon);
            $file2->move('images/logo/', $name2);
            $input['favicon'] = $name2;
        }

        if (isset($request->rightclick)) {

            $setting->right_setting = 1;
        } else {

            $setting->right_setting = 0;
        }

        if (isset($request->inspect)) {
            $setting->element_setting = 1;
        } else {
            $setting->element_setting = 0;
        }

        $setting->update($input);
        return back()->with('updated', 'Settings have been saved !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
