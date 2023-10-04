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
    {{-- <div class="grid justify-center w-full grid-cols-12 gap-5 mt-2 overflow-x-auto">
        <div class="flex flex-col h-full col-span-12 p-2 space-y-2 font-serif text-center bg-white rounded-md">
            <span class="text-2xl font-black"> School Form 2 (SF2) Daily Attendance Report of Learners </span>
            <span class="text-xs">(This replaces Form 1, Form 2 & STS Form 4 - Absenteeism and Dropout Profile)</span>
            <div class="grid grid-cols-12 gap-5">
                <div class="flex col-span-2">
                    <span class="py-1 ml-10 text-xs"> School ID </span>
                    <div class="px-1 ml-1 border">413006</div>
                </div>
                <div class="flex col-span-2">
                    <span class="py-1 ml-10 text-xs"> School Year </span>
                    <div class="px-1 ml-1 border">2023-2024</div>
                </div>
                <div class="flex col-span-4">
                    <span class="py-1 ml-10 text-xs"> Report for the Month of </span>
                    <div class="px-1 ml-1 border">2023-2024</div>
                </div>
                <div class="flex col-span-4">
                    <span class="py-1 ml-10 text-xs"> Learner Attendance Conversion Tool </span>
                    <div class="px-1 ml-1 border"></div>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-5">
                <div class="flex col-span-4">
                    <span class="py-1 ml-10 text-xs"> Name of School </span>
                    <div class="px-1 ml-1 border"> MRS Dayspring Christian School</div>
                </div>
                <div class="flex col-span-4">
                    <span class="py-1 ml-10 text-xs"> Grade Level </span>
                    <div class="px-1 ml-1 border"> PreKinder</div>
                </div>
                <div class="flex col-span-4">
                    <span class="py-1 ml-10 text-xs"> Section </span>
                    <div class="px-1 ml-1 border"> Sunrise</div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="flex flex-col h-full col-span-12 p-2 space-y-2 font-serif text-center bg-white rounded-md">
        <span class="text-2xl font-black"> School Form 2 (SF2) Daily Attendance Report of Learners </span>
        <span class="text-xs">(This replaces Form 1, Form 2 & STS Form 4 - Absenteeism and Dropout Profile)</span>
        <div class="w-full p-5">
            <table class="table border-0 table-fixed table-xs">
                <tbody>
                    <tr class="border-0">
                        <td class="text-right">School ID</td>
                        <td class="border">413006</td>
                        <td class="text-right">School Year</td>
                        <td class="border">2023-2024</td>
                        <td class="text-right">Report for the Month of</td>
                        <td class="border">October 2023</td>
                        <td class="text-right" colspan="2">Learner Attendance Conversion Tool</td>
                        <td class="border"></td>
                    </tr>
                    <tr class="border-0">
                        <td class="text-right">School Name</td>
                        <td class="border" colspan="3">MRS Dayspring Christian School</td>
                        <td class="text-right">Grade Level</td>
                        <td class="border">Pre Kinder</td>
                        <td class="text-right" colspan="2">Section</td>
                        <td class="border">Sunrise</td>
                    </tr>
                </tbody>
            </table>
            @php
                $from_day = explode('-', $from);
                $to_day = explode('-', $to);
            @endphp
            <table class="table text-center table-fixed table-xs">
                <tr>
                    <td class="border" rowspan="3">No.</td>
                    <td class="w-2/12 border" rowspan="3">
                        <span>NAME</span><br>
                        <span>(Last Name, First Name, Middle Name)</span>
                    </td>
                    <td class="border" rowspan="1" colspan="{{ $to_day[2] }}"><small>(1st row for the
                            date)</small></td>
                    <td class="w-1/12 border" rowspan="2" colspan="2">Total for the Month</td>
                    <td class="w-2/12 border" rowspan="3">
                        <span>REMARKS</span><br>
                        <small>
                            <p>(If NLPA, state reason, please refer to legend number
                                <br> 2. If TRANSFERRED IN/OUT, write the name of School.)
                            </p>
                        </small>
                    </td>
                </tr>
                <tr>
                    @for ($d = sprintf('%01d', $from_day[2]); $d <= $to_day[2]; $d++)
                        <td class="border">{{ $d }}</td>
                    @endfor
                </tr>
                <tr>
                    @for ($d = $from_day[2]; $d <= $to_day[2]; $d++)
                        @php
                            $date_ex = explode('-', $from);
                            $cur_date = $date_ex[0] . '-' . $date_ex[1] . '-' . sprintf('%02d', $d);
                            $day = \Carbon\Carbon::parse($cur_date)->format('D');
                        @endphp
                        <td class="border">{{ mb_substr($day, 0, 1) }}</td>
                    @endfor
                    <td class="border">Absent</td>
                    <td class="border">Present</td>
                </tr>
            </table>
        </div>
    </div>
</div>
