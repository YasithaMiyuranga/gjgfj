<?php
namespace App\Services;

use GuzzleHttp\Client;
use App\Models\Customer;
use App\Models\AdminEvent;

class CustomerDataExtractor
{
    public function extractFromMessage($message)
    {
        // Use a local NLP model (simple patterns)
        $data = $this->extractWithPatterns($message);

        // Only call AI if we're missing crucial fields
        if (empty($data['name']) || empty($data['phone'])) {
            $aiData = $this->extractWithAI($message);

            // Merge results, favoring AI data when available
            $data = array_merge($data, array_filter($aiData));
        }
        return $data;
    }

    protected function extractWithPatterns($message)
    {
        // Implement simple regex patterns to extract data
        preg_match('/(?:name|nama)\s*[:=]?\s*([^\n\r]+)/i', $message, $nameMatches);
        preg_match('/(?:phone|mobile|tel)\s*[:=]?\s*([+\d\s\-]{8,})/i', $message, $phoneMatches);
        preg_match('/(?:Company Name|company)\s*[:=]?\s*([^\n\r]+)/i', $message, $companyMatches);
        preg_match('/(?:location|Location)\s*[:=]?\s*([^\n\r]+)/i', $message, $locationMatches);
        preg_match('/(?:address|Address)\s*[:=]?\s*([^\n\r]+)/i', $message, $addressMatches);
        preg_match('/(?:city|City)\s*[:=]?\s*([^\n\r]+)/i', $message, $cityMatches);
        preg_match('/(?:nic|Nic)\s*[:=]?\s*([^\n\r]+)/i', $message, $nicMatches);

        return [
            'name' => trim($nameMatches[1] ?? ''),
            'phone' => preg_replace('/[^0-9+]/', '', $phoneMatches[1] ?? ''),
            'company' => trim($companyMatches[1] ?? ''),
            'location' => trim($locationMatches[1] ?? ''),
            'address' => trim($addressMatches[1] ?? ''),
            'city' => trim($cityMatches[1] ?? ''),
            'nic' => trim($nicMatches[1] ?? ''),
        ];
    }

    protected function extractWithAI($message)
    {
        try {
            $client = new Client([
                'base_uri' => 'https://openrouter.ai/api/v1/',
                'timeout' => 10, // Timeout
            ]);

            $response = $client->post('chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
                    'HTTP-Referer' => config('app.url'), // Required by OpenRouter
                    'X-Title' => config('app.name'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'openai/gpt-3.5-turbo', // model name
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Extract customer details from this message. ' .
                                        'Return ONLY a JSON object with these possible fields: ' .
                                        'name, phone, company, location, address, city, nic. ' .
                                        'If a field is not found, omit it completely. '
                        ],
                        [
                            'role' => 'user',
                            'content' => $message
                        ]
                    ],
                    'temperature' => 0.3, // Lower for more deterministic results
                    'max_tokens' => 200
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);

            // Extract the content from the API response
            $content = $responseData['choices'][0]['message']['content'] ?? '{}';
            $extractedData = json_decode($content, true) ?? [];

            // Ensure we have at least one field to consider it successful
            if (empty($extractedData['name']) && empty($extractedData['phone'])) {
                throw new \Exception('AI extraction failed to find required fields');
            }

            return $extractedData;

        } catch (\Exception $e) {
            // Log the error but don't break the application
            \Log::error('AI extraction failed: ' . $e->getMessage());
            return []; // Return empty array to allow fallback to pattern matching
        }
    }
    public function extractEventFromMessage($message)
    {
        // Use a local NLP model (simple patterns)
        $data = $this->extractWithEventDataPatterns($message);

        // If NLP model fails, use AI model
        if (empty($data['name']) || empty($data['phone']  || empty($data['event_start']) || empty($data['event_end_datetime']) || empty($data['setup_date']) || empty($data['event_location']))) {
            $aiData = $this->extractWithEventAI($message);

            // Check if customer_name is find
            if( isset($aiData['customer_name']) ) {
                // Check if customer_name is include in customer table
                $customer_name = $aiData['customer_name'];
                $customer = Customer::where('customer_name', $customer_name)->first();
                if ($customer) {
                    $aiData['customer_id'] = $customer->customer_id;
                }
            }
            // Merge results, favoring AI data when available
            $data = array_merge($data, array_filter($aiData));
        }
        return $data;
    }

    public function extractWithEventDataPatterns($message)
    {
        // New patterns for event-related fields
        preg_match('/Event Name\s*[:=]?\s*([^\n\r]+)/i', $message, $eventNameMatches);
        preg_match('/Customer\s*[:=]?\s*([^\n\r]+)/i', $message, $customerMatches);
        preg_match('/Select Customer\s*[:=]?\s*([^\n\r]+)/i', $message, $selectCustomerMatches);
        preg_match('/Event Start Date\/Time\s*[:=]?\s*([^\n\r]+)/i', $message, $eventStartMatches);
        preg_match('/Event End Date\/Time\s*[:=]?\s*([^\n\r]+)/i', $message, $eventEndMatches);
        preg_match('/Setup Date\/Time\s*[:=]?\s*([^\n\r]+)/i', $message, $setupDateMatches);
        preg_match('/Event Date\s*[:=]?\s*([^\n\r]+)/i', $message, $eventDateMatches);

        return [
            'event_name' => trim($eventNameMatches[1] ?? ''),
            'customer' => trim($customerMatches[1] ?? ''),
            'select_customer' => trim($selectCustomerMatches[1] ?? ''),
            'event_start_datetime' => trim($eventStartMatches[1] ?? ''),
            'event_end_datetime' => trim($eventEndMatches[1] ?? ''),
            'setup_datetime' => trim($setupDateMatches[1] ?? ''),
            'event_date' => trim($eventDateMatches[1] ?? ''),
        ];

    }
    protected function extractWithEventAI($message)
    {
        try {
            $client = new Client([
                'base_uri' => 'https://openrouter.ai/api/v1/',
                'timeout' => 10, // Timeout
            ]);

            $response = $client->post('chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
                    'HTTP-Referer' => config('app.url'), // Required by OpenRouter
                    'X-Title' => config('app.name'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'openai/gpt-3.5-turbo', // model name
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Extract event details from this message. ' .
                                        'Return ONLY a JSON object with these possible fields: ' .
                                        'event_name, customer_name, event_start, event_end, setup_date, event_date, event_location. ' .
                                        'If a field is not found, omit it completely. '
                        ],
                        [
                            'role' => 'user',
                            'content' => $message
                        ]
                    ],
                    'temperature' => 0.3, // Lower for more deterministic results
                    'max_tokens' => 200
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);

            // Extract the content from the API response
            $content = $responseData['choices'][0]['message']['content'] ?? '{}';
            $extractedData = json_decode($content, true) ?? [];

            // Ensure we have at least one field to consider it successful
            if (empty($extractedData['event_name']) && empty($extractedData['event_start'])) {
                throw new \Exception('AI extraction failed to find required fields');
            }

            return $extractedData;

        } catch (\Exception $e) {
            // Log the error but don't break the application
            \Log::error('AI extraction failed: ' . $e->getMessage());
            return []; // Return empty array to allow fallback to pattern matching
        }
    }
}

