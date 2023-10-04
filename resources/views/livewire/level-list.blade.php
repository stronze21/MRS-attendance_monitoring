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
                        <th>Section</th>
                        <th>School Year</th>
                        <th>AM/PM</th>
                        <th class="text-center">Active</th>
                        <th class="w-1/12 text-center">Update</th>
                        <th class="w-1/12 text-center">Toggle Active</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($levels as $level)
                        <tr class="hover">
                            <th>{{ $level->id }}</th>
                            <td>{{ $level->description }}</td>
                            <td>{{ $level->section }}</td>
                            <td>{{ $level->school_year }}</td>
                            <td class="uppercase">{{ $level->am_pm }}</td>
                            <td class="text-center">{!! $level->deleted_at
                                ? '<i class="las la-lg la-times-circle text-error"></i>'
                                : '<i class="las la-lg la-check-square text-success"></i>' !!}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" wire:key='select-level-{{ $level->id }}'
                                    wire:click='select_level({{ $level->id }})'>
                                    <i class="las la-lg la-edit"></i></button>
                            </td>
                            <td class="text-center">
                                @if($level->deleted_at)
                                <button class="btn btn-sm btn-primary" wire:key='activate-level-{{ $level->id }}'
                                    wire:click='activate({{ $level->id }})'>
                                    <i class="las la-lg la-sliders-h"></i></button>
                                @else
                                <button class="btn btn-sm btn-error" wire:key='deactivate-level-{{ $level->id }}'
                                    wire:click='deactivate({{ $level->id }})'>
                                    <i class="las la-lg la-sliders-h"></i></button>
                                @endif
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
                <div class="w-full col-span-12 form-control">
                    <label class="label">
                        <span class="label-text">Section</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='section' />
                    @error('section')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control">
                    <label class="label">
                        <span class="label-text">School Year</span>
                    </label>
                    <div class="flex space-x-5">
                        <input type="number" min="2023" class="w-full input input-sm input-bordered" wire:model='from' />
                        <span> - </span>
                        <input type="number" min="2030" class="w-full input input-sm input-bordered" wire:model='to' />
                    </div>
                    @error('description')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control">
                    <label class="label">
                        <span class="label-text">AM/PM</span>
                    </label>
                    <select class="select select-sm select-bordered" wire:model='am_pm'>
                        <option value="am">AM</option>
                        <option value="pm">PM</option>
                    </select>
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
