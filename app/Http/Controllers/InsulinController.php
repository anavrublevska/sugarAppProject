<?php

namespace App\Http\Controllers;

use App\Models\Insulin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InsulinController extends Controller
{
    public function index(): View
    {
        return view('system.insulin.index')
            ->with('insulins', Insulin::byCreator(Auth::user())->get());
    }

    public function create(): View
    {
        return $this->form();
    }

    private function form(Insulin $insulin = null): View
    {
        return view('system.insulin.form')
            ->with('insulin', $insulin);
    }

    public function store(Request $request): RedirectResponse
    {
        $insulin = new Insulin($request->all());
        $insulin->creator()->associate(Auth::user());
        $insulin->save();

        return redirect(route('insulins.index'));
    }

    public function edit(Insulin $insulin): View
    {
        return $this->form($insulin);

    }

    public function update(Request $request, Insulin $insulin): RedirectResponse
    {
        $insulin->update($request->all());

        return redirect(route('insulins.index'));
    }

    public function delete(Insulin $insulin): RedirectResponse
    {
        $insulin->delete();

        return redirect(route('insulins.index'));
    }
}
