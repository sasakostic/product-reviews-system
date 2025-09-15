<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use View;
use Input;
use Redirect;

use App\ProductReportingReason;
use App\ReviewReportingReason;
use App\Setting;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');        
    }
    
    public function getIndex() 
    {
        return view('admin/settings/index')
        ->with('submenu_highlight', 'submenu_general');
    }
    
    public static function set($var, $val) 
    {

        try{
            $setting = Setting::first();
            $setting->$var = $val;              
            $setting->save();               

        } catch(exception $e) {
            return false;
        }
        
        return true;

    }


    public function getProducts() 
    {

        $product_reporting_reasons = ProductReportingReason::OrderBy('ID', 'DESC')->get();

        return view('admin/settings/products/index')
        ->with('product_reporting_reasons', $product_reporting_reasons)
        ->with('max_image_size', env('UPLOAD_MAX_SIZE_BYTES', 1024))
        ->with('submenu_highlight', 'submenu_products');
    }
    
    public function getReviews() 
    {
        $review_reporting_reasons = ReviewReportingReason::OrderBy('ID', 'DESC')->get();

        return view('admin/settings/reviews/index')
        ->with('review_reporting_reasons', $review_reporting_reasons)
        ->with('submenu_highlight', 'submenu_reviews');
    }

    public function getRegistration() 
    {
        return view('admin/settings/registration/index')
        ->with('submenu_highlight', 'submenu_registration')
        ->with('recaptcha_public_key', env('RECAPTCHA_PUBLIC_KEY', ''))
        ->with('recaptcha_private_key', env('RECAPTCHA_PRIVATE_KEY', ''));
    }
    
    public function getContact() 
    {
        return view('admin/settings/contact/index')
        ->with('submenu_highlight', 'submenu_contact')
        ->with('recaptcha_public_key', env('RECAPTCHA_PUBLIC_KEY', ''))
        ->with('recaptcha_private_key', env('RECAPTCHA_PRIVATE_KEY', ''));
    }
    
    public function postUpdateSettings() 
    {
        $alert_type = 'success';
        $alert_message = 'Settings updated';
        
        try {
            self::set('site_name', Input::get('site_name'));
            self::set('meta_description', Input::get('meta_description'));
            
            self::set('header_code', Input::get('header_code'));
            self::set('footer_code', Input::get('footer_code'));
            
            self::set('facebook', Input::get('facebook'));
            self::set('twitter', Input::get('twitter'));
            self::set('youtube', Input::get('youtube'));            
            
            self::set('front_end_pagination', Input::get('front_end_pagination'));

            $logo = $this->UploadImage('logo');
            if($logo) self::set('logo', $logo);

            $favicon = $this->UploadImage('favicon');
            if($favicon) self::set('favicon', $favicon);
            
        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error updating settings';
        }
        
        return Redirect::to('admin/settings/')
        ->with($alert_type, $alert_message);
    }

    public function updateENV($variable, $value)
    {
        $path = base_path('.env'); 
        if (file_exists($path)) {
            $saved = file_put_contents($path, str_replace($variable.'='.env($variable), $variable.'='.$value, file_get_contents($path)));
            if($saved !== false) return true;
        } else 
        return false;
    }
    
    
    public function postUpdateReviewsSettings() 
    {

        if(Input::has('new_review_reporting_reason')) {
            $new_reasons = Input::get('new_review_reporting_reason');
            foreach($new_reasons as $new_reason) {
                if(!empty($new_reason)) {
                    $reason = new ReviewReportingReason();
                    $reason->text = $new_reason;
                    $reason->save();
                }
            }
        }

        if(Input::get('submit_button') == 'delete_review_reporting_reasons') {
            $reasons = Input::get('review_reporting_reasons');
            ReviewReportingReason::whereIn('id', $reasons)->delete();
        }

        $alert_type = 'success';
        $alert_message = 'Reviews settings updated';
        
        try {

            self::set('review_moderation', Input::get('review_moderation'));
            self::set('review_title', Input::get('review_title'));
            self::set('review_pros_cons', Input::get('review_pros_cons'));
            if(ReviewReportingReason::get()->count() == 0 && Input::get('review_report') == 1) {
                $alert_type = 'warning';
                $alert_message = 'Reviews settings updated. Reporting disabled until some reporting options get added';
                self::set('review_report', 0); 
            } else {
                self::set('review_report', Input::get('review_report'));
            }

            self::set('review_helpful', Input::get('review_helpful'));
            self::set('review_favorite', Input::get('review_favorite'));
            self::set('review_len', Input::get('review_len'));
            self::set('review_preview_len', Input::get('review_preview_len'));
            self::set('review_writing_tips', Input::get('review_writing_tips'));
            self::set('review_edit', Input::get('review_edit'));
            self::set('review_delete', Input::get('review_delete'));
            self::set('date_format', Input::get('date_format'));
        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error updating reviews settings';
        }
        
        return Redirect::to('admin/settings/reviews')->with($alert_type, $alert_message);
    }

    public function postUpdateProductsSettings() 
    {

        //$new_reason = Input::get('new_product_reporting_reason', null); 
        if(Input::has('new_product_reporting_reason')) {
            $new_reasons = Input::get('new_product_reporting_reason');
            foreach($new_reasons as $new_reason) {
                if(!empty($new_reason)) {
                    $reason = new ProductReportingReason();
                    $reason->text = $new_reason;
                    $reason->save();
                }
            }
        }

        if(Input::get('submit_button') == 'delete_product_reporting_reasons') {
            $reasons = Input::get('product_reporting_reasons');
            ProductReportingReason::whereIn('id', $reasons)->delete();
        }
        

        $alert_type = 'success';
        $alert_message = 'Products settings updated';
        
        try {

            if(Input::has('users_add_product_images'))
                $this->updateENV('UPLOAD_MAX_SIZE_BYTES', Input::get('max_image_size'));

            self::set('product_sm_thumb_w', Input::get('product_sm_thumb_w'));
            self::set('product_sm_thumb_h', Input::get('product_sm_thumb_h'));
            
            self::set('product_main_thumb_w', Input::get('product_main_thumb_w'));
            self::set('product_main_thumb_h', Input::get('product_main_thumb_h'));
            
            self::set('product_description_len', Input::get('product_description_len'));

            self::set('users_add_products', Input::get('users_add_products'));
            self::set('users_add_product_images', Input::get('users_add_product_images'));
            self::set('users_list_product_images', Input::get('users_list_product_images'));
            self::set('users_delete_product_images', Input::get('users_delete_product_images'));
            self::set('users_report_products', Input::get('users_report_products'));
        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error updating products settings';
        }
        
        return Redirect::to('admin/settings/products')->with($alert_type, $alert_message);
    }

    public function postUpdateRegistrationSettings() 
    {
        $alert_type = 'success';
        $alert_message = 'Registration settings updated';
        
        try {

            self::set('email_confirmation', Input::get('email_confirmation'));

            self::set('recaptcha_registration', Input::get('recaptcha_registration'));
            $this->updateENV('RECAPTCHA_PUBLIC_KEY', Input::get('recaptcha_public_key'));
            $this->updateENV('RECAPTCHA_PRIVATE_KEY', Input::get('recaptcha_private_key'));
        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error updating registration settings';
        }
        
        return Redirect::to('admin/settings/registration')->with($alert_type, $alert_message);
    }

    public function postUpdateContactSettings() 
    {
        $alert_type = 'success';
        $alert_message = 'Contact settings updated';
        
        try {
            /* */
        } catch(\Exception $e) {
            $alert_type = 'error';
            $alert_message = 'Error updating reviews settings';
        }
        
        return Redirect::to('admin/settings/contact')->with($alert_type, $alert_message);
    }

    public function UploadImage($type) 
    {

        if (Input::hasFile($type)) {
            $file = Input::file($type);
            $fileExt = strtolower($file->getClientOriginalExtension());
            if(!strstr(env('UPLOAD_FAVICON_TYPES'), $fileExt)) return false;
            if($file->getSize() > intval(env('UPLOAD_MAX_SIZE_BYTES'))) return false;
            $file_name = $type.'.'.$fileExt;
            $file->move('images', $file_name);
            return $file_name;
        } else
        return false;
    }
    
}
