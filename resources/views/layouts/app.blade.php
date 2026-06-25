<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased flex flex-col min-h-screen">

    @if(request()->routeIs('student.exams.*')) 
        @include('partials.header-exam', ['exam' => request()->route('exam') ?? null])
    @elseif(auth()->check()) 
        @include('partials.header')
    @else 
        @include('partials.header-landing')
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>
    @include('partials.footer')

    @stack('scripts')
</body>

<script>
    (function checkExamDeadline() {
        const examTimerKeys = Object.keys(localStorage).filter(k => k.startsWith('exam_timer_'));

        examTimerKeys.forEach(timerKey => {
            const deadline = parseInt(localStorage.getItem(timerKey));
            if (!deadline) return;

            const examId = timerKey.replace('exam_timer_', '');
            const now = Date.now();

            function postForceSubmit() {
                localStorage.removeItem(timerKey);

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/student/exams/${examId}/force-submit`;

                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrf;

                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }

            if (now >= deadline) {
                postForceSubmit();
            } else {
                setTimeout(postForceSubmit, deadline - now);
            }
        });
    })();
</script>

</html>