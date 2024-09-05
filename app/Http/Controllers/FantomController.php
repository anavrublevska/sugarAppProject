<?php

namespace App\Http\Controllers;

use App\Models\FantomPoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FantomController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $actionIcons = [
            "icon:trash | color:red | click:deleteFantomPoint('{id}') | tip:Usuń",
        ];
        $columnAliases = [
            'date'        => 'Data',
            'color'       => 'Kolor',
            'description' => 'Opis'
        ];

        $pointsHistory = [];
        FantomPoint::byUser(Auth::user())->get()->sortByDesc('date')->map(function (FantomPoint $point) use (&$pointsHistory) {
            return $pointsHistory[] = [
                'id'          => $point->id,
                'date'        => $point->date->format(config('app.date_format')),
                'color'       => '<div style="position: absolute; width: 15px; height: 15px;
            border-radius: 50%; background-color: ' . $point->color . '"></div>',
                'description' => $point->description
            ];
        });



        $fantomPoints = [];
        FantomPoint::byUser(Auth::user())->get()->map(function (FantomPoint $point) use (&$fantomPoints) {
            return $fantomPoints[] = [
                'id'      => (string) $point->id,
                'coord_x' => (string) $point->coord_x,
                'coord_y' => (string) $point->coord_y,
                'color'   => (string) $point->color,
                'date'    => (string) $point->date->format(config('app.date_format')),
            ];
        });

        return view('system.fantom.index')
            ->with('pointsHistory', $pointsHistory)
            ->with('fantomPoints', $fantomPoints)
            ->with('actionIcons', $actionIcons)
            ->with('columnAliases', $columnAliases);
    }

    public function storePoints(Request $request): RedirectResponse
    {
        $pointsArray = json_decode($request->get('points_data'), true);
        foreach ($pointsArray as $coordinates) {
            $point = new FantomPoint([
                'coord_x' => $coordinates['coord_x'],
                'coord_y' => $coordinates['coord_y'],
                'color'   => $coordinates['color'],
                'date'    => $request->input('date'),
                'description' => $request->input('description')
            ]);
            $point->user()->associate(Auth::user());
            $point->save();
        }

        return redirect(route('fantom.index'));
    }

    public function destroy(FantomPoint $fantomPoint, Request $request)
    {
        if ($fantomPoint->delete()) {
            if ($request->ajax()) {
                return ['success' => true];
            }
        }

        return redirect(route('fantom.index'));
    }
}
