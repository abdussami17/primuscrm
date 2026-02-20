<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;




class CustomersImport implements WithHeadingRow, OnEachRow
{
    /**
     * Report collected during import: unmapped assigned_to values and per-row errors.
     */
    public $report = [
        'rows' => [],
        'errors' => [],
        'imported' => 0,
    ];

    private $updateExisting;
    private $skipDuplicates;

    public function __construct($updateExisting = false, $skipDuplicates = true)
    {
        $this->updateExisting = $updateExisting;
        $this->skipDuplicates = $skipDuplicates;
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $rowArray = $row->toArray();

        try {
            $assignedRaw = $this->val($rowArray, ['currentsalesrepuserid', 'assignedto', 'assigned_to', 'assigned']);
            $assignedId = $this->resolveAssigned($assignedRaw);

            if ($assignedRaw && $assignedId === null) {
                $this->report['rows'][] = [
                    'row' => $rowIndex,
                    'issue' => 'assigned_to not found',
                    'value' => $assignedRaw,
                ];
            }

            $data = [
                'first_name'   => $this->val($rowArray, ['firstname', 'first_name', 'first name', 'first']),
                'middle_name'  => $this->val($rowArray, ['middlename', 'middle_name', 'middle name', 'middle']),
                'last_name'    => $this->val($rowArray, ['lastname', 'last_name', 'last name', 'last']),
                'email'        => $this->val($rowArray, ['email', 'emailaddress', 'email_address']),
                'phone'        => $this->val($rowArray, ['dayphone', 'phone', 'day_phone', 'day phone']),
                'work_phone'   => $this->val($rowArray, ['evephone', 'workphone', 'work_phone', 'work phone']),
                'cell_phone'   => $this->val($rowArray, ['cellphone', 'cell_phone', 'cell phone', 'mobile']),
                'address'      => $this->val($rowArray, ['address', 'streetaddress', 'street_address', 'street address']),
                'city'         => $this->val($rowArray, ['city']),
                'state'        => $this->val($rowArray, ['state', 'province']),
                'zip_code'     => $this->val($rowArray, ['postalcode', 'zip', 'zip_code', 'postal_code']),

                'assigned_to'  => $assignedId,
                'bdc_agent'    => $this->resolveAssigned($this->val($rowArray, ['bdagentuserid', 'bdcagent', 'bdc_agent'])),

                'consent_sms'       => $this->emptyBool($rowArray, ['donotcall', 'do_not_call']),
                'consent_email'     => $this->emptyBool($rowArray, ['donotemail', 'do_not_email']),
                'consent_marketing' => $this->emptyBool($rowArray, ['donotmail', 'do_not_mail']),

                'preferences' => [
                    'nickname'        => $this->val($rowArray, ['nickname']),
                    'email_alt'       => $this->val($rowArray, ['emailalt', 'email_alt', 'email alt']),
                    'birthday'        => $this->date($this->val($rowArray, ['birthday'])),
                    'anniversary'     => $this->date($this->val($rowArray, ['weddinganniversary', 'wedding_anniversary'])),
                    'marital_status'  => $this->val($rowArray, ['maritalstatus', 'marital_status']),
                ],

                'created_at' => $this->date($this->val($rowArray, ['createdutc', 'created_at', 'created'])),
                'updated_at' => $this->date($this->val($rowArray, ['lastupdatedutc', 'updated_at', 'last_updated'])),
            ];

          // Layered matching
$existing = Customer::where('email', $data['email'])
->orWhere('phone', $data['phone'])
->orWhere('cell_phone', $data['cell_phone'])
->orWhere(function($q) use ($data) {
    $q->where('first_name', $data['first_name'])
      ->where('last_name', $data['last_name']);
})
->first();

if ($existing) {
if ($this->updateExisting) {
    $existing->update($data);
    $this->report['imported']++;
} elseif ($this->skipDuplicates) {
    $this->report['rows'][] = [
        'row' => $rowIndex,
        'issue' => 'Duplicate skipped',
        'value' => $data['email'] ?? $data['phone'] ?? $data['cell_phone'],
    ];
} else {
    // optional: create anyway if neither checkbox is checked
    Customer::create($data);
    $this->report['imported']++;
}
} else {
Customer::create($data);
$this->report['imported']++;
}


        } catch (\Exception $e) {
            Log::error('Customer import row failed', ['row' => $rowIndex, 'error' => $e->getMessage()]);
            $this->report['errors'][] = ['row' => $rowIndex, 'error' => $e->getMessage()];
        }
    }

    /**
     * Resolve an assigned user value (id, email, or "First Last") to a user id, or null.
     */
    private function resolveAssigned($value)
    {
        if ($value === null) return null;
        $v = trim((string)$value);
        if ($v === '') return null;

        // numeric id
        if (is_numeric($v)) {
            $user = User::find((int)$v);
            if ($user) return $user->id;
        }

        // email
        if (strpos($v, '@') !== false) {
            $user = User::where('email', $v)->first();
            if ($user) return $user->id;
        }

        // try "First Last"
        $parts = preg_split('/\s+/', $v);
        if (count($parts) >= 2) {
            $first = array_shift($parts);
            $last = array_pop($parts);
            $user = User::where('first_name', $first)->where('last_name', $last)->first();
            if ($user) return $user->id;
        }

        return null;
    }

    /**
     * Retrieve a value from the row using a list of possible header names.
     */
    private function val(array $row, array $candidates, $default = null)
    {
        foreach ($candidates as $candidate) {
            if (isset($row[$candidate])) return $row[$candidate];
        }

        $normalized = [];
        foreach ($row as $k => $v) {
            $normalized[$this->normalize($k)] = $v;
        }

        foreach ($candidates as $candidate) {
            $n = $this->normalize($candidate);
            if (isset($normalized[$n])) return $normalized[$n];
        }

        return $default;
    }

    private function emptyBool(array $row, array $candidates)
    {
        $val = $this->val($row, $candidates, null);
        if ($val === null) return true;
        $v = trim((string)$val);
        if ($v === '' || $v === '0' || strtolower($v) === 'false' || strtolower($v) === 'no') return true;
        return false;
    }

    private function normalize($s)
    {
        return strtolower(preg_replace('/[^a-z0-9]/', '', (string)$s));
    }

    private function date($value)
    {
        if (!$value) return null;

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
