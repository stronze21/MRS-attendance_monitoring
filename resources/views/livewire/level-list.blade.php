<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-list la-lg"></i> Levels
            </li>
            <li>
                <i class="mr-1 las la-list la-lg"></i> List
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
            <table class="table w-full table-compact">
                <thead class="uppercase">
                    <tr>
                        <th>Level ID</th>
                        <th>Description</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($levels as $level)
                        <tr class="hover">
                            <th>{{ $level->id }}</th>
                            <td>{{ $level->description }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" wire:key='select-level-{{ $level->id }}'
                                    wire:click='select_level({{ $level->id }})'>
                                    <i class="las la-lg la-edit"></i></button>
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
                <legend class="col-span-12 font-bold uppercase">
                    {{ $updating ? 'Update Level/Section Information' : 'Add new Level/Section' }}</legend>
                <div class="w-full col-span-12 form-control">
                    <label class="label">
                        <span class="label-text">Description</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='description' />
                    @error('description')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                @if ($updating)
                    <div class="w-full col-span-6 form-control">
                        <button class="btn" wire:click='reset_data'>Cancel</button>
                    </div>
                    <div class="w-full col-span-6 form-control">
                        <button class="btn btn-outline btn-warning" wire:click='update'>Update</button>
                    </div>
                @else
                    <div class="w-full col-span-12 form-control">
                        <button class="btn btn-primary" wire:click='save'>Save</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
