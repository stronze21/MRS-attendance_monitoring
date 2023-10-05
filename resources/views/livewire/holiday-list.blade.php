<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-list la-lg"></i> Holidays
            </li>
            <li>
                <i class="mr-1 las la-list la-lg"></i> List
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex flex-col p-5 mx-auto">
    <div class="flex space-x-5">
        <div class="form-control">
            <label class="input-group input-group-sm">
                <span><i class="las la-search"></i></span>
                <input type="date" class="input input-bordered input-sm" wire:model.lazy="search" />
            </label>
        </div>
        <button class="btn btn-sm btn-secondary" wire:click="$set('search', '')">
            <i class="las la-times"></i></button>
    </div>
    <div class="grid justify-center w-full h-screen grid-cols-12 gap-5 mt-2 overflow-x-auto">
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 bg-white rounded-md lg:col-span-8">
            <table class="table w-full table-compact">
                <thead class="uppercase">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th class="text-center">Active</th>
                        <th class="w-1/12 text-center">Toggle Active</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($holidays as $holiday)
                        <tr class="hover">
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ date('F j, Y', strtotime($holiday->date_holiday)) }}</td>
                            <td class="text-center">{!! $holiday->deleted_at
                                ? '<i class="las la-lg la-times-circle text-error"></i>'
                                : '<i class="las la-lg la-check-square text-success"></i>' !!}
                            </td>
                            <td class="text-center">
                                @if ($holiday->deleted_at)
                                    <button class="btn btn-sm btn-primary"
                                        wire:key='activate-holiday-{{ $holiday->id }}'
                                        wire:click='activate({{ $holiday->id }})'>
                                        <i class="las la-lg la-sliders-h"></i></button>
                                @else
                                    <button class="btn btn-sm btn-error"
                                        wire:key='deactivate-holiday-{{ $holiday->id }}'
                                        wire:click='deactivate({{ $holiday->id }})'>
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
                    {{ $updating ? 'Update Holiday' : 'Add new Holiday' }}</legend>
                <div class="w-full col-span-12 form-control">
                    <label class="label">
                        <span class="label-text">Date</span>
                    </label>
                    <input type="date" class="w-full input input-sm input-bordered" wire:model='date_holiday' />
                    @error('date_holiday')
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
