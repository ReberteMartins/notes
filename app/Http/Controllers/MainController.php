<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;
use \Illuminate\Contracts\Encryption\DecryptException;

class MainController extends Controller
{
    //
    public function index()
    {
        $id = session(('user_id'));
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', compact('notes'));
    }

    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {
        echo "new note submit";
    }

    public function edit($id)
    {
        $id = Operations::decryptId($id);

        echo "edit note $id";
    }

    public function delete($id)
    {
        $id = Operations::decryptId($id);

        echo "delete note $id";
    }

}
