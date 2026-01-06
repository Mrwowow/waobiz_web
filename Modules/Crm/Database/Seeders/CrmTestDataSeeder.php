<?php

namespace Modules\Crm\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\Crm\Entities\CrmSource;
use Modules\Crm\Entities\CrmLifeStage;
use Modules\Crm\Entities\CrmLead;
use Modules\Crm\Entities\CrmSchedule;
use Modules\Crm\Entities\CrmProposalTemplate;
use Modules\Crm\Entities\CrmProposal;

class CrmTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get first business and user
        $business = DB::table('business')->first();
        $user = DB::table('users')->first();

        if (!$business || !$user) {
            $this->command->info('No business or user found. Please create a business and user first.');
            return;
        }

        $business_id = $business->id;
        $user_id = $user->id;

        $this->command->info('Creating CRM test data for business: ' . $business->name);

        // Create Sources
        $this->command->info('Creating sources...');
        $sources = $this->createSources($business_id, $user_id);

        // Create Life Stages
        $this->command->info('Creating life stages...');
        $lifeStages = $this->createLifeStages($business_id, $user_id);

        // Create Leads
        $this->command->info('Creating leads...');
        $leads = $this->createLeads($business_id, $user_id, $sources, $lifeStages);

        // Create Proposal Templates
        $this->command->info('Creating proposal templates...');
        $templates = $this->createProposalTemplates($business_id, $user_id);

        // Create Proposals
        $this->command->info('Creating proposals...');
        $this->createProposals($business_id, $user_id, $leads, $templates);

        // Create Schedules/Follow-ups
        $this->command->info('Creating schedules/follow-ups...');
        $this->createSchedules($business_id, $user_id, $leads);

        $this->command->info('CRM test data created successfully!');
    }

    /**
     * Create sample sources
     */
    private function createSources($business_id, $user_id)
    {
        $sourcesData = [
            ['name' => 'Website', 'sort_order' => 1],
            ['name' => 'Referral', 'sort_order' => 2],
            ['name' => 'Social Media', 'sort_order' => 3],
            ['name' => 'Cold Call', 'sort_order' => 4],
            ['name' => 'Trade Show', 'sort_order' => 5],
            ['name' => 'Email Campaign', 'sort_order' => 6],
            ['name' => 'Google Ads', 'sort_order' => 7],
            ['name' => 'Facebook Ads', 'sort_order' => 8],
        ];

        $sources = [];
        foreach ($sourcesData as $data) {
            $sources[] = CrmSource::firstOrCreate(
                ['business_id' => $business_id, 'name' => $data['name']],
                [
                    'sort_order' => $data['sort_order'],
                    'is_active' => true,
                    'created_by' => $user_id,
                ]
            );
        }

        return $sources;
    }

    /**
     * Create sample life stages
     */
    private function createLifeStages($business_id, $user_id)
    {
        $stagesData = [
            ['name' => 'New', 'color' => '#3B82F6', 'sort_order' => 1],
            ['name' => 'Contacted', 'color' => '#F59E0B', 'sort_order' => 2],
            ['name' => 'Qualified', 'color' => '#8B5CF6', 'sort_order' => 3],
            ['name' => 'Proposal Sent', 'color' => '#EC4899', 'sort_order' => 4],
            ['name' => 'Negotiation', 'color' => '#F97316', 'sort_order' => 5],
            ['name' => 'Won', 'color' => '#22C55E', 'sort_order' => 6],
            ['name' => 'Lost', 'color' => '#EF4444', 'sort_order' => 7],
        ];

        $stages = [];
        foreach ($stagesData as $data) {
            $stages[] = CrmLifeStage::firstOrCreate(
                ['business_id' => $business_id, 'name' => $data['name']],
                [
                    'color' => $data['color'],
                    'sort_order' => $data['sort_order'],
                    'is_active' => true,
                    'created_by' => $user_id,
                ]
            );
        }

        return $stages;
    }

    /**
     * Create sample leads
     */
    private function createLeads($business_id, $user_id, $sources, $lifeStages)
    {
        $leadsData = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'mobile' => '+1 555-0101',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'zip_code' => '10001',
                'address' => '123 Broadway Ave',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@example.com',
                'mobile' => '+1 555-0102',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'country' => 'USA',
                'zip_code' => '90001',
                'address' => '456 Sunset Blvd',
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.b@example.com',
                'mobile' => '+1 555-0103',
                'city' => 'Chicago',
                'state' => 'IL',
                'country' => 'USA',
                'zip_code' => '60601',
                'address' => '789 Michigan Ave',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.d@example.com',
                'mobile' => '+1 555-0104',
                'city' => 'Houston',
                'state' => 'TX',
                'country' => 'USA',
                'zip_code' => '77001',
                'address' => '321 Main St',
            ],
            [
                'name' => 'Robert Wilson',
                'email' => 'robert.w@example.com',
                'mobile' => '+1 555-0105',
                'city' => 'Phoenix',
                'state' => 'AZ',
                'country' => 'USA',
                'zip_code' => '85001',
                'address' => '654 Desert Rd',
            ],
            [
                'name' => 'Jennifer Taylor',
                'email' => 'jennifer.t@example.com',
                'mobile' => '+1 555-0106',
                'city' => 'Philadelphia',
                'state' => 'PA',
                'country' => 'USA',
                'zip_code' => '19101',
                'address' => '987 Liberty St',
            ],
            [
                'name' => 'David Martinez',
                'email' => 'david.m@example.com',
                'mobile' => '+1 555-0107',
                'city' => 'San Antonio',
                'state' => 'TX',
                'country' => 'USA',
                'zip_code' => '78201',
                'address' => '147 River Walk',
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.a@example.com',
                'mobile' => '+1 555-0108',
                'city' => 'San Diego',
                'state' => 'CA',
                'country' => 'USA',
                'zip_code' => '92101',
                'address' => '258 Pacific Hwy',
            ],
            [
                'name' => 'James Thomas',
                'email' => 'james.t@example.com',
                'mobile' => '+1 555-0109',
                'city' => 'Dallas',
                'state' => 'TX',
                'country' => 'USA',
                'zip_code' => '75201',
                'address' => '369 Commerce St',
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.g@example.com',
                'mobile' => '+1 555-0110',
                'city' => 'San Jose',
                'state' => 'CA',
                'country' => 'USA',
                'zip_code' => '95101',
                'address' => '741 Tech Blvd',
            ],
            [
                'name' => 'William Lee',
                'email' => 'william.l@example.com',
                'mobile' => '+1 555-0111',
                'city' => 'Austin',
                'state' => 'TX',
                'country' => 'USA',
                'zip_code' => '78701',
                'address' => '852 Congress Ave',
            ],
            [
                'name' => 'Amanda White',
                'email' => 'amanda.w@example.com',
                'mobile' => '+1 555-0112',
                'city' => 'Jacksonville',
                'state' => 'FL',
                'country' => 'USA',
                'zip_code' => '32099',
                'address' => '963 Beach Rd',
            ],
        ];

        $leads = [];
        $sourceCount = count($sources);
        $stageCount = count($lifeStages);

        foreach ($leadsData as $index => $data) {
            $lead = CrmLead::firstOrCreate(
                ['business_id' => $business_id, 'email' => $data['email']],
                array_merge($data, [
                    'source_id' => $sources[$index % $sourceCount]->id,
                    'life_stage_id' => $lifeStages[$index % $stageCount]->id,
                    'assigned_to' => $user_id,
                    'created_by' => $user_id,
                    'contact_id_prefix' => 'LEAD-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                ])
            );
            $leads[] = $lead;
        }

        // Mark some leads as converted
        if (isset($leads[5])) {
            $leads[5]->update([
                'converted_at' => Carbon::now()->subDays(5),
                'converted_by' => $user_id,
            ]);
        }
        if (isset($leads[9])) {
            $leads[9]->update([
                'converted_at' => Carbon::now()->subDays(2),
                'converted_by' => $user_id,
            ]);
        }

        return $leads;
    }

    /**
     * Create proposal templates
     */
    private function createProposalTemplates($business_id, $user_id)
    {
        $templatesData = [
            [
                'name' => 'Standard Business Proposal',
                'subject' => 'Business Proposal for {{lead_name}}',
                'body' => '<h2>Business Proposal</h2>
<p>Dear {{lead_name}},</p>
<p>Thank you for your interest in our services. We are pleased to present this proposal for your consideration.</p>
<h3>Executive Summary</h3>
<p>We understand your business needs and are confident that our solutions can help you achieve your goals.</p>
<h3>Proposed Solution</h3>
<p>Our comprehensive solution includes:</p>
<ul>
<li>Professional consultation</li>
<li>Custom implementation</li>
<li>Ongoing support</li>
</ul>
<h3>Investment</h3>
<p>Please review the attached pricing details.</p>
<p>We look forward to working with you.</p>
<p>Best regards,<br>{{business_name}}</p>',
            ],
            [
                'name' => 'Service Agreement',
                'subject' => 'Service Agreement Proposal - {{lead_name}}',
                'body' => '<h2>Service Agreement Proposal</h2>
<p>Dear {{lead_name}},</p>
<p>Following our recent discussion, please find below our service agreement proposal.</p>
<h3>Scope of Services</h3>
<p>We will provide the following services:</p>
<ol>
<li>Initial assessment and planning</li>
<li>Implementation and deployment</li>
<li>Training and documentation</li>
<li>Maintenance and support</li>
</ol>
<h3>Terms and Conditions</h3>
<p>The agreement is subject to our standard terms and conditions.</p>
<p>Please contact us if you have any questions.</p>
<p>Sincerely,<br>{{business_name}}</p>',
            ],
            [
                'name' => 'Quick Quote',
                'subject' => 'Price Quote for {{lead_name}}',
                'body' => '<h2>Price Quote</h2>
<p>Dear {{lead_name}},</p>
<p>As requested, here is your price quote:</p>
<table style="width: 100%; border-collapse: collapse;">
<tr style="background: #f3f4f6;">
<th style="padding: 10px; border: 1px solid #ddd;">Item</th>
<th style="padding: 10px; border: 1px solid #ddd;">Price</th>
</tr>
<tr>
<td style="padding: 10px; border: 1px solid #ddd;">[Item description]</td>
<td style="padding: 10px; border: 1px solid #ddd;">[Price]</td>
</tr>
</table>
<p>This quote is valid for 30 days.</p>
<p>Thank you for your business!</p>
<p>{{business_name}}</p>',
            ],
        ];

        $templates = [];
        foreach ($templatesData as $data) {
            $templates[] = CrmProposalTemplate::firstOrCreate(
                ['business_id' => $business_id, 'name' => $data['name']],
                [
                    'subject' => $data['subject'],
                    'body' => $data['body'],
                    'is_active' => true,
                    'created_by' => $user_id,
                ]
            );
        }

        return $templates;
    }

    /**
     * Create sample proposals
     */
    private function createProposals($business_id, $user_id, $leads, $templates)
    {
        $statuses = ['draft', 'sent', 'viewed', 'accepted', 'rejected'];
        $templateCount = count($templates);

        foreach (array_slice($leads, 0, 8) as $index => $lead) {
            $template = $templates[$index % $templateCount];
            $status = $statuses[$index % count($statuses)];

            $proposal = CrmProposal::firstOrCreate(
                ['business_id' => $business_id, 'lead_id' => $lead->id, 'subject' => str_replace('{{lead_name}}', $lead->name, $template->subject)],
                [
                    'template_id' => $template->id,
                    'body' => str_replace(['{{lead_name}}', '{{business_name}}'], [$lead->name, 'WaoBiz'], $template->body),
                    'status' => $status,
                    'sent_at' => in_array($status, ['sent', 'viewed', 'accepted', 'rejected']) ? Carbon::now()->subDays(rand(1, 10)) : null,
                    'viewed_at' => in_array($status, ['viewed', 'accepted', 'rejected']) ? Carbon::now()->subDays(rand(1, 5)) : null,
                    'responded_at' => in_array($status, ['accepted', 'rejected']) ? Carbon::now()->subDays(rand(1, 3)) : null,
                    'created_by' => $user_id,
                ]
            );
        }
    }

    /**
     * Create sample schedules/follow-ups
     */
    private function createSchedules($business_id, $user_id, $leads)
    {
        $followupTypes = ['call', 'email', 'meeting', 'sms', 'other'];
        $statuses = ['scheduled', 'open', 'completed', 'cancelled'];
        $categories = ['one_time', 'recurring', 'invoice_based'];

        $schedulesData = [
            ['title' => 'Initial Contact Call', 'description' => 'First contact with lead to understand requirements.'],
            ['title' => 'Follow-up Email', 'description' => 'Send follow-up email with more information.'],
            ['title' => 'Product Demo Meeting', 'description' => 'Schedule product demonstration meeting.'],
            ['title' => 'Proposal Discussion', 'description' => 'Discuss proposal details and answer questions.'],
            ['title' => 'Contract Negotiation', 'description' => 'Negotiate contract terms and conditions.'],
            ['title' => 'Check-in Call', 'description' => 'Regular check-in to maintain relationship.'],
            ['title' => 'Send Quotation', 'description' => 'Prepare and send pricing quotation.'],
            ['title' => 'Technical Consultation', 'description' => 'Technical discussion about implementation.'],
            ['title' => 'Closing Call', 'description' => 'Final call to close the deal.'],
            ['title' => 'Onboarding Meeting', 'description' => 'Schedule onboarding for new customer.'],
        ];

        foreach ($leads as $leadIndex => $lead) {
            // Create 2-3 schedules per lead
            $numSchedules = rand(2, 3);
            for ($i = 0; $i < $numSchedules; $i++) {
                $scheduleData = $schedulesData[($leadIndex + $i) % count($schedulesData)];
                $status = $statuses[array_rand($statuses)];
                $startDate = Carbon::now()->addDays(rand(-10, 20))->setHour(rand(9, 17))->setMinute(0);

                CrmSchedule::firstOrCreate(
                    [
                        'business_id' => $business_id,
                        'lead_id' => $lead->id,
                        'title' => $scheduleData['title'] . ' - ' . $lead->name,
                    ],
                    [
                        'contact_type' => 'lead',
                        'status' => $status,
                        'start_datetime' => $startDate,
                        'end_datetime' => $startDate->copy()->addHour(),
                        'description' => $scheduleData['description'],
                        'followup_type' => $followupTypes[array_rand($followupTypes)],
                        'assigned_to' => $user_id,
                        'send_notification' => rand(0, 1),
                        'followup_category' => $categories[array_rand($categories)],
                        'created_by' => $user_id,
                    ]
                );
            }
        }

        // Create some schedules with overdue status (past dates, not completed)
        foreach (array_slice($leads, 0, 3) as $lead) {
            CrmSchedule::firstOrCreate(
                [
                    'business_id' => $business_id,
                    'lead_id' => $lead->id,
                    'title' => 'Overdue Follow-up - ' . $lead->name,
                ],
                [
                    'contact_type' => 'lead',
                    'status' => 'open',
                    'start_datetime' => Carbon::now()->subDays(rand(3, 7))->setHour(10),
                    'end_datetime' => Carbon::now()->subDays(rand(3, 7))->setHour(11),
                    'description' => 'This follow-up is overdue and needs attention.',
                    'followup_type' => 'call',
                    'assigned_to' => $user_id,
                    'send_notification' => true,
                    'followup_category' => 'one_time',
                    'created_by' => $user_id,
                ]
            );
        }
    }
}
