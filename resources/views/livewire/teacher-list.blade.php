<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-chalkboard-teacher la-lg"></i> Teachers
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
                        <th>ID #</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact #</th>
                        <th>Years in Service</th>
                        <th class="text-center">Update</th>
                        <th class="text-center">DTR</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $teacher)
                        <tr class="hover">
                            <th>{{ $teacher->id }}</th>
                            <td>{{ $teacher->fullname() }}</td>
                            <td>{{ $teacher->birthdate }}</td>
                            <td>{{ $teacher->age() }}</td>
                            <td>{{ $teacher->gender() }}</td>
                            <td>{{ $teacher->contact_no }}</td>
                            <td>{{ $teacher->age_service() }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" wire:key='select-teacher-{{ $teacher->id }}'
                                    wire:click='select_teacher({{ $teacher->id }})'>
                                    <i class="las la-lg la-edit"></i></button>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('dtr.report', $teacher->id) }}" class="btn btn-sm btn-success"
                                    wire:key='view-dtr-{{ $teacher->id }}'>
                                    <i class="las la-lg la-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th class="text-center" colspan="10">No record found!</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $teachers->links() }}

        </div>
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 bg-white rounded-md lg:col-span-4">
            <div class="grid grid-cols-12 gap-2">
                <legend class="col-span-12 font-bold uppercase">
                    {{ $updating ? 'Update Teacher Information' : 'Add new teacher' }}</legend>
                <div class="w-full col-span-12 form-control xl:col-span-12">
                    <label class="label">
                        <span class="label-text">ID No.</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='teacher_id' />
                    @error('teacher_id')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">First Name</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='firstname' />
                    @error('firstname')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Middle Name</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='middlename' />
                    @error('middlename')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Last Name</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='lastname' />
                    @error('lastname')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Date of Birth</span>
                    </label>
                    <input type="date" class="w-full input input-sm input-bordered" wire:model='birthdate' />
                    @error('birthdate')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Gender</span>
                    </label>
                    <select class="select select-sm select-bordered" wire:model='gender'>
                        <option value=""></option>
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                    </select>
                    @error('gender')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Contact #</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered"
                        data-inputmask="'mask': '09 999 999 999'" wire:model='contact_no_mask' />
                    @error('contact_no')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Date appointed</span>
                    </label>
                    <input type="date" class="w-full input input-sm input-bordered" wire:model='appointment_date' />
                    @error('appointment_date')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-8">
                    <label class="label">
                        <span class="label-text">Address</span>
                    </label>
                    <textarea class="textarea textarea-bordered" wire:model='address'></textarea>
                    @error('address')
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
