<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Models\Mentor;
use App\Models\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MentorController extends Controller
{

    public function index(Request $request)
    {
        /**
         * URL example:
         * http://localhost:8000/api/mentors?per_page=10&page=2&searchBy=er&sortBy=name&orderBy=asc
         */
        $search = $request->query('searchBy', '');
        $perPage = $request->query('per_page', 10);
        $order = $request->query('orderBy', 'desc');
        $sort = $request->query('sortBy', 'updated_at');


        $query = Mentor::search($search);
        $query->orderBy($sort, $order);

        return response()->json([
            'message' => 'Successfully retrieved mentors',
            'paginate' => $query->paginate($perPage)
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

        if (Auth::user()->role !== RoleEnum::ADMIN->value) {
            return response()->json([
                'message' => 'Unauthorized action.',
            ], Response::HTTP_FORBIDDEN);
        }

        $mentor->delete();

        return response()->json([
            'message' => 'The mentor were successfully deleted.',
        ]);
    }
}
