<header class="bg-[#880000] text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <div class="flex items-center space-x-4">
                <h1 class="font-bold text-lg hidden sm:block">
                    {{ optional($exam)->title ?? 'COMP 20133 - Software Engineering' }}
                </h1>
                <div class="border-l border-white/20 h-6"></div>
            </div>

            <div class="flex items-center space-x-5">
                <div class="flex items-center text-[#FFD700]">
                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-mono font-bold text-lg tracking-wider" id="exam-timer">
                        --:--:--
                    </span>
                </div>

                <form action="{{ route('student.exams.submit', optional($exam)->id) }}" method="POST" id="exam-submit-form" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="bg-white text-[#880000] font-bold px-4 py-1.5 rounded-md hover:bg-gray-100 transition-colors text-sm">
                        Finish Exam
                    </button>
                </form>
            </div>

        </div>
    </div>
</header>

<script>
    const examId = {{ optional($exam)->id ?? 'null' }};
    const totalDuration = {{ optional($exam)->duration_minutes ?? 90 }} * 60;

    const timerKey = `exam_timer_${examId}`;
    const timerElement = document.getElementById('exam-timer');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const autosaveUrl = '{{ isset($exam) ? route("student.exams.autosave", optional($exam)->id) : "" }}';

    let deadline;
    const stored = localStorage.getItem(timerKey);

    if (stored) {
        deadline = parseInt(stored);
    } else {
        deadline = Date.now() + totalDuration * 1000;
        localStorage.setItem(timerKey, deadline);
    }

    function getTimeRemaining() {
        return Math.max(0, Math.floor((deadline - Date.now()) / 1000));
    }

    function collectAnswers() {
        const data = {};
        try {
            const form = document.getElementById('examForm');
            if (!form) return data;
            form.querySelectorAll('input[type="radio"]').forEach(i => {
                if (i.checked) {
                    const match = i.name.match(/answers\[(\d+)\]/);
                    if (match) data[match[1]] = parseInt(i.value);
                }
            });
        } catch (e) {}
        return data;
    }

    function submitExam() {
        clearInterval(countdown);
        localStorage.removeItem(timerKey);

        try {
            if (autosaveUrl) {
                const payload = JSON.stringify({ answers: collectAnswers(), _token: csrf });
                const blob = new Blob([payload], { type: 'application/json' });
                navigator.sendBeacon(autosaveUrl, blob);
            }
        } catch (e) {}

        setTimeout(() => {
            const examForm = document.getElementById('examForm');
            if (examForm) {
                examForm.submit();
            } else {
                document.getElementById('exam-submit-form')?.submit();
            }
        }, 250);
    }

    function updateTimer() {
        const timeRemaining = getTimeRemaining();

        if (timeRemaining <= 0) {
            timerElement.innerHTML = "00:00:00";
            submitExam();
            return;
        }

        const hours   = String(Math.floor(timeRemaining / 3600)).padStart(2, '0');
        const minutes = String(Math.floor((timeRemaining % 3600) / 60)).padStart(2, '0');
        const seconds = String(timeRemaining % 60).padStart(2, '0');

        timerElement.innerHTML = `${hours}:${minutes}:${seconds}`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('exam-submit-form')?.addEventListener('submit', () => {
            localStorage.removeItem(timerKey);
        });
        document.getElementById('examForm')?.addEventListener('submit', () => {
            localStorage.removeItem(timerKey);
        });
    });

    updateTimer();
    const countdown = setInterval(updateTimer, 1000);
</script>