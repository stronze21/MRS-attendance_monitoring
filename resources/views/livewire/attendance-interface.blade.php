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
    <div class="justify-center grid grid-cols-12 w-full mt-2 overflow-x-auto gap-5 h-screen">
        <div class="flex flex-col space-y-2 col-span-12 lg:col-span-8 bg-white rounded-md p-2 h-full">
            <table class="table w-full table-compact">
                <thead class="uppercase">
                    <tr>
                        <th>Student #</th>
                        <th>Name</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr class="hover">
                            <th>{{ $attendance->student_id }}</th>
                            <td>{{ $attendance->student->fullname() }}</td>
                            <td>{{ $attendance->time_in }}</td>
                            <td>{{ $attendance->time_out }}</td>
                        </tr>
                    @empty
                        <tr>
                            <th class="text-center" colspan="10">No record found!</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex flex-col space-y-2 col-span-12 lg:col-span-4 bg-white rounded-md p-2 h-full">
            <div class="flex w-full">
                <div class="grid h-20 flex-1 card bg-success rounded-box place-items-center text-5xl font-bold btn"
                    @if ($type == 'in') disabled @endif wire:click='$set("type", "in")'>
                    Time-IN</div>
                <div class="divider divider-horizontal"></div>
                <div class="grid h-20 flex-1 card bg-error rounded-box place-items-center text-5xl font-bold btn"
                    @if ($type == 'out') disabled @endif wire:click='$set("type", "out")'>
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
                        scanner.start(cameras[0]);
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
