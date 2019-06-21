<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CharacterProcess;

class CharacterController extends Controller
{

    protected $characterProcess;

    public function __construct(CharacterProcess $characterProcess)
    {
        $this->characterProcess = $characterProcess;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return  view('character.index',['data'=>$this->characterProcess->getIndex()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return  view('character.create',['data'=>collect()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static public function store(Request $request)
    {
        //
        $request->validate([
            'basic_playerName' => 'required',
            'basic_characterName' => 'required',
            'stat_STR' => 'required|integer',
            'stat_DEX' => 'required|integer',
            'stat_CON' => 'required|integer',
            'stat_INT' => 'required|integer',
            'stat_WIS' => 'required|integer',
            'stat_CHA' => 'required|integer'
        ]);

        $newObject = collect();
        $basic = [];
        $stat = [];

        foreach ($request->all() as $key => $item) {
            if (substr($key, 0, 1) !== '_') {
                list($part1, $part2) = explode('_', $key);

                switch ($part1) {
                    case 'basic':
                        $basic[] = [
                            $part2 => $item
                        ];
                        break;
                    case 'stat':
                        $stat[] = [
                            $part2 => $item
                        ];
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
        $newObject['basic'] = $basic;
        $newObject['stat'] = $stat;
        CharacterProcess::storeCharacter($newObject->toJson(),1);
        return redirect('character.index');
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
        return view('character.show',['data'=>$this->characterProcess->getShow($id)]);
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
        return view('character.edit',['data'=>$this->characterProcess->getShow($id)]);
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
        //
        dd($request,$id);
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
        dd($id);
    }
}
