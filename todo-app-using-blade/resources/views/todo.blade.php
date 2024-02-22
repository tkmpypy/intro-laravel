<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body>
    <!--
// v0 by Vercel.
// https://v0.dev/t/rnGzM2gmnMu
-->

    <div class="flex flex-col min-h-screen">
        <header class="border-b p-4">
            <h1 class="text-2xl font-bold">Todo List</h1>
        </header>
        <main class="flex-1 p-4">
            <div class="grid gap-4">
                <div>
                    <form method="POST" action="{{ route('store') }}" class="flex gap-4">
                        @method('POST')
                        @csrf
                        <label
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 flex items-center"
                            for="new-task">
                            <span class="sr-only">New task</span>
                            <input name="value"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 max-w-xs"
                                id="new-task" placeholder="Enter a new task" type="text" />
                        </label>
                        <input type="submit" value=" Submit "
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2" />
                    </form>
                </div>
                <div class="grid gap-2">
                    @foreach ($items as $item)
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('done') }}" class="inline-flex">
                            @method('PATCH')
                            @csrf
                            <input type="hidden" name="id" value="{{$item->id}}" />
                            <input type="hidden" name="done" value="0" />
                            <input onchange="this.form.submit()" name="done" value="1" {{$item->done ? 'checked' : ''}}
                            class="before:content[''] peer h-4 w-4 shrink-0 rounded-sm border border-primary
                            ring-offset-background focus-visible:outline-none focus-visible:ring-2
                            focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed
                            disabled:opacity-50 accent-black"
                            type="checkbox" id="task-{{$loop->index}}" />
                            <label
                                class="ml-2 text-sm leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 font-medium"
                                for="task-{{$loop->index}}">
                                {{ $item->value }}
                            </label>
                        </form>
                        <form method="POST" action="{{ route('delete') }}"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 w-10 ml-auto">
                            @method('PATCH')
                            @csrf
                            <label class="inline-flex h-full w-full">
                                <input type="hidden" value="{{$item->id}}" name="id" />
                                <input type="submit" class="" value="" />
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="-12 -12 48 48"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="h-full w-full">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                </svg>
                            </label>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</body>

</html>
