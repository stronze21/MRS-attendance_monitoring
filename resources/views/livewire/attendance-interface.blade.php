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
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 bg-white rounded-md xl:col-span-7 2xl:col-span-8">
            <div class="flex w-full">
                <div class="grid flex-1 h-10 2xl:h-20 xl:h-10 text-sm md:text-2xl 2xl:text-5xl font-bold card rounded-box place-items-center btn
                @if ($for_user == 'student') btn-warning @else btn-active @endif "
                    wire:click='$set("for_user", "student")'>
                    For Students</div>
                <div class="divider divider-horizontal"></div>
                <div class="grid flex-1 h-10 2xl:h-20 xl:h-10 text-sm md:text-2xl 2xl:text-5xl font-bold card rounded-box place-items-center btn
                @if ($for_user == 'teacher') btn-warning @else btn-active @endif "
                    wire:click='$set("for_user", "teacher")'>
                    For Teachers</div>
            </div>
            <table class="hidden w-full border table-xs sm:table">
                <thead class="uppercase">
                    <tr>
                        <td class="text-center border" colspan="6">Recent Log</td>
                    </tr>
                    <tr class="border ">
                        <th rowspan="2" class="w-2/12 border">{{ $for_user }} ID</th>
                        <th rowspan="2" class="w-4/12 border">Name</th>
                        <th colspan="2" class="text-center border">AM</th>
                        <th colspan="2" class="text-center border">PM</th>
                    </tr>
                    <tr class="border">
                        <th class="w-1/12 text-center border">Time In</th>
                        <th class="w-1/12 text-center border">Time Out</th>
                        <th class="w-1/12 text-center border">Time In</th>
                        <th class="w-1/12 text-center border">Time Out</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr class="hover">
                            <th class="border">{{ $for_user == 'student' ? $attendance->student_id : $attendance->teacher_id }}</th>
                            <td class="border">{{ $for_user == 'student' ? $attendance->student->fullname() : $attendance->teacher->fullname()}}</td>
                            <td class="text-center border">
                                {{ $attendance->time_in_am ? $attendance->time_in_am_format() : '' }}</td>
                            <td class="text-center border">
                                {{ $attendance->time_out_am ? $attendance->time_out_am_format() : '' }}</td>
                            <td class="text-center border">
                                {{ $attendance->time_in_pm ? $attendance->time_in_pm_format() : '' }}</td>
                            <td class="text-center border">
                                {{ $attendance->time_out_pm ? $attendance->time_out_pm_format() : '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <th class="text-center" colspan="10">No record found!</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <table class="table w-full border table-xs sm:hidden">
                <thead class="uppercase">
                    <tr>
                        <td class="text-center border" colspan="2">Recent Log</td>
                    </tr>
                    <tr class="border ">
                        <th class="border">{{ $for_user }} ID</th>
                        <th class="border">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr class="hover">
                            <th class="border">{{ $for_user == 'student' ? $attendance->student_id : $attendance->teacher_id }}</th>
                            <td class="border">{{ $for_user == 'student' ? $attendance->student->fullname() : $attendance->teacher->fullname()}}</td>
                        </tr>
                    @empty
                        <tr>
                            <th class="text-center" colspan="2">No record found!</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 bg-white rounded-md xl:col-span-5 2xl:col-span-4">
            <div class="flex w-full">
                <div class="grid flex-1 h-20 xl:h-10 text-xl xl:text-2xl 2xl:text-5xl font-bold card @if ($type == 'in') btn-success @else btn-active @endif rounded-box place-items-center btn"
                    wire:click='$set("type", "in")'>
                    Time-IN</div>
                <div class="divider divider-horizontal"></div>
                <div class="grid flex-1 h-20 xl:h-10 text-xl xl:text-2xl 2xl:text-5xl font-bold card @if ($type == 'out') btn-error @else btn-active @endif rounded-box place-items-center btn"
                    wire:click='$set("type", "out")'>
                    Time-OUT</div>
            </div>
            <div class="flex flex-col w-full p-5" wire:ignore>
                <div class="flex flex-col text-center">
                    <span id="date" class="text-xl xl:text-2xl 2xl:text-5xl">{{ date('F j, Y') }}</span>
                    <span id="time" class="text-5xl font-bold xl:text-7xl 2xl:text-9xl"></span>
                </div>
            </div>
            <div class="flex space-x-2">
                <input type="text" class="w-full input input-sm input-bordered input-primary" placeholder="ID #" wire:model.live.debounce.150ms="id_no" />
                <button class="btn btn-sm btn-primary" wire:click='time_in()'>
                    Manual Log
                </button>
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
                        console.log(cameras);
                        $.each(cameras, (i, c) => {
                            if (c.name.indexOf('back') != -1) {
                                selectedCam = c;
                                return false;
                            }else if (c.name.indexOf('brio') != -1) {
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

                var cur_time = document.getElementById('time');

                function time() {
                    var d = new Date();
                    var s = d.getSeconds();
                    var m = d.getMinutes();
                    var h = d.getHours();
                    cur_time.textContent =
                        ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
                }
                setInterval(time, 1000);
            </script>
        </div>
    </div>
</div>
