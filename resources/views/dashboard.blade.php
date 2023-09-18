<x-app-layout>
    <x-slot name="header">
        <div class="text-sm breadcrumbs">
            <ul>
                <li class="font-bold">
                    <i class="mr-1 las la-tachometer-alt la-lg"></i> Dashboard
                </li>
            </ul>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
