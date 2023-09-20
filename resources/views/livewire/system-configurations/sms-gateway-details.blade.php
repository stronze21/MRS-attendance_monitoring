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

<div class="max-w-2xl p-10 mx-auto">
    <div class="flex flex-col col-span-12 p-2 space-y-2 bg-white rounded-md lg:col-span-8">
        <table class="table w-full border table-fixed table-compact">
            <thead class="text-lg font-bold text-black uppercase">
                <tr>
                    <th colspan="2">Account Name: {{ $details->account_name }} ({{ $details->account_id }})
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Status</td>
                    <td class="font-bold">{{ $details->status }}</td>
                </tr>
                <tr>
                    <td>Available Balance</td>
                    <td class="font-bold">{{ $details->credit_balance }}</td>
                </tr>
                <tr>
                    <td>Last Update</td>
                    <td class="font-bold">{{ \Carbon\Carbon::parse($details->updated_at)->diffForHumans() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
