<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-users la-lg"></i> Students
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
    <div class="justify-center grid grid-cols-12 w-full mt-2 overflow-x-auto gap-5 h-screen">
        <div class="flex flex-col space-y-2 col-span-12 lg:col-span-8 bg-white rounded-md p-2 h-full">
            <table class="table w-full table-compact">
                <thead class="uppercase">
                    <tr>
                        <th>Student #</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Guardian</th>
                        <th>Grade Level</th>
                        <th>Notify</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr class="hover">
                            <th>{{ $student->id }}</th>
                            <td>{{ $student->fullname() }}</td>
                            <td>{{ $student->birthdate }}</td>
                            <td>{{ $student->age() }}</td>
                            <td>{{ $student->gender() }}</td>
                            <td>{{ $student->guardian_name }} ({{ $student->guardian_relationship }})</td>
                            <td>{{ $student->level->description }}</td>
                            <td>{!! $student->notify_sms
                                ? '<i class="las la-lg la-check-square text-success"></i>'
                                : '<i class="las la-lg la-times-circle text-error"></i>' !!}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" wire:key='select-student-{{ $student->id }}'
                                    wire:click='select_student({{ $student->id }})'>
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
            {{ $students->links() }}

        </div>
        <div class="flex flex-col space-y-2 col-span-12 lg:col-span-4 bg-white rounded-md p-2 h-full">
            <div class="grid grid-cols-12 gap-2">
                <legend class="col-span-12 font-bold uppercase">
                    {{ $updating ? 'Update Student Information' : 'Add new Student' }}</legend>
                <div class="form-control w-full col-span-12 xl:col-span-12">
                    <label class="label">
                        <span class="label-text">ID No.</span>
                    </label>
                    <input type="text" class="input input-sm input-bordered w-full" wire:model='student_id' />
                    @error('student_id')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="form-control w-full col-span-12 xl:col-span-4">
                    <label class="label">
                        <span class="label-text">First Name</span>
                    </label>
                    <input type="text" class="input input-sm input-bordered w-full" wire:model='firstname' />
                    @error('firstname')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="form-control w-full col-span-12 xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Middle Name</span>
                    </label>
                    <input type="text" class="input input-sm input-bordered w-full" wire:model='middlename' />
                    @error('middlename')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="form-control w-full col-span-12 xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Last Name</span>
                    </label>
                    <input type="text" class="input input-sm input-bordered w-full" wire:model='lastname' />
                    @error('lastname')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="form-control w-full col-span-12 xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Date of Birth</span>
                    </label>
                    <input type="date" class="input input-sm input-bordered w-full" wire:model='birthdate' />
                    @error('birthdate')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="form-control w-full col-span-12 xl:col-span-4">
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
                <div class="form-control w-full col-span-12 xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Grade Level</span>
                    </label>
                    <select class="select select-sm select-bordered" wire:model='level_id'>
                        <option value=""></option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->description }}</option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="form-control w-full col-span-12 xl:col-span-8">
                    <label class="label">
                        <span class="label-text">Guardian</span>
                    </label>
                    <input type="text" class="input input-sm input-bordered w-full" wire:model='guardian_name' />
                    @error('guardian_name')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="form-control w-full col-span-12 xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Relationship</span>
                    </label>
                    <input type="text" class="input input-sm input-bordered w-full"
                        wire:model='guardian_relationship' />
                    @error('guardian_relationship')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="form-control w-full col-span-12 xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Contact #</span>
                    </label>
                    <input type="text" class="input input-sm input-bordered w-full"
                        data-inputmask="'mask': '09 999 999 999'" wire:model='contact_no_mask' />
                    @error('contact_no')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="form-control w-full col-span-12 xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Notify SMS</span>
                    </label>
                    <input type="checkbox" class="ml-5 checkbox checkbox-secondary" wire:model='notify_sms' />
                    @error('notify_sms')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                @if ($updating)
                    <div class="form-control w-full col-span-6">
                        <button class="btn" wire:click='reset_data'>Cancel</button>
                    </div>
                    <div class="form-control w-full col-span-6">
                        <button class="btn btn-outline btn-warning" wire:click='update'>Update</button>
                    </div>
                @else
                    <div class="form-control w-full col-span-12">
                        <button class="btn btn-primary" wire:click='save'>Save</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
