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

<div class="flex flex-col p-5 mx-auto max-w-screen-2xl">
    <div class="flex justify-between space-x-2">
        <div class="form-control">
            <label class="input-group input-group-sm">
                <span><i class="las la-search"></i></span>
                <input type="text" placeholder="Search" class="input input-bordered input-sm"
                    wire:model.lazy="search" />
            </label>
        </div>
        <div class="form-control">
            <label class="input-group input-group-sm">
                <input type="month" class="input input-bordered input-sm" wire:model.lazy="month" />
            </label>
        </div>
    </div>
    <div class="grid justify-center w-full h-screen grid-cols-12 gap-5 mt-2 overflow-x-auto">
        <div class="flex flex-col col-span-12 p-2 space-y-2 bg-white rounded-md">
            <table class="table w-full table-compact">
                <thead class="uppercase">
                    <tr>
                        <th>Guardian Name</th>
                        <th>Contact No</th>
                        <th>Total SMS Sent</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $row)
                        <tr class="hover">
                            <th>{{ $row->guardian_name }}</th>
                            <td>{{ $row->contact_no }}</td>
                            <td>{{ $row->total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <th class="text-center" colspan="10">No record found!</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>
