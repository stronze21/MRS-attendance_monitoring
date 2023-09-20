<?php

namespace App\Livewire\SystemConfigurations;

use App\Models\SmsGateway;
use Livewire\Component;

class SmsGatewayDetails extends Component
{

    public function render()
    {
        $details = SmsGateway::latest()->first();

        return view('livewire.system-configurations.sms-gateway-details', [
            'details' => $details,
        ]);
    }

    public function mount()
    {

        $ch = curl_init();
        $parameters = array(
            'apikey' => '90406d90c7fa3ca8dfde1e9a5d073d9b', //Your API KEY
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/account?apikey=90406d90c7fa3ca8dfde1e9a5d073d9b');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        $details = json_decode($output, true);

        if ($details) {
            SmsGateway::updateOrCreate([
                'apikey' => '90406d90c7fa3ca8dfde1e9a5d073d9b',
                'account_id' => $details['account_id'],
                'account_name' => $details['account_name'],
            ], [
                'status' => $details['status'],
                'credit_balance' => $details['credit_balance'],
            ]);
        }
    }
}
