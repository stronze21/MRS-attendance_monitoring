<x-slot name="header">
    <div class="text-sm breadcrumbs">
        <ul>
            <li class="font-bold">
                <i class="mr-1 las la-user-clock la-lg"></i> Time Log
            </li>
            <li>
                <i class="mr-1 las la-file la-lg"></i> Report
            </li>
        </ul>
    </div>
</x-slot>

<div class="p-10 mx-auto mt-5 bg-white rounded max-w-7xl">
    <div class="grid grid-cols-12">
        <div class="grid grid-cols-12 col-span-6 p-5 border">

            <div class="col-span-12 text-xs">Civil Service No. 48</div>
            <div class="col-span-12 mt-2 text-xl font-bold text-center">DAILY TIME RECORD</div>
            <div class="col-span-12 text-xs font-bold text-center">-----o0o-----</div>

            <div class="col-span-12 mx-10 mt-10 text-center border-b border-black">{{ $detail->fullname() }}</div>
            <div class="col-span-12 text-xs font-bold text-center">(Name)</div>

            <div class="col-span-12 mt-4 text-xs">For the month of {{ $month_of }}</div>
            <div class="col-span-12 text-xs">Official hourse for arrival and departure</div>
            <div class="col-span-1"></div>
            <div class="col-span-2 text-xs">Regular days</div>
            <div class="col-span-3 text-xs text-center border-b border-black"></div>
            <div class="col-span-6"></div>
            <div class="col-span-1"></div>
            <div class="col-span-2 text-xs">Saturdays</div>
            <div class="col-span-3 text-xs text-center border-b border-black"></div>
            <div class="col-span-6"></div>

            <div class="col-span-12 mt-5 text-xs">
                <table class="table w-full text-black border border-black table-fixed table-xs">
                    <thead class="text-center">
                        <tr>
                            <td rowspan="2" class="border">Day</td>
                            <td colspan="2" class="border">A.M.</td>
                            <td colspan="2" class="border">P.M.</td>
                            <td colspan="2" class="border">Undertime</td>
                        </tr>
                        <tr>
                            <td class="border">Arrival</td>
                            <td class="border">Departure</td>
                            <td class="border">Arrival</td>
                            <td class="border">Departure</td>
                            <td class="border">Hours</td>
                            <td class="border">Minutes</td>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($day = 1; $day <= 31; $day++)
                            @php
                                $current_dte = \Carbon\Carbon::createFromDate($year, $month, $day, 'Asia/Manila')->format('Y-m-d');
                                
                                $dtr = App\Models\AttendanceStudent::where('student_id', $teacher_id)
                                    ->where('dtr_date', $current_dte)
                                    ->first();
                            @endphp
                            <tr>
                                <td class="border">{{ $day }}</td>
                                <td class="text-center border">
                                    {{ $dtr && $dtr->time_in_am ? $dtr->time_in_am_format() : '' }}
                                </td>
                                <td class="text-center border">
                                    {{ $dtr && $dtr->time_out_am ? $dtr->time_out_am_format() : '' }}</td>
                                <td class="text-center border">
                                    {{ $dtr && $dtr->time_in_pm ? $dtr->time_in_pm_format() : '' }}
                                </td>
                                <td class="text-center border">
                                    {{ $dtr && $dtr->time_out_pm ? $dtr->time_out_pm_format() : '' }}</td>
                                <td class="text-center border"></td>
                                <td class="text-center border"></td>
                            </tr>
                        @endfor
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right border" colspan="5">Total</td>
                            <td class="border"></td>
                            <td class="border"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
