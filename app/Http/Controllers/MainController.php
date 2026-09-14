<?php

namespace App\Http\Controllers;

use App\Models\Note;
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
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000',
            ],
            [
                'text_title.required' => 'O titulo é obrigatório.',
                'text_title.min' => 'O titulo deve ter no mínimo :min caracteres.',
                'text_title.max' => 'O titulo deve ter no máximo :max caracteres.',
                'text_note.required' => 'O campo nota é obrigatório.',
                'text_note.min' => 'O campo nota deve ter no mínimo :min caracteres.',
                'text_note.max' => 'O campo nota deve ter no máximo :max caracteres.',
            ]);

        $id = session(('user_id'));

        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;

        $note->save();

        return redirect()->route('home');
    }

    public function editNote($id)
    {
        $id = Operations::decryptId($id);

        $note = Note::find($id);

        return view('edit_note', compact('note'));
    }

    public function editNoteSubmit(Request $request)
    {
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000',
            ],
            [
                'text_title.required' => 'O titulo é obrigatório.',
                'text_title.min' => 'O titulo deve ter no mínimo :min caracteres.',
                'text_title.max' => 'O titulo deve ter no máximo :max caracteres.',
                'text_note.required' => 'O campo nota é obrigatório.',
                'text_note.min' => 'O campo nota deve ter no mínimo :min caracteres.',
                'text_note.max' => 'O campo nota deve ter no máximo :max caracteres.',
            ]);

        if ($request->note_id == null) {
            return redirect()->route('home');
        }
        
        $id = Operations::decryptId($request->note_id);

        $note = Note::find($id);
        $note->title = $request->text_title;
        $note->text = $request->text_note;

        $note->save();

        return redirect()->route('home');
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);

        $note = Note::find($id);

        return view('delete_note', compact('note'));
    }

    public function deleteNoteConfirm($id)
    {
        $id = Operations::decryptId($id);

        $note = Note::find($id);

        // $note->deleted_at = now();
        // $note->save();

        $note->delete();
        
        // $note->forceDelete();

        return redirect()->route('home');
    }

}
