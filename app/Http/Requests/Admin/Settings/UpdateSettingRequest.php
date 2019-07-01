<?php

namespace App\Http\Requests\Admin\Settings;

use App\Http\Requests\Request;

use App\Models\Collections\Collection;
use App\Setting;

class UpdateSettingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user && $this->user->hasPermission('system_config') ) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $setting_key = $this->route()->parameters()["setting_key"];

        switch ($setting_key) {
            case 'blog':
                $rules = [
                    'url'          => 'required|url',
                ];
                break;

            case 'social':
                $rules = [
                    'facebook'      => 'active_url|url',
                    'twitter'       => 'active_url|url',
                    'instagram'     => 'active_url|url',
                    'pinterest'     => 'active_url|url',
                ];
                break;

            case 'mail':
                $rules = [
                    'contact'           => 'required|email',
                    'system'            => 'required|email',
                    'notifications'     => 'required|email',
					'register_copy'   	=> 'required|array',
					'purchase_copy'   	=> 'required|array',
					// 'thanks_copy'     	=> 'required|array',
					'mail_greeting'   	=> 'required|array',
					'mail_farewell'   	=> 'required|array',
					'cash_out_copy'   	=> 'required|array',
                ];

                foreach ($this->languages_isos as $iso) {
                    $rules['register_copy.'.$iso]   = 'string';
                    $rules['purchase_copy.'.$iso]   = 'string';
                    // $rules['thanks_copy.'.$iso]     = 'string';
                    $rules['mail_greeting.'.$iso]   = 'string';
                    $rules['mail_farewell.'.$iso]   = 'string';
					$rules['cash_out_copy.'.$iso]   = 'string';

                }

                break;

            case 'authentication':
                $rules =
                [
                    'login'             => 'required|array',
                    'main_register'     => 'required|array',
                    'event_register'    => 'required|array'
                ];

                foreach ($this->languages_isos as $iso)
                {
                    $rules['login.' . $iso] = 'string';
                    $rules['main_register.' . $iso] = 'string';
                    $rules['event_register.' . $iso] = 'string';
                }

                break;

            case 'copys':
                foreach (Setting::SITE_COPYS_ARRAY as $page => $copies)
                {
                    foreach ($copies as $copy)
                    {
                        $rules[$page . '_' . $copy] = 'required|array';
                        foreach ($this->languages_isos as $iso)
                        {
                            $rules[$page . '_' . $copy . '.' . $iso] = 'present|string';
                        }
                    }
                }

                // $rules = [
                //     'thankyou_page_copy'           => 'required|array',
                //     'products_to_buy_copy'            => 'required|array',
                // ];
                // foreach ($this->languages_isos as $iso) {
                //     $rules['thankyou_page_copy.'.$iso]   = 'string';
                //     $rules['products_to_buy_copy.'.$iso]   = 'string';
                // }

                break;


			case 'event_expiration':
                $rules = [
                    'time' => 'required|integer|min:0',
                ];
                break;

			case 'checkout_min':
                $rules = [
                    'percentage' => 'required|integer|between:0,100',
                ];
                break;

			case 'card_cost':
                $rules = [
                    'cost' => 'required|numeric|min:0',
                ];
                break;

			case 'cashout_min_amount':
				$rules = [
					'min_amount' => 'required|numeric|min:0',
				];
				break;

			case 'cash_out_fees':
				$rules = [
					'exclusive' => 'required|numeric|between:0,100',
					'not_exclusive' => 'required|numeric|between:0,100',
				];
				break;


			case 'shipment':
                $rules = [
                    'origin-address.street-1'       => 'required|string',
                    'origin-address.street-2'       => 'required|string',
                    'origin-address.street-3'       => 'required|string',
                    'origin-address.city'           => 'required|string',
                    'origin-address.state'          => 'required|string',
                    'origin-address.country'        => 'required|string',
                    'origin-address.zip'            => 'required|string',
                    // 'average-weight'                => 'required|numeric',
                    // 'minimal-clothing'              => 'required|integer|min:0',
                ];
                break;

			case 'exchange_rate':
                $rules = [
                    'US.currency' => 'required|string',
                    'US.exchange' => 'required|numeric',
                ];
                break;

            default:
                $rules = [];
                break;
        }

        return $rules;
    }
}
