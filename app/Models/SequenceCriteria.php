<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SequenceCriteria extends Model
{
    use HasFactory;

    protected $table = 'sequence_criteria';

    protected $fillable = [
        'criteria_group_id',
        'field_name',
        'field_type',
        'operator',
        'values',
        'sort_order',
    ];

    protected $casts = [
        'values' => 'array',
        'sort_order' => 'integer',
    ];

    // Field Types
    public const TYPE_TEXT = 'text';
    public const TYPE_NUMBER = 'number';
    public const TYPE_DATE = 'date';
    public const TYPE_DROPDOWN = 'dropdown';
    public const TYPE_USER = 'user';
    public const TYPE_LANGUAGE = 'language';
    public const TYPE_IDENTIFIER = 'identifier';
    public const TYPE_YEAR = 'year';
    public const TYPE_INTEREST_RATE = 'interestrate';
    public const TYPE_SHOWROOM_VISIT = 'showroomvisit';

    // Operators
    public const OP_IS = 'is';
    public const OP_IS_NOT = 'is_not';
    public const OP_IS_BETWEEN = 'is_between';
    public const OP_IS_NOT_BETWEEN = 'is_not_between';
    public const OP_IS_GREATER_EQUAL = 'is_greater_equal';
    public const OP_IS_LESS_EQUAL = 'is_less_equal';
    public const OP_IS_BLANK = 'is_blank';
    public const OP_IS_NOT_BLANK = 'is_not_blank';
    public const OP_IS_WITHIN_LAST = 'is_within_the_last';
    public const OP_IS_NOT_WITHIN_LAST = 'is_not_within_the_last';

    // Field configuration mapping
    public static function getFieldConfig(): array
    {
        return [
            'text' => [
                'fields' => [
                    'firstname', 'middlename', 'lastname', 'customername', 'cobuyer', 'email', 'alternateemail',
                    'cellphone', 'workphone', 'homephone', 'address', 'streetaddress', 'city', 'province',
                    'postalcode', 'country', 'make', 'model', 'bodystyle', 'exteriorcolor', 'interiorcolor',
                    'fueltype', 'engine', 'drivetype', 'transmission', 'franchise', 'lotlocation',
                    'dealershipname', 'dealershipphone', 'dealershipaddress', 'dealershipwebsite',
                    'lost', 'sold', 'notes', 'csi', 'consent', 'optout', 'businessname', 'trim', 'wishlist'
                ],
                'operators' => [self::OP_IS, self::OP_IS_NOT, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
            'identifier' => [
                'fields' => ['vin', 'stocknumber'],
                'operators' => [self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
            'year' => [
                'fields' => ['year', 'tradeinyear'],
                'operators' => [self::OP_IS, self::OP_IS_BETWEEN, self::OP_IS_GREATER_EQUAL, self::OP_IS_LESS_EQUAL, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
            'number' => [
                'fields' => ['odometer', 'doors', 'saleprice', 'sellingprice', 'internetprice', 'equity','lastkms','estimatedkms','servicecost', 'tradeinsellingprice', 'buyout'],
                'operators' => [self::OP_IS, self::OP_IS_NOT, self::OP_IS_BETWEEN, self::OP_IS_NOT_BETWEEN, self::OP_IS_GREATER_EQUAL, self::OP_IS_LESS_EQUAL, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
            'date' => [
                'fields' => [
                    'appointmentcreationdate', 'appointmentdate', 'createddate', 'deliverydate',
                    'demodate', 'lastcontacteddate','servicedate', 'leasematuritydate', 'solddate','lastservicedate','taskcompleteddate',
                    'taskduedate', 'financematuritydate', 'firstcontactdate', 'financestartdate',
                    'leasestartdate', 'warrantyexpiration', 'assigneddate', 'date', 'birthday', 'updated', 'showroomvisitdate'
                ],
                'operators' => [self::OP_IS, self::OP_IS_BETWEEN, self::OP_IS_GREATER_EQUAL, self::OP_IS_LESS_EQUAL, self::OP_IS_NOT, self::OP_IS_NOT_BETWEEN, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK, self::OP_IS_WITHIN_LAST, self::OP_IS_NOT_WITHIN_LAST],
            ],
            'dropdown' => [
                'fields' => ['leadsource', 'language'], // Only single-select dropdowns remain here
                'operators' => [self::OP_IS, self::OP_IS_NOT, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
               // NEW: Add multiselect type for fields that need checkboxes
            'multiselect' => [
                'fields' => [
                    'leadtype',
                    'leadstatus',
                    'inventorytype',
                    'source',
                    'salestatus',
                    'salestype',
                    'dealtype',
                    'tasktype',
                    'statustype'
                ],
                'operators' => [self::OP_IS, self::OP_IS_NOT, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
            'priority' => [
                'fields' => ['priority'],
                'operators' => [self::OP_IS, self::OP_IS_NOT, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
            'user' => [
                'fields' => [
                    'createdby', 'assignedby', 'assignedto', 'assignedmanager', 'bdcagent', 'bdcmanager',
                    'financemanager', 'generalmanger', 'inventorymanager', 'salesmanager', 'secondaryassigned',
                    'serviceadvisor', 'updatedby'
                ],
                'operators' => [self::OP_IS, self::OP_IS_NOT, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
            'language' => [
                'fields' => ['language'],
                'operators' => [self::OP_IS, self::OP_IS_NOT, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
            'showroomvisit' => [
                'fields' => ['showroomvisit'],
                'operators' => [self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
            'interestrate' => [
                'fields' => ['interestrate'],
                'operators' => [self::OP_IS, self::OP_IS_BETWEEN, self::OP_IS_GREATER_EQUAL, self::OP_IS_LESS_EQUAL, self::OP_IS_NOT, self::OP_IS_NOT_BETWEEN, self::OP_IS_BLANK, self::OP_IS_NOT_BLANK],
            ],
        ];
    }

    public static function getOperatorLabels(): array
    {
        return [
            self::OP_IS => 'is',
            self::OP_IS_NOT => 'is not',
            self::OP_IS_BETWEEN => 'is between',
            self::OP_IS_NOT_BETWEEN => 'is not between',
            self::OP_IS_GREATER_EQUAL => 'is greater than or equal to',
            self::OP_IS_LESS_EQUAL => 'is less than or equal to',
            self::OP_IS_BLANK => 'is blank',
            self::OP_IS_NOT_BLANK => 'is not blank',
            self::OP_IS_WITHIN_LAST => 'is within the last',
            self::OP_IS_NOT_WITHIN_LAST => 'is not within the last',
        ];
    }

    public static function getAllFields(): array
    {
        $fields = [
            ['value' => 'firstname', 'text' => 'First Name'],
            ['value' => 'middlename', 'text' => 'Middle Name'],
            ['value' => 'lastname', 'text' => 'Last Name'],
            ['value' => 'customername', 'text' => 'Customer Name'],
            ['value' => 'cobuyer', 'text' => 'Co-Buyer'],
            ['value' => 'email', 'text' => 'Email'],
            ['value' => 'alternateemail', 'text' => 'Alternative Email'],
            ['value' => 'cellphone', 'text' => 'Cell Phone'],
            ['value' => 'workphone', 'text' => 'Work Phone'],
            ['value' => 'homephone', 'text' => 'Home Phone'],
            ['value' => 'address', 'text' => 'Full Address'],
            ['value' => 'streetaddress', 'text' => 'Street Address'],
            ['value' => 'city', 'text' => 'City'],
            ['value' => 'province', 'text' => 'Province'],
            ['value' => 'postalcode', 'text' => 'Postal Code'],
            ['value' => 'country', 'text' => 'Country'],
            ['value' => 'year', 'text' => 'Year'],
            ['value' => 'make', 'text' => 'Make'],
            ['value' => 'model', 'text' => 'Model'],
            ['value' => 'vin', 'text' => 'VIN'],
            ['value' => 'stocknumber', 'text' => 'Stock Number'],
            ['value' => 'odometer', 'text' => 'Odometer'],
            ['value' => 'bodystyle', 'text' => 'Body Style'],
            ['value' => 'exteriorcolor', 'text' => 'Exterior Color'],
            ['value' => 'interiorcolor', 'text' => 'Interior Color'],
            ['value' => 'fueltype', 'text' => 'Fuel Type'],
            ['value' => 'engine', 'text' => 'Engine'],
            ['value' => 'drivetype', 'text' => 'Drive Type'],
            ['value' => 'doors', 'text' => 'Doors'],
            ['value' => 'transmission', 'text' => 'Transmission'],
            ['value' => 'franchise', 'text' => 'Franchise'],
            ['value' => 'lotlocation', 'text' => 'Lot Location'],
            ['value' => 'saleprice', 'text' => 'Sale Price'],
            ['value' => 'sellingprice', 'text' => 'Selling Price'],
            ['value' => 'internetprice', 'text' => 'Internet Price'],
            ['value' => 'interestrate', 'text' => 'Interest Rate'],
            ['value' => 'equity', 'text' => 'Equity'],
            ['value' => 'dealershipname', 'text' => 'Dealership Name'],
            ['value' => 'dealershipphone', 'text' => 'Dealership Phone'],
            ['value' => 'dealershipaddress', 'text' => 'Dealership Address'],
            ['value' => 'dealershipwebsite', 'text' => 'Dealership Website'],
            ['value' => 'tradeinyear', 'text' => 'Trade-in Year'],
            ['value' => 'tradeinsellingprice', 'text' => 'Trade-in Selling Price'],
            ['value' => 'assignedto', 'text' => 'Assigned To'],
            ['value' => 'assignedby', 'text' => 'Assigned By'],
            ['value' => 'assignedmanager', 'text' => 'Assigned Manager'],
            ['value' => 'secondaryassigned', 'text' => 'Secondary Assigned'],
            ['value' => 'financemanager', 'text' => 'Finance Manager'],
            ['value' => 'bdcagent', 'text' => 'BDC Agent'],
            ['value' => 'bdcmanager', 'text' => 'BDC Manager'],
            ['value' => 'generalmanger', 'text' => 'General Manager'],
            ['value' => 'salesmanager', 'text' => 'Sales Manager'],
            ['value' => 'serviceadvisor', 'text' => 'Service Advisor'],
            ['value' => 'inventorymanager', 'text' => 'Inventory Manager'],
            ['value' => 'createdby', 'text' => 'Created By'],
            ['value' => 'appointmentcreationdate', 'text' => 'Appointment Creation Date'],
            ['value' => 'appointmentdate', 'text' => 'Appointment Date'],
            ['value' => 'createddate', 'text' => 'Created Date'],
            ['value' => 'deliverydate', 'text' => 'Delivery Date'],
            ['value' => 'demodate', 'text' => 'Demo Date'],
            ['value' => 'lastcontacteddate', 'text' => 'Last Contacted Date'],
            ['value' => 'leasematuritydate', 'text' => 'Lease Maturity Date'],
            ['value' => 'solddate', 'text' => 'Sold Date'],
            ['value' => 'lastservicedate', 'text' => 'Last Service Date'],
            ['value' => 'servicedate', 'text' => 'Service Date'],
            ['value' => 'taskcompleteddate', 'text' => 'Task Completed Date'],
            ['value' => 'taskduedate', 'text' => 'Task Due Date'],
            ['value' => 'financematuritydate', 'text' => 'Finance Maturity Date'],
            ['value' => 'firstcontactdate', 'text' => 'First Contact Date'],
            ['value' => 'financestartdate', 'text' => 'Finance Start Date'],
            ['value' => 'leasestartdate', 'text' => 'Lease Start Date'],
            ['value' => 'warrantyexpiration', 'text' => 'Warranty Expiration'],
            ['value' => 'assigneddate', 'text' => 'Assigned Date'],
            ['value' => 'birthday', 'text' => 'Birthday'],
            ['value' => 'updated', 'text' => 'Updated'],
            ['value' => 'leadtype', 'text' => 'Lead Type'],
            ['value' => 'salestatus', 'text' => 'Sales Status'],
            ['value' => 'statustype', 'text' => 'Status Type'],
            ['value' => 'tasktype', 'text' => 'Task Type'],
            ['value' => 'dealtype', 'text' => 'Deal Type'],
            ['value' => 'salestype', 'text' => 'Sales Type'],
            ['value' => 'source', 'text' => 'Source'],
            ['value' => 'priority', 'text' => 'Priority'],
            ['value' => 'leadsource', 'text' => 'Lead Source'],
            ['value' => 'leadstatus', 'text' => 'Lead Status'],
            ['value' => 'inventorytype', 'text' => 'Inventory Type'],
            ['value' => 'lost', 'text' => 'Lost'],
            ['value' => 'sold', 'text' => 'Sold'],
            ['value' => 'notes', 'text' => 'Notes'],
            ['value' => 'csi', 'text' => 'CSI'],
            ['value' => 'consent', 'text' => 'Consent'],
            ['value' => 'optout', 'text' => 'Opt-Out'],
            ['value' => 'language', 'text' => 'Language'],
            ['value' => 'businessname', 'text' => 'Business Name'],
            ['value' => 'buyout', 'text' => 'Buyout'],
            ['value' => 'lastkms', 'text' => 'Last KMs'],
            ['value' => 'estimatedkms', 'text' => 'Estimated KMs'],
            ['value' => 'servicecost', 'text' => 'Service Cost'],
            ['value' => 'wishlist', 'text' => 'Wishlist'],
            ['value' => 'updatedby', 'text' => 'Updated By'],
            ['value' => 'trim', 'text' => 'Trim'],
            ['value' => 'showroomvisit', 'text' => 'Showroom Visit'],
            ['value' => 'showroomvisitdate', 'text' => 'Showroom Visit Date'],
        ];
        
        // Sort the fields alphabetically by text (label)
        usort($fields, function($a, $b) {
            return strcmp($a['text'], $b['text']);
        });
        
        return $fields;
    }

    public static function getDropdownOptions(): array
    {
        return [
            'leadtype' => [
                'Internet Lead',
                'Text Lead',
                'Phone Lead',
                'Walk-In Lead',
                'Service Lead',
                'Parts Lead',
                'Referral Lead',
                'Website Chat Lead',
                'Import',
                'Wholesale',
                'Lease Renewal',
                'Unknown',
                'None'
            ],
            'salestatus' => [
                'Uncontacted',
                'Attempted',
                'Contacted',
                'Dealer Visit',
                'Demo',
                'Write-Up',
                'Pending F&I',
                'Delivered',
                'Sold',
             
            ],
            'statustype' => [
                'Open',
                'Completed',
                'Cancelled',
                'Missed',
                'No Show',
                'No Response',
                'No Show',
                
            ],
            'tasktype' => [
                'Inbound Call',
                'Outbound Call',
                'Inbound Text',
                'Outbound Text',
                'Inbound Email',
                'Outbound Email',
                'CSI',
                'Appointments',
                'Other',
            ],
            
            'dealtype' => ['Finance', 'Lease', 'Cash', 'Unknown'],
            'salestype' => ['Sales Lead', 'Service Lead', 'Parts Lead'],
            'source' => [
                'Internet',
                'Phone',
                'Walk-In',
                'Text',
                'Chat',
                'Referral',
                'Social Media',
                'Email',
                'Event',
                'Website',
                'Unknown',
                'None'
            ],
            'priority' => ['', 'High'],
            'leadsource' => ['Website', 'Referral', 'Advertisement', 'Social Media', 'Event', 'None'],
            'language' => ['English', 'French', 'Spanish'],
            'leadstatus' => [
                'Active',
                'Duplicate',
                'Invalid',
                'Lost',
                'Sold',
                'Wishlist',
                'Buy-In',
                'Unknown'
            ],
            'inventorytype' => [
                'New',
                'Pre-Owned',
                'CPO',
                'Demo',
                'Wholesale',
                'Unknown',
                'None'
            ],
        ];
    }

    public static function getFieldType(string $fieldName): string
    {
        $config = self::getFieldConfig();
        foreach ($config as $type => $data) {
            if (in_array($fieldName, $data['fields'])) {
                return $type;
            }
        }
        return 'text';
    }

    public static function getOperatorsForField(string $fieldName): array
    {
        $type = self::getFieldType($fieldName);
        $config = self::getFieldConfig();
        return $config[$type]['operators'] ?? [];
    }

    // Relationships
    public function group(): BelongsTo
    {
        return $this->belongsTo(SequenceCriteriaGroup::class, 'criteria_group_id');
    }

    // Accessors
    public function getOperatorLabelAttribute(): string
    {
        return self::getOperatorLabels()[$this->operator] ?? $this->operator;
    }

    public function getFieldLabelAttribute(): string
    {
        $fields = collect(self::getAllFields());
        $field = $fields->firstWhere('value', $this->field_name);
        return $field['text'] ?? $this->field_name;
    }

    // Check if operator requires value input
    public function requiresValue(): bool
    {
        return !in_array($this->operator, [self::OP_IS_BLANK, self::OP_IS_NOT_BLANK]);
    }

    // Check if operator needs range input
    public function requiresRange(): bool
    {
        return in_array($this->operator, [self::OP_IS_BETWEEN, self::OP_IS_NOT_BETWEEN]);
    }

    // Check if this is a "within last" type operator
    public function isWithinLastOperator(): bool
    {
        return in_array($this->operator, [self::OP_IS_WITHIN_LAST, self::OP_IS_NOT_WITHIN_LAST]);
    }
}