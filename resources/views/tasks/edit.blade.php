<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT // MONO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
<body class="min-h-screen p-6 md:p-12 flex items-center justify-center selection:bg-white selection:text-black">

    <div class="max-w-xl w-full">
        
        <div class="mb-6 flex items-center justify-between font-mono">
            <div class="flex items-center space-x-2">
                <span class="px-2 py-0.5 bg-white text-black text-[10px] font-bold uppercase">EDIT</span>
                <h1 class="text-sm font-semibold tracking-wider text-white uppercase">// TASK RECORD</h1>
            </div>
            <a href="{{ route('tasks.index') }}" class="text-xs text-zinc-500 hover:text-white transition-colors">
                &larr; BACK
            </a>
        </div>

        <div class="mono-box p-6 md:p-8">
            <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1.5">Task Title</label>
                    <input type="text" name="task_name" value="{{ $task->task_name }}" required class="w-full p-3.5 mono-input text-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1.5">Details / Notes</label>
                    <textarea name="description" rows="3" class="w-full p-3.5 mono-input text-sm resize-none">{{ $task->description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1.5">Status</label>
                        <select name="status" class="w-full p-3.5 mono-input text-sm">
                            <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1.5">Target Date</label>
                        <input type="date" name="due_date" value="{{ $task->due_date }}" class="w-full p-3.5 mono-input text-sm text-zinc-300">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-zinc-800">
                    <a href="{{ route('tasks.index') }}" class="px-4 py-3 text-xs font-mono text-zinc-500 hover:text-white transition-colors uppercase">
                        Cancel
                    </a>
                    <button type="submit" class="btn-stark px-6 py-3 text-xs font-mono uppercase tracking-wider">
                        Save Record
                    </button>
                </div>
            </form>
        </div>

    </div>
</body>
</html>