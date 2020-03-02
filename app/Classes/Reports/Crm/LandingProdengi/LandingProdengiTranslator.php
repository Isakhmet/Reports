<?php


namespace App\Classes\Reports\Crm\LandingProdengi;


use Illuminate\Support\Facades\Log;

class LandingProdengiTranslator
{
    public $translator;

    public function __construct()
    {
        $this->translator = __('report.reports.LandingProdengi.translator');
    }

    public function translate($data)
    {
        $leads = [];
        foreach ($data as $lead) {
            foreach ($this->translator['status'] as $key => $value) {
                if ($lead['statusRequest'] === $key) {
                    $lead['statusRequest'] = $value;
                }
            }
            foreach ($this->translator['source'] as $key => $value) {
                if ($lead['source'] === $key) {
                    $lead['source'] = $value;
                }
            }
            foreach ($this->translator['sender'] as $key => $value) {
                if ($lead['sender'] === $key) {
                    $lead['sender'] = $value;
                }
            }
            $leads[] = $lead;
        }

        return $leads;
    }


    public function translateScoreGateStatus($data)
    {
        $leads = [];

        foreach ($data as $lead) {
            try {
                $lead['status'] = intval($lead['status']);
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }

            foreach ($this->translator['sendersSourcesScoreGate'] as $key => $value) {
                if ($lead['status'] === $key) {
                    $lead['statusRequest'] = $value['statusRequest'];
                    $lead['source']        = $value['source'];
                    $lead['sender']        = $value['sender'];
                }
            }

            foreach ($this->translator['statusScoreGate'] as $key => $value) {
                if ($lead['status'] === $key) {
                    $lead['status'] = $value;
                }
            }

            unset($lead['id']);
            $leads[] = $lead;
        }

        return $leads;
    }
}