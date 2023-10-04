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
    <div class="flex mb-3 space-x-5">
        <div class="form-control">
            <label class="input-group input-group-sm">
                <span><i class="las la-search"></i></span>
                <input type="text" placeholder="Search" class="input input-bordered input-sm"
                    wire:model.lazy="search" />
            </label>
        </div>
        <select class="select select-sm select-bordered" wire:model.live='level_id'>
            @foreach ($levels as $level)
                <option value="{{$level->id}}">{{$level->con_cat()}}</option>
            @endforeach
        </select>
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
                        <td class="border">{{$selected_level->school_year}}</td>
                        <td class="text-right">Report for the Month of</td>
                        <td class="border">October 2023</td>
                        <td class="text-right" colspan="2">Learner Attendance Conversion Tool</td>
                        <td class="border"></td>
                    </tr>
                    <tr class="border-0">
                        <td class="text-right">School Name</td>
                        <td class="border" colspan="3">MRS Dayspring Christian School</td>
                        <td class="text-right">Grade Level</td>
                        <td class="border">{{$selected_level->description}} ({{$selected_level->am_pm}})</td>
                        <td class="text-right" colspan="2">Section</td>
                        <td class="border">{{$selected_level->section}}</td>
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
                <tbody>
                    <tr><td class="font-bold text-left uppercase border" colspan="{{ $to_day[2] + 5 }}"><span>Male</span></td></tr>
                    @php
                        $male_total = 0;
                        $present_male_total = 0;
                        $absent_male_total = 0;
                        $male_ids = [];
                    @endphp
                    @foreach ($selected_level->male_students->all() as $stud)
                        @php
                            $absent = 0;
                            $present = 0;
                            $male_total++;
                            array_push($male_ids, $stud->id);
                        @endphp
                        <tr>
                            <td class="border">{{$loop->iteration}}</td>
                            <td class="text-left border">{{$stud->fullname()}}</td>
                            @for ($d = $from_day[2]; $d <= $to_day[2]; $d++)
                                @php
                                    $date_ex = explode('-', $from);
                                    $cur_date = $date_ex[0] . '-' . $date_ex[1] . '-' . sprintf('%02d', $d);
                                    $day_now = \Carbon\Carbon::parse($cur_date)->isoFormat('d');
                                @endphp
                                <td class="border">
                                    @php
                                        $dtr = App\Models\AttendanceStudent::where('student_id', $stud->id)
                                            ->where('dtr_date', $cur_date)
                                            ->first();
                                        $holiday = App\Models\Holiday::where('date_holiday', $cur_date)->first();
                                    @endphp
                                    @if($dtr)
                                        @php
                                            $present++;
                                            $present_male_total++;
                                        @endphp
                                        <span>P</span>
                                    @elseif($day_now == 0 OR $day_now == 6 OR $holiday OR $cur_date > date('Y-m-d'))
                                        <span>-</span>
                                    @else
                                        @php
                                            $absent++;
                                            $absent_male_total++;
                                        @endphp
                                    @endif
                                </td>
                            @endfor
                            <td class="border">{{$absent}}</td>
                            <td class="border">{{$present}}</td>
                            <td class="border"></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="border"></td>
                        <td class="text-left border">Male Total: {{$male_total}}</td>
                        @for ($d = $from_day[2]; $d <= $to_day[2]; $d++)
                            @php
                                $date_ex = explode('-', $from);
                                $cur_date = $date_ex[0] . '-' . $date_ex[1] . '-' . sprintf('%02d', $d);
                            @endphp
                            <td class="border">
                                @php
                                    $m_total_daily = App\Models\AttendanceStudent::whereIn('student_id', $male_ids)
                                        ->where('dtr_date', $cur_date)
                                        ->count();
                                @endphp
                                {{ $m_total_daily != 0 ? $m_total_daily : '' }}
                            </td>
                        @endfor
                        <td class="border">{{$absent_male_total}}</td>
                        <td class="border">{{$present_male_total}}</td>
                        <td class="border"></td>
                    </tr>
                    <tr><td class="font-bold text-left uppercase border" colspan="{{ $to_day[2] + 5 }}"><span>Female</span></td></tr>
                    @php
                        $female_total = 0;
                        $present_female_total = 0;
                        $absent_female_total = 0;
                        $female_ids = [];
                    @endphp
                    @foreach ($selected_level->female_students->all() as $stud)
                        @php
                            $absent = 0;
                            $present = 0;
                            $female_total++;
                            array_push($female_ids, $stud->id);
                        @endphp
                        <tr>
                            <td class="border">{{$loop->iteration}}</td>
                            <td class="text-left border">{{$stud->fullname()}}</td>
                            @for ($d = $from_day[2]; $d <= $to_day[2]; $d++)
                                @php
                                    $date_ex = explode('-', $from);
                                    $cur_date = $date_ex[0] . '-' . $date_ex[1] . '-' . sprintf('%02d', $d);
                                    $day_now = \Carbon\Carbon::parse($cur_date)->isoFormat('d');
                                @endphp
                                <td class="border">
                                    @php
                                        $dtr = App\Models\AttendanceStudent::where('student_id', $stud->id)
                                            ->where('dtr_date', $cur_date)
                                            ->first();
                                        $holiday = App\Models\Holiday::where('date_holiday', $cur_date)->first();
                                    @endphp
                                    @if($dtr)
                                        @php
                                            $present++;
                                            $present_female_total++;
                                        @endphp
                                        <span>P</span>
                                    @elseif($day_now == 0 OR $day_now == 6 OR $holiday OR $cur_date > date('Y-m-d'))
                                        <span>-</span>
                                    @else
                                        @php
                                            $absent++;
                                            $absent_female_total++;
                                        @endphp
                                    @endif
                                </td>
                            @endfor
                            <td class="border">{{$absent}}</td>
                            <td class="border">{{$present}}</td>
                            <td class="border"></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="border"></td>
                        <td class="text-left border">Female Total: {{$female_total}}</td>
                        @for ($d = $from_day[2]; $d <= $to_day[2]; $d++)
                            @php
                                $date_ex = explode('-', $from);
                                $cur_date = $date_ex[0] . '-' . $date_ex[1] . '-' . sprintf('%02d', $d);
                            @endphp
                            <td class="border">
                                @php
                                    $f_total_daily = App\Models\AttendanceStudent::whereIn('student_id', $female_ids)
                                        ->where('dtr_date', $cur_date)
                                        ->count();
                                @endphp
                                {{ $f_total_daily != 0 ? $f_total_daily : '' }}
                            </td>
                        @endfor
                        <td class="border">{{$absent_female_total}}</td>
                        <td class="border">{{$present_female_total}}</td>
                        <td class="border"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
