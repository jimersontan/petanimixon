<?php

namespace App\Http\Controllers;

use App\Models\StoreSetting;
use Illuminate\Http\Request;

class SettingsAdminController extends Controller
{
    public function index()
    {
        $settings = StoreSetting::first() ?? new StoreSetting();
        return view('admin_settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $section = $request->input('_section', 'store');
        $settings = StoreSetting::first() ?? new StoreSetting();
        $extra = $settings->extra ?? [];

        if ($section === 'store') {
            $data = $request->validate([
                'store_name' => 'nullable|string|max:255',
                'store_email' => 'nullable|email',
                'store_phone' => 'nullable|string|max:50',
                'store_url' => 'nullable|string|max:255',
                'store_description' => 'nullable|string',
                'store_logo' => 'nullable|image|max:2048',
                'timezone' => 'nullable|string|max:50',
                'default_currency' => 'nullable|string|max:10',
            ]);
            if ($request->hasFile('store_logo')) {
                $data['store_logo_path'] = $request->file('store_logo')->store('settings', 'public');
            }
            unset($data['store_logo']);
            $settings->fill($data);
            
            if ($request->has('store_address')) {
                $extra['store_address'] = $request->input('store_address');
                $settings->extra = $extra;
            }
        } else {
            $allowed = $this->getExtraKeysForSection($section);
            foreach ($allowed as $key) {
                $val = $request->input($key);
                if ($val !== null) {
                    $extra[$key] = is_string($val) ? $val : (string) $val;
                }
            }
            foreach (['gateway_cod','gateway_bank','gateway_online','provider_lbc','provider_jnt','provider_grab','provider_own','google_analytics','facebook_pixel','perm_orders','perm_products','perm_customers','perm_settings','password_require_upper','password_require_number'] as $cb) {
                $extra[$cb] = $request->has($cb) ? '1' : '0';
            }
            if ($request->filled('api_secret_key')) {
                $extra['api_secret_key'] = $request->input('api_secret_key');
            }
            $settings->extra = $extra;
        }

        $settings->save();
        return redirect()->route('settings.admin')->with('success', 'Settings saved successfully.');
    }

    protected function getExtraKeysForSection(string $section): array
    {
        $map = [
            'currency' => ['primary_currency','decimal_places','currency_symbol_position'],
            'tax' => ['tax_enabled','tax_rate','tax_name'],
            'invoice' => ['invoice_prefix','invoice_start','invoice_terms'],
            'payment' => ['gateway_instructions'],
            'payout' => ['payout_schedule','payout_minimum','payout_bank_name'],
            'transaction_fees' => ['transaction_fee_percent','transaction_fee_fixed'],
            'shipping_zones' => ['zone_local','zone_national','zone_international'],
            'delivery' => [],
            'rates_fees' => ['free_shipping_min','handling_fee'],
            'staff_permissions' => [],
            'email_templates' => ['email_order_confirmation','email_from_name'],
            'sms' => ['sms_enabled','sms_provider'],
            'third_party' => [],
            'api_keys' => ['api_public_key','api_secret_key'],
            'webhooks' => ['webhook_url'],
            'password_policy' => ['password_min_length','password_expiry_days'],
            'two_factor' => ['tfa_enabled'],
            'login_logs' => ['login_logs_enabled'],
        ];
        return $map[$section] ?? [];
    }
}
