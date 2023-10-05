<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-list la-lg"></i> Levels
            </li>
            <li>
                <i class="mr-1 las la-eye la-lg"></i> View
            </li>
            <li>
                {{ $current_level->con_cat() }}
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex flex-col p-5 mx-auto">
    <div class="flex justify-between">
        <div>
            <div class="form-control">
                <label class="input-group input-group-sm">
                    <span><i class="las la-search"></i></span>
                    <input type="text" placeholder="Search" class="input input-bordered input-sm"
                        wire:model.lazy="search" />
                </label>
            </div>
        </div>
    </div>
    <div class="grid justify-center w-full h-screen grid-cols-12 gap-5 mt-2 overflow-x-auto">
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 bg-white rounded-md lg:col-span-8">
            <table class="table w-full table-xs">
                <thead class="uppercase">
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th class="w-1/12 text-center">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($current_level->students->all() as $stud)
                        <tr class="hover">
                            <th>{{ $stud->id }}</th>
                            <td>{{ $stud->fullname() }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-error" wire:key='remove-level-{{ $stud->id }}'
                                    wire:click='remove("{{ $stud->id }}")'>
                                    <i class="las la-lg la-trash-alt"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th class="text-center" colspan="10">No record found!</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 bg-white rounded-md lg:col-span-4">
            <div class="grid grid-cols-12 gap-2">
                <legend class="col-span-12 font-bold uppercase">Add Student to Class/Section</legend>
                <div class="w-full col-span-12 form-control xl:col-span-12">
                    <label class="label">
                        <span class="label-text">ID No.</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='student_id' />
                    @error('student_id')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control">
                    <button class="btn btn-primary" wire:click='save'>Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
