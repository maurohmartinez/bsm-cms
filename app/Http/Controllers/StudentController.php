<?php

namespace App\Http\Controllers;

use App\Enums\LessonStatusEnum;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
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
            'transactions' => Auth::guard(Student::GUARD)->user()->transactions,
            'paid' => Auth::guard(Student::GUARD)->user()->transactions()->sum('amount') / 100,
            'total' => Auth::guard(Student::GUARD)->user()->year->cost,
        ]);
    }

    public function grades(): View
    {
        return view('student.grades', [
            'subjects' => Subject::query()
                ->where('year_id', Auth::guard(Student::GUARD)->user()->year->id)
                ->with('teacher')
                ->get(),
        ]);
    }

    /**
     * @throws Exception
     */
    public function getCalendarEvents(Request $request): JsonResponse
    {
        /** @var Student $student */
        $student = Auth::guard(Student::GUARD)->user();
        $returns = [];

        $start = $request->input('start');
        $end = $request->input('end');
        $limit = 2;

        if (
            App::isProduction()
            && (Carbon::make($start)->diffInWeeks(Carbon::now()) > $limit
            || Carbon::make($end)->diffInWeeks(Carbon::now()) > $limit)
        ) {
            return new JsonResponse([]);
        }

        /** @var Collection<Lesson> $lessons */
        $lessons = Lesson::query()
            ->whereDate('starts_at', '>', $start)
            ->with(['subject', 'teacher', 'interpreter', 'studentAttendance'])
            ->whereDate('ends_at', '<', $end)
            ->get();

        foreach ($lessons->groupBy('subject_id') as $lessons) {
            foreach ($lessons as $lesson) {
                /** @var Subject $subject */
                $subject = $lesson->subject()->with('teacher')->first();

                $teacher = $lesson->subject?->teacher;
                $title = $subject
                    ? ('[' . $lesson->totalOf . '] ' . Str::words($subject->name, 2))
                    : 'To be confirmed';

                $returns [] = [
                    'id' => $lesson->id,
                    'title' => $title,
                    'hasAttendanceMarked' => $lesson?->studentAttendance()?->student($student)?->exists(),
                    'teacherName' => $teacher?->name ?? '',
                    'subjectId' => $lesson->subject_id,
                    'start' => $lesson->starts_at->format('Y-m-d H:i:s'),
                    'end' => $lesson->ends_at->format('Y-m-d H:i:s'),
                    'allDay' => false,
                    'color' => match (true) {
                        !is_null($lesson->subject_id) => $subject?->color ?? 'primary',
                        default => 'lightgray',
                    },
                ];
            }
        }

        return new JsonResponse($returns);
    }

    public function setAttendance(int $lessonId): JsonResponse
    {
        /** @var Student $student */
        $student = Auth::guard(Student::GUARD)->user();

        $lesson = Lesson::query()
            ->where('id', $lessonId)
            ->whereHas('subject', fn (Builder $query) => $query->where('year_id', $student->year_id))
            ->firstOrFail();

        $studentAttendance = $lesson->studentAttendance()->where('student_id', $student->id)->first();
        $studentAttendance ? $studentAttendance->delete() : $lesson->studentAttendance()->create(['student_id' => $student->id]);

        return new JsonResponse(['success' => true]);
    }

    public function login(): View|RedirectResponse
    {
        if (Auth::guard(Student::GUARD)->check()) {
            return Redirect::route('students.index');
        }

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

        if (!Auth::guard(Student::GUARD)->validate($request->only(['email', 'password']))) {
            return Redirect::route('students.login')->withErrors(['password' => 'Wrong password.'])->withInput();
        }

        Auth::guard(Student::GUARD)->login($user, $request->input('remember') === 'on');

        return Redirect::route('students.index');
    }

    public function logout(): RedirectResponse
    {
        Auth::guard(Student::GUARD)->logout();

        return Redirect::route('students.login');
    }
}
