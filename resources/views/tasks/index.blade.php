<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASKS // MONO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #000000; 
            color: #ededed;
        }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        .mono-box {
            background-color: #09090b;
            border: 1px solid #27272a;
        }
        .mono-card {
            background-color: #09090b;
            border: 1px solid #18181b;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .mono-card:hover {
            border-color: #52525b;
            background-color: #121215;
        }
        .mono-input {
            background-color: #000000;
            border: 1px solid #27272a;
            color: #ffffff;
            transition: border-color 0.15s ease;
        }
        .mono-input:focus {
            border-color: #ffffff;
            outline: none;
        }
        .btn-stark {
            background-color: #ffffff;
            color: #000000;
            font-weight: 600;
            transition: all 0.15s ease;
        }
        .btn-stark:hover {
            background-color: #e4e4e7;
        }
        ::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }
    </style>
</head>
<body class="min-h-screen p-6 md:p-12 selection:bg-white selection:text-black">

    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <header class="mb-12 border-b border-zinc-800 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-2 py-0.5 bg-white text-black text-[10px] font-mono font-bold uppercase tracking-widest">SYS.01</span>
                    <span class="text-xs font-mono text-zinc-500">// INDEX DIRECTORY</span>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white font-mono uppercase">Task Workspace</h1>
            </div>

            <!-- Stats Bar -->
            <div class="flex items-center space-x-2 font-mono text-xs">
                <div class="mono-box px-4 py-2.5 rounded-none flex items-center space-x-3">
                    <span class="text-zinc-500 uppercase">Total</span>
                    <span class="text-white font-bold">{{ $tasks->count() }}</span>
                </div>
                <div class="mono-box px-4 py-2.5 rounded-none flex items-center space-x-3">
                    <span class="text-zinc-500 uppercase">Done</span>
                    <span class="text-white font-bold">{{ $tasks->where('status', 'Completed')->count() }}</span>
                </div>
                <div class="mono-box px-4 py-2.5 rounded-none flex items-center space-x-3">
                    <span class="text-zinc-500 uppercase">Pending</span>
                    <span class="text-zinc-400 font-bold">{{ $tasks->where('status', 'Pending')->count() }}</span>
                </div>
            </div>
        </header>

        <!-- Flash Alert -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-zinc-900 border border-white text-xs font-mono text-white flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-square text-[8px] text-white"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-zinc-500 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- Quick Entry Section -->
        <section class="mono-box p-6 md:p-8 mb-12">
            <div class="flex items-center justify-between mb-6 pb-3 border-b border-zinc-800">
                <span class="text-xs font-mono uppercase tracking-widest text-zinc-400">
                    [+] Create New Record
                </span>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1">Task Title</label>
                        <input type="text" name="task_name" required class="w-full p-3.5 mono-input text-sm" placeholder="Enter title...">
                    </div>
                    <div>
                        <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1">Target Date</label>
                        <input type="date" name="due_date" class="w-full p-3.5 mono-input text-sm text-zinc-300">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1">Details / Notes</label>
                    <textarea name="description" rows="2" class="w-full p-3.5 mono-input text-sm resize-none" placeholder="Add specific notes or requirements..."></textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="btn-stark px-6 py-3 text-xs font-mono uppercase tracking-wider">
                        Add Task
                    </button>
                </div>
            </form>
        </section>

        <!-- Task Listing -->
        <section>
            <div class="flex items-center justify-between mb-4 font-mono text-xs text-zinc-500 uppercase tracking-widest">
                <span>// Task Feed</span>
                <span>{{ $tasks->count() }} Records Loaded</span>
            </div>

            <div class="space-y-2">
                @forelse($tasks as $task)
                    <div class="mono-card p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        
                        <div class="space-y-1.5 flex-1 pr-4">
                            <div class="flex items-center space-x-3">
                                @if($task->status === 'Completed')
                                    <span class="px-2 py-0.5 bg-zinc-800 text-zinc-400 font-mono text-[10px] uppercase tracking-wider border border-zinc-700">
                                        DONE
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-white text-black font-mono text-[10px] font-bold uppercase tracking-wider">
                                        PENDING
                                    </span>
                                @endif

                                <h3 class="text-sm font-medium tracking-tight {{ $task->status === 'Completed' ? 'line-through text-zinc-600' : 'text-white' }}">
                                    {{ $task->task_name }}
                                </h3>
                            </div>

                            @if($task->description)
                                <p class="text-xs text-zinc-500 font-light leading-relaxed pl-1">
                                    {{ $task->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Date & Options -->
                        <div class="flex items-center justify-between md:justify-end space-x-6 border-t md:border-t-0 border-zinc-800 pt-3 md:pt-0 font-mono">
                            
                            <span class="text-xs text-zinc-500 tracking-tight">
                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y.m.d') : 'NO DATE' }}
                            </span>

                            <div class="flex items-center space-x-1">
                                <form action="{{ route('tasks.toggleStatus', $task) }}" method="POST" 
                                      onsubmit="{{ $task->status === 'Pending' ? 'triggerConfetti(event, this)' : '' }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-9 h-9 border border-zinc-800 hover:border-zinc-500 text-zinc-400 hover:text-white flex items-center justify-center transition-colors" title="Toggle Status">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </button>
                                </form>

                                <a href="{{ route('tasks.edit', $task) }}" class="w-9 h-9 border border-zinc-800 hover:border-zinc-500 text-zinc-400 hover:text-white flex items-center justify-center transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>

                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 border border-zinc-800 hover:border-red-500 text-zinc-500 hover:text-red-400 flex items-center justify-center transition-colors" title="Delete">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-16 mono-box">
                        <p class="text-xs font-mono text-zinc-600 uppercase tracking-widest">// NO RECORDS FOUND IN DIRECTORY</p>
                    </div>
                @endforelse
            </div>
        </section>

    </div>

    <script>
        function triggerConfetti(e, form) {
            e.preventDefault(); 
            confetti({
                particleCount: 45,
                spread: 55,
                origin: { y: 0.7 },
                colors: ['#ffffff', '#a1a1aa', '#52525b', '#27272a'],
                disableForReducedMotion: true
            });
            setTimeout(() => { form.submit(); }, 300); 
        }
    </script>
</body>
</html>