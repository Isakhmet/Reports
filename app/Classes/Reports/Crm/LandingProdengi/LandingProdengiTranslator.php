<?php


namespace App\Classes\Reports\Crm\LandingProdengi;


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
                if ($lead['status_lead_gate'] === $key) {
                    $lead['status_lead_gate'] = $value;
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
}