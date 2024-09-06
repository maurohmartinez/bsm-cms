<?php

namespace App\Http\Controllers;

use App\Enums\LessonStatusEnum;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function calendar(): View
    {
        return view('student.calendar');
    }

    public function tuition(): View
    {
        return view('student.tuition', [
            'transactions' => Auth::guard('students')->user()->transactions,
            'paid' => Auth::guard('students')->user()->transactions()->sum('amount') / 100,
            'total' => Auth::guard('students')->user()->year->cost,
        ]);
    }

    public function grades(): View
    {
        return view('student.grades', [
            'subjects' => Subject::query()
                ->where('year_id', Auth::guard('students')->user()->year->id)
                ->with('teacher')
                ->get(),
        ]);
    }

    /**
     * @throws Exception
     */
    public function getCalendarEvents(Request $request): JsonResponse
    {
        $returns = [];

        $start = $request->input('start');
        $end = $request->input('end');
        $limit = 30;

        if (Carbon::make($start)->diffInWeeks(Carbon::now()) > $limit || Carbon::make($end)->diffInWeeks(Carbon::now()) > $limit) {
            return new JsonResponse([]);
        }

        /** @var Collection<Lesson> $lessons */
        $lessons = Lesson::query()
            ->whereDate('starts_at', '>', $start)
            ->with(['subject', 'teacher', 'interpreter'])
            ->whereDate('ends_at', '<', $end)
            ->get();

        foreach ($lessons->groupBy('subject_id') as $lessons) {
            foreach ($lessons as $lesson) {
                /** @var Subject $subject */
                $subject = $lesson->subject()->with('teacher')->first();

                $teacher = $lesson->subject?->teacher;
                $title = $subject
                    ? '[' . $lesson->totalOf . '] ' . Str::words($subject->name, 2) . '/' . ($teacher?->name ?? '-')
                    : LessonStatusEnum::translatedOption($lesson->status);
                $title .= ($lesson->extras['notes'] ?? null) ? ' - ' . $lesson->extras['notes'] : '';

                $returns [] = [
                    'id' => $lesson->id,
                    'title' => $title,
                    'start' => $lesson->starts_at->format('Y-m-d H:i:s'),
                    'end' => $lesson->ends_at->format('Y-m-d H:i:s'),
                    'allDay' => false,
                    'color' => match (true) {
                        $lesson->is_chapel || in_array($lesson->status, [LessonStatusEnum::SPECIAL_ACTIVITY, LessonStatusEnum::TO_CONFIRM]) => LessonStatusEnum::getColor($lesson->status),
                        default => $subject?->color ?? 'lightgray',
                    },
                ];
            }
        }

        return new JsonResponse($returns);
    }

    public function login(): View
    {
        return view('student.login');
    }

    public function handleLogin(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);

        /** @var Student $user */
        $user = Student::query()->where('email', $request->get('email'))->first();

        if (!$user) {
            return Redirect::route('students.login')->withErrors(['email' => 'The user entered doesn\'t exists.']);
        }

        Auth::guard('students')->login($user);

        return Redirect::route('students.index');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('students')->logout();

        return Redirect::route('students.login');
    }
}
