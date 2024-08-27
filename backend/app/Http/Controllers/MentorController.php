<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Models\Mentor;
use Symfony\Component\HttpFoundation\Response;

class MentorController extends Controller
{

    public function index()
    {
        return response()->json([
            'message' => 'Success on retriving all mentors',
            'data' => Mentor::all()
        ]);
    }

    public function store(StoreMentorRequest $request)
    {
        $data = $request->validated();

        $newMentor = Mentor::create($data);

        return response()->json([
            'message' => 'Mentor has been created.',
            'data' => $newMentor
        ], Response::HTTP_CREATED);
    }

    public function show(Mentor $mentor)
    {
        return response()->json([
            'message' => 'Success on retriving mentor.',
            'data' => $mentor
        ]);
    }

    public function update(UpdateMentorRequest $request, Mentor $mentor)
    {
        $data = $request->validated();
        $mentor->update($data);

        return response()->json([
            'message' => 'The mentor details were successfully updated.',
        ]);
    }

    public function destroy(Mentor $mentor)
    {
        $mentor->delete();

        return response()->json([
            'message' => 'The mentor were successfully deleted.',
        ]);
    }
}
