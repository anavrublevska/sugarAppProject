<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsulinRequest;
use App\Models\Insulin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InsulinController extends Controller
{
    public function __construct()
    {
       $this->authorizeResource(Insulin::class);
    }
    public function index(): View
    {
        $actionIcons = [
            "icon:pencil | click:redirect('/insulins/{id}/edit') | tip:Edycja",
            "icon:trash | color:red | click:deleteInsulin('{id}', '{name}') | tip:Usuń",
        ];
        $columnAliases = [
            'name' => 'Nazwa',
        ];

        $insulinArray = [];

        Insulin::byCreator(Auth::user())->get()->map(function (Insulin $insulin) use (&$insulinArray) {
            return $insulinArray[] = [
                'id'            => $insulin->id,
                'name'          => $insulin->name,
            ];
        });

        return view('system.insulin.index')
            ->with('insulins', $insulinArray)
            ->with('actionIcons', $actionIcons)
            ->with('columnAliases', $columnAliases);
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

    public function store(InsulinRequest $request): RedirectResponse
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

    public function update(InsulinRequest $request, Insulin $insulin): RedirectResponse
    {
        $insulin->update($request->all());

        return redirect(route('insulins.index'));
    }

    public function destroy(Insulin $insulin, Request $request)
    {
        if ($insulin->delete()) {
            if ($request->ajax()) {
                return ['success' => true];
            }
        }

        return redirect(route('insulins.index'));
    }
}
