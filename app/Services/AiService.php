<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    protected array $faq = [
        'estimate' => 'Emberwick provides free on-site fireplace consultations across the Denver metro and Front Range. Most visits take 45–60 minutes. Call (303) 555-0194 or use the contact form to book.',
        'gas' => 'Gas fireplace inserts and direct-vent units typically install in 1–2 days once the unit and venting path are approved. We handle gas-line coordination with licensed plumbers when needed.',
        'wood' => 'Wood-burning fireplace installs need hearth clearance, chimney or flue planning, and code-compliant clearances. Expect a multi-day schedule for chase framing, firebox set, and finish surrounds.',
        'electric' => 'Electric fireplaces and wall-mount units are often same-day or next-day installs with dedicated circuits. Great for apartments and rooms without existing chimneys.',
        'warranty' => 'Emberwick warrants installation labor for 2 years. Manufacturer warranties on fireboxes, inserts, and glass remain in force when installed per spec.',
        'vent' => 'Proper venting is non-negotiable. We size direct-vent, B-vent, or chimney liners to the appliance listing and Colorado altitude derating guidance.',
        'cost' => 'Typical Denver-area installs start around $2,800 for electric wall units, $6,500–$14,000 for gas inserts, and $12,000+ for custom masonry or built-in surrounds. Exact quotes follow a site visit.',
        'permit' => 'Most gas and structural fireplace projects require city/county permits. Emberwick manages permit packages for Denver, Boulder, Aurora, and nearby jurisdictions.',
        'schedule' => 'Peak season is fall through early winter. Book 3–6 weeks ahead for gas inserts; custom surrounds may need 6–10 weeks for materials.',
        'payment' => 'We accept card, ACH, and check. A deposit holds your install slot; balance is due on completion and final walkthrough.',
        'mantel' => 'Custom mantels, stone surrounds, and tile finishes are scoped after the firebox is selected so clearances and proportions stay code-clean.',
        'safety' => 'We check carbon monoxide detector placement, glass temperature ratings, and hearth extensions. Never operate a new gas unit until final inspection clears.',
    ];

    public function chat(string $message, string $context = 'public'): string
    {
        $message = trim($message);
        if ($message === '') {
            return 'Ask us anything about fireplace installation, gas inserts, venting, permits, or scheduling.';
        }

        if ($reply = $this->callProvider($message, $context)) {
            return $reply;
        }

        return $this->demoReply($message, $context);
    }

    public function generateContent(string $prompt, string $type = 'blog'): string
    {
        $system = match ($type) {
            'service' => 'Write a concise fireplace installation service description for Emberwick Hearth Co. in Denver, CO.',
            'automation' => 'Suggest practical ERP automation ideas for a fireplace installation company.',
            'troubleshoot' => 'Help a fireplace company admin troubleshoot operations, scheduling, inventory, or permit delays.',
            default => 'Write helpful blog content for homeowners about fireplace selection and installation.',
        };

        if ($reply = $this->callProvider($prompt, $type, $system)) {
            return $reply;
        }

        return $this->demoContent($prompt, $type);
    }

    protected function callProvider(string $message, string $context, ?string $system = null): ?string
    {
        $system ??= 'You are the helpful assistant for Emberwick Hearth Co., a Denver Colorado fireplace installation company. Be concise, practical, and friendly. Never invent fake certifications or ignore venting/code safety.';

        $openaiKey = config('services.openai.key') ?: env('OPENAI_API_KEY');
        if ($openaiKey) {
            try {
                $response = Http::withToken($openaiKey)
                    ->timeout(25)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                        'messages' => [
                            ['role' => 'system', 'content' => $system],
                            ['role' => 'user', 'content' => $message],
                        ],
                        'temperature' => 0.5,
                    ]);

                if ($response->successful()) {
                    return trim((string) data_get($response->json(), 'choices.0.message.content'));
                }
            } catch (\Throwable) {
                // fall through
            }
        }

        $geminiKey = config('services.gemini.key') ?: env('GEMINI_API_KEY');
        if ($geminiKey) {
            try {
                $response = Http::timeout(25)
                    ->post('https://generativelanguage.googleapis.com/v1beta/models/'.env('GEMINI_MODEL', 'gemini-1.5-flash').':generateContent?key='.$geminiKey, [
                        'contents' => [
                            ['parts' => [['text' => $system."\n\nUser: ".$message]]],
                        ],
                    ]);

                if ($response->successful()) {
                    return trim((string) data_get($response->json(), 'candidates.0.content.parts.0.text'));
                }
            } catch (\Throwable) {
                // fall through
            }
        }

        return null;
    }

    protected function demoReply(string $message, string $context): string
    {
        $lower = Str::lower($message);

        foreach ($this->faq as $key => $answer) {
            if (Str::contains($lower, $key) || Str::contains($lower, Str::plural($key))) {
                return $answer.' (Demo FAQ mode — add OPENAI_API_KEY or GEMINI_API_KEY for live AI.)';
            }
        }

        if (Str::contains($lower, ['price', 'cost', 'how much', 'quote'])) {
            return $this->faq['cost'].' (Demo FAQ mode.)';
        }

        if (Str::contains($lower, ['book', 'appoint', 'when', 'avail'])) {
            return $this->faq['schedule'].' (Demo FAQ mode.)';
        }

        if (Str::contains($lower, ['insert', 'direct vent', 'chimney', 'liner'])) {
            return $this->faq['vent'].' (Demo FAQ mode.)';
        }

        if ($context === 'troubleshoot') {
            return 'Check permit status, appliance SKU vs vent kit compatibility, and gas-line schedule first. Confirm hearth product stock and inspection appointment before rescheduling crews. (Demo mode.)';
        }

        return 'Thanks for reaching out to Emberwick Hearth Co. We install gas, wood, and electric fireplaces across Denver and the Front Range. Ask about estimates, venting, permits, mantels, or scheduling — or call (303) 555-0194. (Demo FAQ mode.)';
    }

    protected function demoContent(string $prompt, string $type): string
    {
        return match ($type) {
            'service' => "## Crafted for {$prompt}\n\nEmberwick crews size the firebox, plan venting for Front Range altitude, protect floors, and finish surrounds that match your architecture. Expect clear timelines, daily updates, and a final safety walkthrough.",
            'automation' => "1. Auto-create estimate appointments from web leads.\n2. Low-stock alerts for vent kits and hearth pads.\n3. Permit-status reminders before install day.\n4. Invoice draft when job status hits completed.\n5. CO-detector follow-up SMS 7 days after closeout.\n\nPrompt: {$prompt}",
            'troubleshoot' => "Likely causes for \"{$prompt}\": vent kit mismatch, pending permit, missing gas-line coordination, or unpaid deposit blocking schedule lock. Verify the job record, inventory pulls, and inspection status before reassigning crews.",
            default => "# {$prompt}\n\nHomeowners often choose the firebox before measuring clearances. Emberwick starts with room geometry, vent path, and fuel type — then finishes with mantel and surround details that stay code-clean at Denver altitude.\n\n(Demo generator — configure API keys for live content.)",
        };
    }
}
