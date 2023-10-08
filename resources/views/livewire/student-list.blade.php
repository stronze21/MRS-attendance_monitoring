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
    <div class="grid justify-center w-full h-screen grid-cols-12 gap-5 mt-2 overflow-x-auto">
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 bg-white rounded-md lg:col-span-8">
            <table class="table w-full table-xs">
                <thead class="uppercase">
                    <tr>
                        <th>Student #</th>
                        <th>Name</th>
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
                            <td>{{ $student->gender() }}</td>
                            <td>{{ $student->guardian_name }}</td>
                            <td>{{ $student->level->description }}</td>
                            <td>{!! $student->notify_sms
                                ? '<i class="las la-lg la-check-square text-success"></i>'
                                : '<i class="las la-lg la-times-circle text-error"></i>' !!}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" wire:key='select-student-{{ $student->id }}'
                                    wire:click='select_student("{{ $student->id }}")'>
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
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 bg-white rounded-md lg:col-span-4">
            <div class="grid grid-cols-12 gap-2">
                <legend class="col-span-12 font-bold uppercase">
                    {{ $updating ? 'Update Student Information' : 'Add new Student' }}</legend>
                <div class="w-full col-span-12 form-control xl:col-span-12">
                    <label class="label">
                        <span class="label-text">ID No.</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='student_id' {{ $updating ? 'disabled' : '' }} />
                    @error('student_id')
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
                        <span class="label-text">Nick Name</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='nickname' />
                    @error('nickname')
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
                        <span class="label-text">Grade Level</span>
                    </label>
                    <select class="select select-sm select-bordered" wire:model='level_id'
                        @if ($updating) disabled @endif>
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
                <div class="w-full col-span-12 form-control">
                    <label class="label">
                        <span class="label-text">Address <small>(House #, Street, Bldg. Name, Appartment
                                #)</small></span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='address' />
                    @error('address')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Province</span>
                    </label>
                    <select class="select select-sm select-bordered" wire:model.live='province'>
                        @foreach ($province_table as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->province_name }}</option>
                        @endforeach
                    </select>
                    @error('province')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Municipality/City</span>
                    </label>
                    <select class="select select-sm select-bordered" wire:model.live='city'>
                        @foreach ($municipality_table as $mun)
                            <option value="{{ $mun->id }}">{{ $mun->municipality_name }}</option>
                        @endforeach
                    </select>
                    @error('city')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
                    <label class="label">
                        <span class="label-text">Barangay</span>
                    </label>
                    <select class="select select-sm select-bordered" wire:model='barangay'>
                        <option value=""></option>
                        @foreach ($barangay_table as $brg)
                            <option value="{{ $brg->id }}">{{ $brg->barangay_name }}</option>
                        @endforeach
                    </select>
                    @error('barangay')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-8">
                    <label class="label">
                        <span class="label-text">Parent/Guardian</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered" wire:model='guardian_name' />
                    @error('guardian_name')
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
                        <span class="label-text">Secondary Contact #</span>
                    </label>
                    <input type="text" class="w-full input input-sm input-bordered"
                        data-inputmask="'mask': '09 999 999 999'" wire:model='contact_no_2' />
                    @error('contact_no')
                        <label class="label text-danger">
                            <span class="label-text">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="w-full col-span-12 form-control xl:col-span-4">
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
