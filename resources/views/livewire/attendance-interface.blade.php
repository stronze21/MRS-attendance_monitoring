<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-user-clock la-lg"></i> Time Log
            </li>
            <li>
                <i class="mr-1 las la-desktop la-lg"></i> Interface
            </li>
        </ul>
    </div>
</x-slot>

<div class="flex flex-col p-5 mx-auto">
    <div class="grid justify-center w-full h-screen grid-cols-12 gap-5 mt-2 overflow-x-auto">
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 bg-white rounded-md lg:col-span-8">
            <div class="flex w-full">
                <div class="grid flex-1 h-20 text-5xl font-bold card rounded-box place-items-center btn
                @if ($for_user == 'student') btn-warning @else btn-active @endif "
                    wire:click='$set("for_user", "student")'>
                    For Students</div>
                <div class="divider divider-horizontal"></div>
                <div class="grid flex-1 h-20 text-5xl font-bold card rounded-box place-items-center btn
                @if ($for_user == 'teacher') btn-warning @else btn-active @endif "
                    wire:click='$set("for_user", "teacher")'>
                    For Teachers</div>
            </div>
            <table class="table w-full border table-xs">
                <thead class="uppercase">
                    <tr>
                        <td class="text-center border" colspan="6">Recent Log</td>
                    </tr>
                    <tr class="border ">
                        <th rowspan="2" class="border">{{ $for_user }} ID</th>
                        <th rowspan="2" class="border">Name</th>
                        <th colspan="2" class="text-center border">AM</th>
                        <th colspan="2" class="text-center border">PM</th>
                    </tr>
                    <tr class="border">
                        <th class="text-center border">Time In</th>
                        <th class="text-center border">Time Out</th>
                        <th class="text-center border">Time In</th>
                        <th class="text-center border">Time Out</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr class="hover">
                            <th class="border">{{ $attendance->student_id }}</th>
                            <td class="border">{{ $attendance->student->fullname() }}</td>
                            <td class="text-center border">
                                {{ $attendance->time_in_am ? $attendance->time_in_am() : '' }}</td>
                            <td class="text-center border">
                                {{ $attendance->time_out_am ? $attendance->time_out_am() : '' }}</td>
                            <td class="text-center border">
                                {{ $attendance->time_in_pm ? $attendance->time_in_pm() : '' }}</td>
                            <td class="text-center border">
                                {{ $attendance->time_out_pm ? $attendance->time_out_pm() : '' }}</td>
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
            {{-- <div>
                <button class="btn btn-sm" wire:click='log'>
                    Log
                </button>
            </div> --}}
            <div class="flex w-full">
                <div class="grid flex-1 h-20 text-5xl font-bold card @if ($type == 'in') btn-success @else btn-active @endif rounded-box place-items-center btn"
                    wire:click='$set("type", "in")'>
                    Time-IN</div>
                <div class="divider divider-horizontal"></div>
                <div class="grid flex-1 h-20 text-5xl font-bold card @if ($type == 'out') btn-error @else btn-active @endif rounded-box place-items-center btn"
                    wire:click='$set("type", "out")'>
                    Time-OUT</div>
            </div>
            <video id="preview"></video>
            <script type="text/javascript">
                let scanner = new Instascan.Scanner({
                    video: document.getElementById('preview')
                });
                scanner.addListener('scan', function(content) {
                    console.log(content);
                    @this.set('id_no', content);
                    @this.dispatch('time_in');
                });
                Instascan.Camera.getCameras().then(function(cameras) {
                    if (cameras.length > 0) {
                        // scanner.start(cameras[0]);
                        var selectedCam = cameras[0];
                        $.each(cameras, (i, c) => {
                            if (c.name.indexOf('back') != -1) {
                                selectedCam = c;
                                return false;
                            }
                        });

                        scanner.start(selectedCam);
                    } else {
                        console.error('No cameras found.');
                    }
                }).catch(function(e) {
                    console.error(e);
                });
            </script>
        </div>
    </div>
</div>
