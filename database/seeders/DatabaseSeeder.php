<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\KbArticle;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Emberwick Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '(303) 555-0194',
            ]
        );
        $admin->syncRoles(['admin']);

        $manager = User::query()->updateOrCreate(
            ['email' => 'manager@emberwick.example'],
            [
                'name' => 'Riley Quinn',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(303) 555-0196',
            ]
        );
        $manager->syncRoles(['manager']);

        $staff = User::query()->updateOrCreate(
            ['email' => 'crew@emberwick.example'],
            [
                'name' => 'Diego Morales',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(303) 555-0198',
            ]
        );
        $staff->syncRoles(['staff']);

        $settings = [
            'company_name' => 'Emberwick Hearth Co.',
            'phone' => '(303) 555-0194',
            'email' => 'hello@emberwickhearth.example',
            'address' => '1840 Blake Street, Suite 210, Denver, CO 80202',
            'whatsapp' => '+13035550194',
            'service_area' => 'Denver, Boulder, Aurora, Littleton, Lakewood, Highlands Ranch',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $services = [
            [
                'name' => 'Gas Fireplace Insert Installation',
                'slug' => 'gas-fireplace-insert',
                'tagline' => 'Efficient heat with clean direct-venting',
                'summary' => 'Insert upgrades for existing fireboxes with altitude-aware BTU sizing and glass safety.',
                'description' => "We measure the existing opening, select a listed insert for Front Range elevation, and plan the vent path before ordering.\nGas-line coordination and permit packages are included for most Denver metro jurisdictions.\nTypical schedule: 1–2 install days after materials arrive.",
                'image_url' => 'https://images.unsplash.com/photo-1600489000022-c2086d91f4cd?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 6500,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Wood-Burning Fireplace Build',
                'slug' => 'wood-burning-fireplace',
                'tagline' => 'Masonry-ready fireboxes with proper clearances',
                'summary' => 'New wood fireplaces with hearth extensions, flue planning, and surround finishes.',
                'description' => "Wood systems need disciplined clearances and chimney design. Emberwick frames chases, sets listed fireboxes, and finishes surrounds to your architecture.\nIdeal for mountain-modern and craftsman homes along the Front Range.",
                'image_url' => 'https://images.unsplash.com/photo-1478144592103-22e98f1a84db?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 12000,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Electric Fireplace Accent Wall',
                'slug' => 'electric-fireplace-wall',
                'tagline' => 'No chimney required — same-week warmth',
                'summary' => 'Wall-mount and built-in electric units with dedicated circuits and media walls.',
                'description' => "Perfect for condos and rooms without flues. We coordinate electrical, build floating mantels or full media walls, and leave a tidy finish.\nOften completed in a single day once the circuit is ready.",
                'image_url' => 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 2800,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Custom Mantel & Surround',
                'slug' => 'mantel-surround',
                'tagline' => 'Stone, tile, and timber that frame the flame',
                'summary' => 'Design-forward mantels and non-combustible surrounds matched to your firebox listing.',
                'description' => "Clearances drive design. We draft surround elevations, select stone or porcelain, and install after the appliance is set.\nIncludes hearth pad extensions when code requires.",
                'image_url' => 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cd00?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 3200,
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Chimney Liner & Vent Retrofit',
                'slug' => 'chimney-liner-vent',
                'tagline' => 'Safe draft for inserts and wood stoves',
                'summary' => 'Stainless liners, termination caps, and direct-vent retrofits for aging chimneys.',
                'description' => "Aging clay flues often fail modern insert listings. We camera-inspect, size liners, and document draft performance before sign-off.",
                'image_url' => 'https://images.unsplash.com/photo-1541123603104-512919d6a492?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 2100,
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'Fireplace Design Consultation',
                'slug' => 'fireplace-design-consult',
                'tagline' => 'Fuel type, BTU, and style locked before order',
                'summary' => 'On-site consult covering fuel options, vent paths, and surround aesthetics.',
                'description' => "Bring inspiration photos or start fresh. We leave a written scope covering appliance shortlist, permit needs, and budget bands.",
                'image_url' => 'https://images.unsplash.com/photo-1600585152915-d208bec867a1?auto=format&fit=crop&w=1200&q=80',
                'base_price' => 195,
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(['slug' => $service['slug']], $service);
        }

        $products = [
            ['name' => 'Direct-Vent Gas Insert 30in', 'sku' => 'INS-GAS-30', 'category' => 'Inserts', 'unit_cost' => 2100, 'unit_price' => 3450, 'stock_qty' => 6, 'unit' => 'each', 'reorder_level' => 2],
            ['name' => 'Electric Wall Fireplace 50in', 'sku' => 'INS-ELC-50', 'category' => 'Electric', 'unit_cost' => 680, 'unit_price' => 1190, 'stock_qty' => 10, 'unit' => 'each', 'reorder_level' => 3],
            ['name' => 'Stainless Chimney Liner 6in Kit', 'sku' => 'VNT-LNR-6', 'category' => 'Venting', 'unit_cost' => 420, 'unit_price' => 780, 'stock_qty' => 8, 'unit' => 'kit', 'reorder_level' => 2],
            ['name' => 'Non-Combustible Hearth Pad 48x16', 'sku' => 'HRP-4816', 'category' => 'Hearth', 'unit_cost' => 95, 'unit_price' => 185, 'stock_qty' => 14, 'unit' => 'each', 'reorder_level' => 4],
            ['name' => 'High-Temp Silicone Sealant', 'sku' => 'SEL-HT-10', 'category' => 'Sealant', 'unit_cost' => 8.5, 'unit_price' => 18, 'stock_qty' => 48, 'unit' => 'tube', 'reorder_level' => 12],
            ['name' => 'Mantel Bracket Heavy Duty Pair', 'sku' => 'MNT-BRK-HD', 'category' => 'Hardware', 'unit_cost' => 22, 'unit_price' => 48, 'stock_qty' => 30, 'unit' => 'pair', 'reorder_level' => 8],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product);
        }

        $customers = [
            ['name' => 'Hannah Ortiz', 'email' => 'hannah.ortiz@example.com', 'phone' => '(303) 555-3301', 'address' => '922 Pearl St', 'city' => 'Denver', 'state' => 'CO', 'zip' => '80203'],
            ['name' => 'Noah Patel', 'email' => 'noah.patel@example.com', 'phone' => '(303) 555-3308', 'address' => '410 Aspen Grove Ln', 'city' => 'Boulder', 'state' => 'CO', 'zip' => '80302'],
            ['name' => 'Grace Kim', 'email' => 'grace.kim@example.com', 'phone' => '(720) 555-3315', 'address' => '77 Red Rocks Ave', 'city' => 'Littleton', 'state' => 'CO', 'zip' => '80120'],
            ['name' => 'The Alvarez Family', 'email' => 'alvarez.home@example.com', 'phone' => '(720) 555-3320', 'address' => '1550 Summit Ridge Ct', 'city' => 'Highlands Ranch', 'state' => 'CO', 'zip' => '80126'],
        ];
        $customerModels = [];
        foreach ($customers as $customer) {
            $customerModels[] = Customer::query()->updateOrCreate(['email' => $customer['email']], $customer);
        }

        $gas = Service::query()->where('slug', 'gas-fireplace-insert')->first();
        $electric = Service::query()->where('slug', 'electric-fireplace-wall')->first();

        $jobs = [
            [
                'job_number' => 'EW-2401',
                'customer_id' => $customerModels[0]->id,
                'service_id' => $gas?->id,
                'assigned_to' => $staff->id,
                'title' => 'Ortiz gas insert + slate surround',
                'status' => 'completed',
                'priority' => 'normal',
                'property_address' => '922 Pearl St, Denver',
                'scheduled_start' => now()->subDays(22)->toDateString(),
                'scheduled_end' => now()->subDays(20)->toDateString(),
                'estimated_amount' => 8900,
                'final_amount' => 9200,
            ],
            [
                'job_number' => 'EW-2408',
                'customer_id' => $customerModels[1]->id,
                'service_id' => $gas?->id,
                'assigned_to' => $staff->id,
                'title' => 'Patel living room direct-vent insert',
                'status' => 'in_progress',
                'priority' => 'high',
                'property_address' => '410 Aspen Grove Ln, Boulder',
                'scheduled_start' => now()->subDays(1)->toDateString(),
                'scheduled_end' => now()->addDays(2)->toDateString(),
                'estimated_amount' => 11200,
                'final_amount' => null,
            ],
            [
                'job_number' => 'EW-2412',
                'customer_id' => $customerModels[2]->id,
                'service_id' => $electric?->id,
                'assigned_to' => $manager->id,
                'title' => 'Kim electric media wall fireplace',
                'status' => 'scheduled',
                'priority' => 'normal',
                'property_address' => '77 Red Rocks Ave, Littleton',
                'scheduled_start' => now()->addDays(6)->toDateString(),
                'scheduled_end' => now()->addDays(6)->toDateString(),
                'estimated_amount' => 4100,
                'final_amount' => null,
            ],
        ];

        $jobModels = [];
        foreach ($jobs as $job) {
            $jobModels[] = Job::query()->updateOrCreate(['job_number' => $job['job_number']], $job);
        }

        $invoice = Invoice::query()->updateOrCreate(
            ['invoice_number' => 'INV-2401'],
            [
                'customer_id' => $customerModels[0]->id,
                'job_id' => $jobModels[0]->id,
                'issue_date' => now()->subDays(18)->toDateString(),
                'due_date' => now()->subDays(4)->toDateString(),
                'status' => 'paid',
                'subtotal' => 9200,
                'tax' => 736,
                'total' => 9936,
                'amount_paid' => 9936,
                'notes' => 'Thank you for choosing Emberwick.',
            ]
        );

        Payment::query()->updateOrCreate(
            ['reference' => 'ACH-55201'],
            [
                'invoice_id' => $invoice->id,
                'amount' => 9936,
                'paid_at' => now()->subDays(12)->toDateString(),
                'method' => 'ach',
                'notes' => 'Final payment',
            ]
        );

        Invoice::query()->updateOrCreate(
            ['invoice_number' => 'INV-2408'],
            [
                'customer_id' => $customerModels[1]->id,
                'job_id' => $jobModels[1]->id,
                'issue_date' => now()->subDay()->toDateString(),
                'due_date' => now()->addDays(14)->toDateString(),
                'status' => 'sent',
                'subtotal' => 3500,
                'tax' => 280,
                'total' => 3780,
                'amount_paid' => 1500,
                'notes' => 'Deposit invoice for gas insert project',
            ]
        );

        Appointment::query()->updateOrCreate(
            ['title' => 'Kim design consult'],
            [
                'customer_id' => $customerModels[2]->id,
                'job_id' => $jobModels[2]->id,
                'assigned_to' => $manager->id,
                'type' => 'estimate',
                'status' => 'confirmed',
                'starts_at' => now()->addDays(2)->setTime(10, 0),
                'ends_at' => now()->addDays(2)->setTime(11, 0),
                'location' => '77 Red Rocks Ave, Littleton',
            ]
        );

        Appointment::query()->updateOrCreate(
            ['title' => 'Patel mid-install walkthrough'],
            [
                'customer_id' => $customerModels[1]->id,
                'job_id' => $jobModels[1]->id,
                'assigned_to' => $staff->id,
                'type' => 'walkthrough',
                'status' => 'scheduled',
                'starts_at' => now()->addDay()->setTime(15, 0),
                'ends_at' => now()->addDay()->setTime(15, 45),
                'location' => '410 Aspen Grove Ln, Boulder',
            ]
        );

        $posts = [
            [
                'title' => 'Why Front Range altitude changes BTU choices',
                'slug' => 'front-range-altitude-btu',
                'excerpt' => 'Denver elevation derates many gas appliances. Here is how Emberwick sizes inserts correctly.',
                'body' => "At roughly 5,280 feet, many gas fireplaces need altitude kits or derated BTU ratings.\n\nChoosing a coastal-spec insert without adjustment can leave rooms underheated or trip safety sensors.\n\nEmberwick confirms manufacturer altitude guidance before ordering and documents vent termination clearances for snow and wind.",
                'cover_image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80',
                'category' => 'fuel',
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'author_id' => $admin->id,
            ],
            [
                'title' => 'Gas vs electric: choosing for Denver condos',
                'slug' => 'gas-vs-electric-denver-condos',
                'excerpt' => 'HOA rules and vent paths often decide the winner before aesthetics do.',
                'body' => "Condos frequently restrict new gas lines or exterior vent penetrations. Electric units shine when you need a media wall without structural work.\n\nIf your HOA allows direct-vent and you want real heat output, a compact gas insert may still win. We review association docs during consults.",
                'cover_image' => 'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=1200&q=80',
                'category' => 'tips',
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'author_id' => $manager->id,
            ],
            [
                'title' => 'What happens on fireplace install day',
                'slug' => 'fireplace-install-day',
                'excerpt' => 'Floor protection, appliance set, vent connect, and a final CO check — the Emberwick sequence.',
                'body' => "Morning: protect floors and stage the firebox. Midday: set the unit, connect venting, and verify listing clearances. Afternoon: surround work or temporary cover, leak checks, and walkthrough.\n\nYou should leave with operating instructions and a scheduled inspection date when permits apply.",
                'cover_image' => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1200&q=80',
                'category' => 'process',
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'author_id' => $admin->id,
            ],
        ];
        foreach ($posts as $post) {
            Post::query()->updateOrCreate(['slug' => $post['slug']], $post);
        }

        $articles = [
            [
                'title' => 'Cold drafts after a new gas insert',
                'slug' => 'cold-drafts-after-gas-insert',
                'category' => 'common-issues',
                'summary' => 'Often a missing chimney seal or oversized liner gap.',
                'body' => "1. Confirm the liner or direct-vent kit is sealed at the chase top.\n2. Check glass gasket seating.\n3. Verify the damper plate or block-off plate is installed.\n4. Recheck CO and combustion air paths.\nEmberwick documents draft readings before closeout.",
                'sort_order' => 1,
            ],
            [
                'title' => 'Step-by-step: preparing a room for install day',
                'slug' => 'prep-room-install-day',
                'category' => 'guides',
                'summary' => 'What homeowners can do the night before our crew arrives.',
                'body' => "1. Clear a 6-foot path to the fireplace.\n2. Move fragile décor and rugs.\n3. Confirm pets are secured.\n4. Reserve driveway parking for the van.\n5. Keep HOA elevator reservations ready for condo builds.\nWe handle dust control, appliance unboxing, and debris haul-away.",
                'sort_order' => 2,
            ],
            [
                'title' => 'Admin manual: creating an install job in ERP',
                'slug' => 'admin-manual-create-job',
                'category' => 'admin-manual',
                'summary' => 'How staff open jobs, assign crews, and link invoices.',
                'body' => "1. Create or select the customer.\n2. Open Install Jobs → Create.\n3. Assign service type and crew.\n4. Set status to scheduled once deposit and permit notes are logged.\n5. Add appointments for consult or install days.\n6. When complete, create invoice and record payment.\nManagers can override priority; staff should not void invoices.",
                'sort_order' => 3,
            ],
            [
                'title' => 'Troubleshooting: vent kit shows out of stock mid-job',
                'slug' => 'troubleshoot-vent-kit-stock',
                'category' => 'troubleshooting',
                'summary' => 'Usually a missed receiving entry or double reservation.',
                'body' => "1. Check recent job material notes.\n2. Confirm purchase receipts were entered.\n3. Adjust stock with a counted physical inventory.\n4. Raise reorder_level if crews stage spare elbows.\nUse AI Assistants → Troubleshooting for suggested automation rules.",
                'sort_order' => 4,
            ],
            [
                'title' => 'Permit basics for Denver fireplace projects',
                'slug' => 'denver-fireplace-permits',
                'category' => 'guides',
                'summary' => 'When mechanical or building permits are typically required.',
                'body' => "Gas inserts, new chimneys, and structural surround work usually need permits. Electric wall units may only need electrical if a new circuit is added.\nEmberwick prepares drawings and appliance specs; inspection scheduling is tracked on the job record.",
                'sort_order' => 5,
            ],
            [
                'title' => 'Admin manual: AI content & chatbot modes',
                'slug' => 'admin-manual-ai-tools',
                'category' => 'admin-manual',
                'summary' => 'How demo FAQ mode and live API keys work.',
                'body' => "Public chatbot uses FAQ fallbacks when OPENAI_API_KEY and GEMINI_API_KEY are empty.\nIn /admin → AI Assistants you can generate blog drafts, service copy, automation ideas, and troubleshooting notes.\nNever paste customer secrets into prompts.",
                'sort_order' => 6,
            ],
        ];
        foreach ($articles as $article) {
            KbArticle::query()->updateOrCreate(
                ['slug' => $article['slug']],
                $article + ['is_published' => true]
            );
        }
    }
}
