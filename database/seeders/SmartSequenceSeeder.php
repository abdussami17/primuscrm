<?php

namespace Database\Seeders;

use App\Models\SmartSequence;
use App\Models\SequenceCriteriaGroup;
use App\Models\SequenceCriteria;
use App\Models\SequenceAction;
use App\Models\Template;
use Illuminate\Database\Seeder;

class SmartSequenceSeeder extends Seeder
{
    public function run(): void
    {
        // Create email templates
        $templates = [
            [
                'name' => 'Book Dream Car',
                'subject' => 'Book Your Dream Car Today!',
                'type' => 'email',
                'body' => '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <h2 style="color: #0d6efd;">Book Your Dream Car Today!</h2>
                    <p>Dear [Customer Name],</p>
                    <p>We noticed you were interested in our vehicles. We\'d love to help you book a test drive for your dream car!</p>
                    <p>Contact us to schedule your appointment.</p>
                    <p>Best regards,<br>The Dealership Team</p>
                </div>',
            ],
            [
                'name' => 'Marketing Email',
                'subject' => 'Special Offer Just For You!',
                'type' => 'email',
                'body' => '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <h2 style="color: #0d6efd;">Special Offer Just For You!</h2>
                    <p>Hello [Customer Name],</p>
                    <p>Check out our latest special offers and promotions on new and pre-owned vehicles!</p>
                    <p>Don\'t miss this opportunity to get the best deal in town.</p>
                    <p>Sincerely,<br>Marketing Team</p>
                </div>',
            ],
            [
                'name' => 'Follow Up',
                'subject' => 'Just Following Up',
                'type' => 'email',
                'body' => '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <h2 style="color: #0d6efd;">Just Following Up</h2>
                    <p>Hi [Customer Name],</p>
                    <p>I wanted to follow up on our previous conversation about your vehicle needs.</p>
                    <p>Please let me know if you have any questions.</p>
                    <p>Best regards,<br>[Salesperson Name]</p>
                </div>',
            ],
            [
                'name' => 'Book Dream Car SMS',
                'subject' => '',
                'type' => 'text',
                'body' => 'Hi [Customer Name], ready to book your dream car? Schedule a test drive today! Reply STOP to opt out.',
            ],
            [
                'name' => 'Follow Up SMS',
                'subject' => '',
                'type' => 'text',
                'body' => 'Hi [Customer Name], just following up on your inquiry. Any questions? Reply STOP to opt out.',
            ],
        ];

        foreach ($templates as $template) {
            Template::create($template + ['is_active' => true]);
        }

        // Create sample sequences
        $sequences = [
            [
                'title' => 'Test Campaign',
                'is_active' => false,
                'created_by' => 1,
                'sent_count' => 2,
                'delivered_count' => 2,
                'opened_count' => 1,
                'appointments_count' => 1,
                'criteria_groups' => [
                    [
                        'logic_type' => 'AND',
                        'criteria' => [
                            ['field_name' => 'salestatus', 'operator' => 'is', 'values' => ['Uncontacted']],
                            ['field_name' => 'createddate', 'operator' => 'is_within_the_last', 'values' => ['30', 'days']],
                        ]
                    ]
                ],
                'actions' => [
                    [
                        'action_type' => 'email',
                        'delay_value' => 0,
                        'delay_unit' => 'days',
                        'parameters' => ['template' => '1', 'from_address' => 'assigned_to', 'fallback' => '1'],
                    ],
                    [
                        'action_type' => 'task',
                        'delay_value' => 1,
                        'delay_unit' => 'days',
                        'parameters' => ['task_type' => 'Outbound Call', 'assigned_to' => 'assigned_to', 'fallback' => '1', 'description' => 'Follow up call'],
                    ],
                ]
            ],
            [
                'title' => '1st Year Anniversary',
                'is_active' => true,
                'created_by' => 1,
                'sent_count' => 12,
                'delivered_count' => 11,
                'invalid_count' => 1,
                'casl_restricted_count' => 2,
                'appointments_count' => 1,
                'criteria_groups' => [
                    [
                        'logic_type' => 'AND',
                        'criteria' => [
                            ['field_name' => 'solddate', 'operator' => 'is_within_the_last', 'values' => ['365', 'days']],
                            ['field_name' => 'salestatus', 'operator' => 'is', 'values' => ['Sold']],
                        ]
                    ],
                    [
                        'logic_type' => 'OR',
                        'criteria' => [
                            ['field_name' => 'email', 'operator' => 'is_not_blank', 'values' => []],
                            ['field_name' => 'cellphone', 'operator' => 'is_not_blank', 'values' => []],
                        ]
                    ]
                ],
                'actions' => [
                    [
                        'action_type' => 'email',
                        'delay_value' => 0,
                        'delay_unit' => 'days',
                        'parameters' => ['template' => '2', 'from_address' => 'assigned_to', 'fallback' => '1'],
                    ],
                    [
                        'action_type' => 'text',
                        'delay_value' => 1,
                        'delay_unit' => 'days',
                        'parameters' => ['template' => '4', 'from_address' => 'assigned_to', 'fallback' => '1'],
                    ],
                    [
                        'action_type' => 'task',
                        'delay_value' => 3,
                        'delay_unit' => 'days',
                        'parameters' => ['task_type' => 'Outbound Call', 'assigned_to' => 'assigned_to', 'fallback' => '1', 'description' => 'Anniversary follow-up call'],
                    ],
                ]
            ],
        ];

        foreach ($sequences as $sequenceData) {
            $criteriaGroups = $sequenceData['criteria_groups'];
            $actions = $sequenceData['actions'];
            unset($sequenceData['criteria_groups'], $sequenceData['actions']);

            $sequence = SmartSequence::create($sequenceData);

            foreach ($criteriaGroups as $groupIndex => $groupData) {
                $criteria = $groupData['criteria'];
                unset($groupData['criteria']);
                
                $group = $sequence->criteriaGroups()->create([
                    'logic_type' => $groupData['logic_type'],
                    'sort_order' => $groupIndex,
                ]);

                foreach ($criteria as $criteriaIndex => $criterionData) {
                    $group->criteria()->create([
                        'field_name' => $criterionData['field_name'],
                        'field_type' => SequenceCriteria::getFieldType($criterionData['field_name']),
                        'operator' => $criterionData['operator'],
                        'values' => $criterionData['values'],
                        'sort_order' => $criteriaIndex,
                    ]);
                }
            }

            foreach ($actions as $actionIndex => $actionData) {
                $action = $sequence->actions()->create([
                    'action_type' => $actionData['action_type'],
                    'delay_value' => $actionData['delay_value'],
                    'delay_unit' => $actionData['delay_unit'],
                    'parameters' => $actionData['parameters'],
                    'sort_order' => $actionIndex,
                ]);
                $action->validate();
                $action->save();
            }
        }
    }
}