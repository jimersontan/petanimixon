<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Pet Animixon Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .settings-container { display: flex; gap: 24px; margin-top: 24px; }
        .settings-sidebar {
            width: 260px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 20px 12px;
            flex-shrink: 0;
        }
        .settings-sidebar h3 {
            margin: 0 0 12px 0;
            padding: 0 12px 8px;
            font-size: 16px;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border);
        }
        .settings-sidebar .nav-section { margin-bottom: 16px; }
        .settings-sidebar .nav-section-title {
            font-weight: 700;
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 12px;
            margin-bottom: 4px;
        }
        .settings-sidebar .nav-item {
            display: block;
            padding: 10px 12px;
            border-radius: 6px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            margin-bottom: 2px;
            border: none;
            width: 100%;
            text-align: left;
            background: transparent;
        }
        .settings-sidebar .nav-item:hover { background: var(--bg-page); }
        .settings-sidebar .nav-item.active {
            background: rgba(255, 107, 53, 0.1);
            color: var(--accent);
            font-weight: 600;
        }
        .settings-panel {
            flex: 1;
            background: #fff;
            padding: 28px;
            border: 1px solid var(--border);
            border-radius: 8px;
            display: none;
        }
        .settings-panel.active { display: block; }
        .settings-panel h2 { margin-top: 0; margin-bottom: 20px; font-size: 20px; }
        .settings-panel .form-group { margin-bottom: 18px; }
        .settings-panel label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px; }
        .settings-panel input[type="text"], .settings-panel input[type="email"], .settings-panel input[type="number"],
        .settings-panel select, .settings-panel textarea {
            width: 100%;
            max-width: 480px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
        }
        .settings-panel .btn-save { margin-top: 24px; }
        .settings-panel .help-text { font-size: 12px; color: var(--text-muted); margin-top: 4px; }
        .settings-panel .nav-link-btn { color: var(--accent); font-weight: 600; }
    </style>
</head>
<body class="dashboard-body">
    @include('partials.admin_header')

    <div class="dashboard-layout">
        @include('partials.admin_sidebar')

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="content-header">
                <h1 class="page-title">Settings</h1>
            </div>

            <div class="settings-container">
                <aside class="settings-sidebar">
                    <h3>Settings</h3>
                    <div class="nav-section">
                        <div class="nav-section-title">Store</div>
                        <button type="button" class="nav-item active" data-section="store-information">Store Information</button>
                        <button type="button" class="nav-item" data-section="currency">Currency</button>
                        <button type="button" class="nav-item" data-section="tax-settings">Tax Settings</button>
                        <button type="button" class="nav-item" data-section="invoice">Invoice</button>
                    </div>
                    <div class="nav-section">
                        <div class="nav-section-title">Payment</div>
                        <button type="button" class="nav-item" data-section="payment-gateways">Payment Gateways</button>
                        <button type="button" class="nav-item" data-section="payout-settings">Payout Settings</button>
                        <button type="button" class="nav-item" data-section="transaction-fees">Transaction Fees</button>
                    </div>
                    <div class="nav-section">
                        <div class="nav-section-title">Shipping</div>
                        <button type="button" class="nav-item" data-section="shipping-zones">Shipping Zones</button>
                        <button type="button" class="nav-item" data-section="delivery-providers">Delivery Providers</button>
                        <button type="button" class="nav-item" data-section="rates-fees">Rates & Fees</button>
                    </div>
                    <div class="nav-section">
                        <div class="nav-section-title">Users & Roles</div>
                        <a href="{{ route('admin.users') }}" class="nav-item">Admin Accounts</a>
                        <button type="button" class="nav-item" data-section="staff-permissions">Staff Permissions</button>
                    </div>
                    <div class="nav-section">
                        <div class="nav-section-title">Notification</div>
                        <button type="button" class="nav-item" data-section="email-templates">Email Templates</button>
                        <button type="button" class="nav-item" data-section="sms-settings">SMS Settings</button>
                    </div>
                    <div class="nav-section">
                        <div class="nav-section-title">Integrations</div>
                        <button type="button" class="nav-item" data-section="third-party">3rd-party Service</button>
                        <button type="button" class="nav-item" data-section="api-keys">API Keys</button>
                        <button type="button" class="nav-item" data-section="webhooks">Webhooks</button>
                    </div>
                    <div class="nav-section">
                        <div class="nav-section-title">Security</div>
                        <button type="button" class="nav-item" data-section="password-policy">Password Policy</button>
                        <button type="button" class="nav-item" data-section="two-factor">Two-factor Authentication</button>
                        <button type="button" class="nav-item" data-section="login-logs">Login Logs</button>
                    </div>
                </aside>

                @php
                    $s = $settings ?? new \App\Models\StoreSetting();
                    $extra = $s->extra ?? [];
                @endphp

                <!-- Store Information -->
                <section class="settings-panel active" id="panel-store-information">
                    <h2>Store Information</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_section" value="store">
                        <div class="form-group">
                            <label for="store_name">Store Name</label>
                            <input type="text" id="store_name" name="store_name" value="{{ old('store_name', $s->store_name ?? '') }}" placeholder="e.g. Pet Animixon">
                        </div>
                        <div class="form-group">
                            <label for="store_email">Store Email</label>
                            <input type="email" id="store_email" name="store_email" value="{{ old('store_email', $s->store_email ?? '') }}" placeholder="store@example.com">
                        </div>
                        <div class="form-group">
                            <label for="store_phone">Store Phone</label>
                            <input type="text" id="store_phone" name="store_phone" value="{{ old('store_phone', $s->store_phone ?? '') }}" placeholder="+63 123 456 7890">
                        </div>
                        <div class="form-group">
                            <label for="store_url">Store URL</label>
                            <input type="text" id="store_url" name="store_url" value="{{ old('store_url', $s->store_url ?? '') }}" placeholder="https://yourstore.com">
                        </div>
                        <div class="form-group">
                            <label for="store_description">Store Description</label>
                            <textarea id="store_description" name="store_description" rows="3" placeholder="Brief description of your store">{{ old('store_description', $s->store_description ?? '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="store_logo">Store Logo</label>
                            <input type="file" id="store_logo" name="store_logo" accept="image/*">
                            @if(!empty($s->store_logo_path))
                                <p class="help-text">Current: <img src="{{ asset('storage/'.$s->store_logo_path) }}" alt="Logo" style="max-height:36px;vertical-align:middle;"></p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="timezone">Timezone</label>
                            <select id="timezone" name="timezone">
                                @foreach(['Asia/Manila'=>'Asia/Manila (GMT+8)','Asia/Tokyo'=>'Asia/Tokyo (GMT+9)','America/New_York'=>'America/New York (GMT-5)','Europe/London'=>'Europe/London (GMT+0)','UTC'=>'UTC'] as $tz => $label)
                                    <option value="{{ $tz }}" {{ old('timezone', $s->timezone ?? '') == $tz ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="default_currency">Default Currency</label>
                            <select id="default_currency" name="default_currency">
                                @foreach(['PHP'=>'PHP - Philippine Peso (₱)','USD'=>'USD - US Dollar ($)','EUR'=>'EUR - Euro (€)','GBP'=>'GBP - British Pound (£)'] as $code => $label)
                                    <option value="{{ $code }}" {{ old('default_currency', $s->default_currency ?? 'PHP') == $code ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Currency -->
                <section class="settings-panel" id="panel-currency">
                    <h2>Currency</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="currency">
                        <div class="form-group">
                            <label for="primary_currency">Primary Currency</label>
                            <select name="primary_currency">
                                @foreach(['PHP','USD','EUR','GBP'] as $c)
                                    <option value="{{ $c }}" {{ ($extra['primary_currency'] ?? 'PHP') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="decimal_places">Decimal Places</label>
                            <input type="number" name="decimal_places" min="0" max="4" value="{{ $extra['decimal_places'] ?? 2 }}">
                            <p class="help-text">Number of decimal places for prices (e.g. 2 for 99.00)</p>
                        </div>
                        <div class="form-group">
                            <label for="currency_symbol_position">Symbol Position</label>
                            <select name="currency_symbol_position">
                                <option value="before" {{ ($extra['currency_symbol_position'] ?? 'before') == 'before' ? 'selected' : '' }}>Before amount (₱99.00)</option>
                                <option value="after" {{ ($extra['currency_symbol_position'] ?? '') == 'after' ? 'selected' : '' }}>After amount (99.00₱)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Tax Settings -->
                <section class="settings-panel" id="panel-tax-settings">
                    <h2>Tax Settings</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="tax">
                        <div class="form-group">
                            <label for="tax_enabled">Enable Tax</label>
                            <select name="tax_enabled">
                                <option value="1" {{ ($extra['tax_enabled'] ?? '1') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ ($extra['tax_enabled'] ?? '') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tax_rate">Tax Rate (%)</label>
                            <input type="number" name="tax_rate" step="0.01" min="0" max="100" value="{{ $extra['tax_rate'] ?? 12 }}" placeholder="12">
                            <p class="help-text">VAT or sales tax percentage (e.g. 12 for 12%)</p>
                        </div>
                        <div class="form-group">
                            <label for="tax_name">Tax Name</label>
                            <input type="text" name="tax_name" value="{{ $extra['tax_name'] ?? 'VAT' }}" placeholder="VAT">
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Invoice -->
                <section class="settings-panel" id="panel-invoice">
                    <h2>Invoice</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="invoice">
                        <div class="form-group">
                            <label for="invoice_prefix">Invoice Prefix</label>
                            <input type="text" name="invoice_prefix" value="{{ $extra['invoice_prefix'] ?? 'INV-' }}" placeholder="INV-">
                            <p class="help-text">Prefix before invoice number (e.g. INV-00001)</p>
                        </div>
                        <div class="form-group">
                            <label for="invoice_start">Starting Invoice Number</label>
                            <input type="number" name="invoice_start" min="1" value="{{ $extra['invoice_start'] ?? 1 }}" placeholder="1">
                        </div>
                        <div class="form-group">
                            <label for="invoice_terms">Default Payment Terms</label>
                            <input type="text" name="invoice_terms" value="{{ $extra['invoice_terms'] ?? 'Net 30' }}" placeholder="Net 30">
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Payment Gateways -->
                <section class="settings-panel" id="panel-payment-gateways">
                    <h2>Payment Gateways</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="payment">
                        <div class="form-group">
                            <label><input type="checkbox" name="gateway_cod" value="1" {{ ($extra['gateway_cod'] ?? '1') ? 'checked' : '' }}> Cash on Delivery (COD)</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="gateway_bank" value="1" {{ ($extra['gateway_bank'] ?? '') ? 'checked' : '' }}> Bank Transfer</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="gateway_online" value="1" {{ ($extra['gateway_online'] ?? '') ? 'checked' : '' }}> Online Payment (Card/GCash)</label>
                        </div>
                        <div class="form-group">
                            <label for="gateway_instructions">Payment Instructions</label>
                            <textarea name="gateway_instructions" rows="3" placeholder="Instructions for customers">{{ $extra['gateway_instructions'] ?? '' }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Payout Settings -->
                <section class="settings-panel" id="panel-payout-settings">
                    <h2>Payout Settings</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="payout">
                        <div class="form-group">
                            <label for="payout_schedule">Payout Schedule</label>
                            <select name="payout_schedule">
                                <option value="daily" {{ ($extra['payout_schedule'] ?? '') == 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ ($extra['payout_schedule'] ?? 'weekly') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="biweekly" {{ ($extra['payout_schedule'] ?? '') == 'biweekly' ? 'selected' : '' }}>Bi-weekly</option>
                                <option value="monthly" {{ ($extra['payout_schedule'] ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="payout_minimum">Minimum Payout Amount</label>
                            <input type="number" name="payout_minimum" step="0.01" min="0" value="{{ $extra['payout_minimum'] ?? 100 }}" placeholder="100">
                            <p class="help-text">Minimum balance before payout is processed</p>
                        </div>
                        <div class="form-group">
                            <label for="payout_bank_name">Bank Name</label>
                            <input type="text" name="payout_bank_name" value="{{ $extra['payout_bank_name'] ?? '' }}" placeholder="Bank name for payouts">
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Transaction Fees -->
                <section class="settings-panel" id="panel-transaction-fees">
                    <h2>Transaction Fees</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="transaction_fees">
                        <div class="form-group">
                            <label for="transaction_fee_percent">Platform Fee (%)</label>
                            <input type="number" name="transaction_fee_percent" step="0.01" min="0" max="100" value="{{ $extra['transaction_fee_percent'] ?? 0 }}" placeholder="0">
                            <p class="help-text">Percentage fee per transaction (e.g. 2.5 for 2.5%)</p>
                        </div>
                        <div class="form-group">
                            <label for="transaction_fee_fixed">Fixed Fee (per order)</label>
                            <input type="number" name="transaction_fee_fixed" step="0.01" min="0" value="{{ $extra['transaction_fee_fixed'] ?? 0 }}" placeholder="0">
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Shipping Zones -->
                <section class="settings-panel" id="panel-shipping-zones">
                    <h2>Shipping Zones</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="shipping_zones">
                        <div class="form-group">
                            <label for="zone_local">Local (Same City) - Rate</label>
                            <input type="number" name="zone_local" step="0.01" min="0" value="{{ $extra['zone_local'] ?? 50 }}" placeholder="50">
                        </div>
                        <div class="form-group">
                            <label for="zone_national">National (Philippines) - Rate</label>
                            <input type="number" name="zone_national" step="0.01" min="0" value="{{ $extra['zone_national'] ?? 150 }}" placeholder="150">
                        </div>
                        <div class="form-group">
                            <label for="zone_international">International - Rate</label>
                            <input type="number" name="zone_international" step="0.01" min="0" value="{{ $extra['zone_international'] ?? 500 }}" placeholder="500">
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Delivery Providers -->
                <section class="settings-panel" id="panel-delivery-providers">
                    <h2>Delivery Providers</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="delivery">
                        <div class="form-group">
                            <label><input type="checkbox" name="provider_lbc" value="1" {{ ($extra['provider_lbc'] ?? '') ? 'checked' : '' }}> LBC</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="provider_jnt" value="1" {{ ($extra['provider_jnt'] ?? '') ? 'checked' : '' }}> J&T Express</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="provider_grab" value="1" {{ ($extra['provider_grab'] ?? '') ? 'checked' : '' }}> Grab Express</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="provider_own" value="1" {{ ($extra['provider_own'] ?? '') ? 'checked' : '' }}> Own Delivery</label>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Rates & Fees -->
                <section class="settings-panel" id="panel-rates-fees">
                    <h2>Rates & Fees</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="rates_fees">
                        <div class="form-group">
                            <label for="free_shipping_min">Free Shipping Minimum Order</label>
                            <input type="number" name="free_shipping_min" step="0.01" min="0" value="{{ $extra['free_shipping_min'] ?? 0 }}" placeholder="0">
                            <p class="help-text">Order total for free shipping (0 = disabled)</p>
                        </div>
                        <div class="form-group">
                            <label for="handling_fee">Handling Fee</label>
                            <input type="number" name="handling_fee" step="0.01" min="0" value="{{ $extra['handling_fee'] ?? 0 }}" placeholder="0">
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Staff Permissions -->
                <section class="settings-panel" id="panel-staff-permissions">
                    <h2>Staff Permissions</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="staff_permissions">
                        <div class="form-group">
                            <label><input type="checkbox" name="perm_orders" value="1" {{ ($extra['perm_orders'] ?? '1') ? 'checked' : '' }}> View & Manage Orders</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="perm_products" value="1" {{ ($extra['perm_products'] ?? '1') ? 'checked' : '' }}> Manage Products</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="perm_customers" value="1" {{ ($extra['perm_customers'] ?? '1') ? 'checked' : '' }}> View Customers</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="perm_settings" value="1" {{ ($extra['perm_settings'] ?? '') ? 'checked' : '' }}> Access Settings</label>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Email Templates -->
                <section class="settings-panel" id="panel-email-templates">
                    <h2>Email Templates</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="email_templates">
                        <div class="form-group">
                            <label for="email_order_confirmation">Order Confirmation Subject</label>
                            <input type="text" name="email_order_confirmation" value="{{ $extra['email_order_confirmation'] ?? 'Order Confirmed - #ORDER_ID#' }}" placeholder="Order Confirmed - #ORDER_ID#">
                            <p class="help-text">Use #ORDER_ID# as a placeholder for the order number.</p>
                        </div>
                        <div class="form-group">
                            <label for="email_from_name">From Name</label>
                            <input type="text" name="email_from_name" value="{{ $extra['email_from_name'] ?? ($s->store_name ?? 'Pet Animixon') }}" placeholder="Store name">
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- SMS Settings -->
                <section class="settings-panel" id="panel-sms-settings">
                    <h2>SMS Settings</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="sms">
                        <div class="form-group">
                            <label for="sms_enabled">Enable SMS Notifications</label>
                            <select name="sms_enabled">
                                <option value="0" {{ ($extra['sms_enabled'] ?? '0') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($extra['sms_enabled'] ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sms_provider">SMS Provider</label>
                            <select name="sms_provider">
                                <option value="">-- Select --</option>
                                <option value="twilio" {{ ($extra['sms_provider'] ?? '') == 'twilio' ? 'selected' : '' }}>Twilio</option>
                                <option value="semaphore" {{ ($extra['sms_provider'] ?? '') == 'semaphore' ? 'selected' : '' }}>Semaphore</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- 3rd-party Service -->
                <section class="settings-panel" id="panel-third-party">
                    <h2>3rd-party Service</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="third_party">
                        <div class="form-group">
                            <label><input type="checkbox" name="google_analytics" value="1" {{ ($extra['google_analytics'] ?? '') ? 'checked' : '' }}> Google Analytics</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="facebook_pixel" value="1" {{ ($extra['facebook_pixel'] ?? '') ? 'checked' : '' }}> Facebook Pixel</label>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- API Keys -->
                <section class="settings-panel" id="panel-api-keys">
                    <h2>API Keys</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="api_keys">
                        <div class="form-group">
                            <label for="api_public_key">Public API Key</label>
                            <input type="text" name="api_public_key" value="{{ $extra['api_public_key'] ?? '' }}" placeholder="pk_...">
                        </div>
                        <div class="form-group">
                            <label for="api_secret_key">Secret API Key</label>
                            <input type="password" name="api_secret_key" value="" placeholder="Leave blank to keep current">
                            <p class="help-text">Leave blank if you don't want to change</p>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Webhooks -->
                <section class="settings-panel" id="panel-webhooks">
                    <h2>Webhooks</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="webhooks">
                        <div class="form-group">
                            <label for="webhook_url">Webhook URL</label>
                            <input type="text" name="webhook_url" value="{{ $extra['webhook_url'] ?? '' }}" placeholder="https://yoursite.com/webhook">
                            <p class="help-text">URL to receive order/payment events</p>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Password Policy -->
                <section class="settings-panel" id="panel-password-policy">
                    <h2>Password Policy</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="password_policy">
                        <div class="form-group">
                            <label for="password_min_length">Minimum Length</label>
                            <input type="number" name="password_min_length" min="6" max="32" value="{{ $extra['password_min_length'] ?? 8 }}">
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="password_require_upper" value="1" {{ ($extra['password_require_upper'] ?? '1') ? 'checked' : '' }}> Require uppercase letter</label>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="password_require_number" value="1" {{ ($extra['password_require_number'] ?? '1') ? 'checked' : '' }}> Require number</label>
                        </div>
                        <div class="form-group">
                            <label for="password_expiry_days">Password expiry (days)</label>
                            <input type="number" name="password_expiry_days" min="0" value="{{ $extra['password_expiry_days'] ?? 0 }}" placeholder="0 = never">
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Two-factor Authentication -->
                <section class="settings-panel" id="panel-two-factor">
                    <h2>Two-factor Authentication</h2>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="two_factor">
                        <div class="form-group">
                            <label for="tfa_enabled">Enable 2FA for Admins</label>
                            <select name="tfa_enabled">
                                <option value="0" {{ ($extra['tfa_enabled'] ?? '0') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($extra['tfa_enabled'] ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>

                <!-- Login Logs -->
                <section class="settings-panel" id="panel-login-logs">
                    <h2>Login Logs</h2>
                    <p>View recent admin login activity. Login logs can be enabled and viewed here.</p>
                    <form method="post" action="{{ route('settings.admin.update') }}">
                        @csrf
                        <input type="hidden" name="_section" value="login_logs">
                        <div class="form-group">
                            <label for="login_logs_enabled">Enable Login Logging</label>
                            <select name="login_logs_enabled">
                                <option value="0" {{ ($extra['login_logs_enabled'] ?? '0') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($extra['login_logs_enabled'] ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                            <p class="help-text">Log IP, time, and user for each admin login</p>
                        </div>
                        <button type="submit" class="btn-primary btn-save">Save Changes</button>
                    </form>
                </section>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
        (function(){
            var navItems = document.querySelectorAll('.settings-sidebar .nav-item[data-section]');
            var panels = document.querySelectorAll('.settings-panel');
            navItems.forEach(function(item){
                item.addEventListener('click', function(){
                    var section = this.getAttribute('data-section');
                    if(!section) return;
                    navItems.forEach(function(i){ i.classList.remove('active'); });
                    panels.forEach(function(p){ p.classList.remove('active'); });
                    this.classList.add('active');
                    var panel = document.getElementById('panel-' + section);
                    if(panel) panel.classList.add('active');
                    if(window.history && window.history.replaceState){
                        window.history.replaceState(null, '', '?section=' + section);
                    }
                });
            });
            var match = window.location.search.match(/section=([^&]+)/);
            if(match){
                var sec = match[1];
                navItems.forEach(function(i){
                    if(i.getAttribute('data-section') === sec){
                        i.click();
                    }
                });
            }
        })();
    </script>
</body>
</html>
