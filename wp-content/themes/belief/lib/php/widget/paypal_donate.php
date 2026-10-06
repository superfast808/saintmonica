<?php
class widget_paypal_donate extends WP_Widget {

	function widget_paypal_donate() {
	/*Constructor*/
		$widget_ops = array('classname' => 'widget_paypal_donate ', 'description' => __( 'Paypal donate button' , 'cosmotheme' ) );
		$this->__construct('widget_cosmo_paypal_donate', _TN_ . ' : ' . __( 'Paypal donate button' , 'cosmotheme' ), $widget_ops);
	}
	
	function widget($args, $instance) {
        /* prints the widget*/
		extract($args, EXTR_SKIP);
        
		echo $before_widget;

		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		if(isset($instance['paypal_email'])){
			$paypal_email = apply_filters( 'widget_title', $instance['paypal_email'] );	
		}else{
			$paypal_email = '';
		}
		
		if(isset($instance['item_name'])){
			$item_name = apply_filters( 'widget_title', $instance['item_name'] );
		}else{
			$item_name = '';
		}
		
		if(isset($instance['currency_code'])){
			$currency_code = apply_filters( 'widget_title', $instance['currency_code'] );
		}else{
			$currency_code = 'USD';
		}
		
		if(isset($instance['btn_type'])){
			$btn_type = apply_filters( 'widget_title', $instance['btn_type'] );
		}else{
			$btn_type = 'btn_donate_LG';
		}
		
		if(isset($instance['amount'])){
			$amount = apply_filters( 'widget_title', $instance['amount'] );
		}else{
			$amount = '';
		}
		
		if(isset($instance['country_language'])){
			$country_language = apply_filters( 'widget_title', $instance['country_language'] );
		}else{
			$country_language = 'en_US';
		}

		if(isset($instance['checkout_languages'])){
			$checkout_languages = apply_filters( 'widget_title', $instance['checkout_languages'] );
		}else{
			$checkout_languages = 'US';	
		}
		
		if( strlen( $title) > 0 ){
            echo $before_title . $title . $after_title;
        }

        /*call here render_paypal_btn function */
        render_paypal_btn($paypal_email, $item_name, $currency_code, $btn_type, $amount, $country_language, $checkout_languages);
            
        echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {

	/*save the widget*/
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['paypal_email'] = strip_tags($new_instance['paypal_email']);
		$instance['item_name'] = strip_tags($new_instance['item_name']);
		$instance['currency_code'] = strip_tags($new_instance['currency_code']);
		$instance['btn_type'] = strip_tags($new_instance['btn_type']);
		$instance['amount'] = strip_tags($new_instance['amount']);
		$instance['country_language'] = strip_tags($new_instance['country_language']);
		$instance['checkout_languages'] = strip_tags($new_instance['checkout_languages']);



		return $instance;
	}
	
	function form($instance) {
	/*widgetform in backend*/

		$instance = wp_parse_args( (array) $instance, array('title' => '',  'paypal_email' => '', 'item_name' => '', 'currency_code' => 'USD', 'btn_type' => 'btn_donate_LG', 'amount' => '', 'country_language' => 'en_US', 'checkout_languages' => 'US') );
		$title = strip_tags($instance['title']);
		$paypal_email = strip_tags($instance['paypal_email']);
		$item_name = strip_tags($instance['item_name']);
		$currency_code = strip_tags($instance['currency_code']);
		$btn_type = strip_tags($instance['btn_type']);
		$amount = strip_tags($instance['amount']);
		$country_language = strip_tags($instance['country_language']);
		$checkout_languages = strip_tags($instance['checkout_languages']);
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','cosmotheme') ?>: 
			    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id('paypal_email'); ?>"><?php _e('PayPal account','cosmotheme') ?>:
		        <input class="widefat" id="<?php echo $this->get_field_id('paypal_email'); ?>" name="<?php echo $this->get_field_name('paypal_email'); ?>" type="text" value="<?php echo esc_attr($paypal_email); ?>" />
		    </label>
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id('currency_code'); ?>"><?php _e('Currency','cosmotheme') ?>:
		    	
		        <select class="widefat" id="<?php echo $this->get_field_id('currency_code'); ?>" name="<?php echo $this->get_field_name('currency_code'); ?>" >
                    <?php
                        foreach( $this -> currency_codes  as $key => $val ){
                        	
                            $file = pathinfo( $icn );
                            if( $currency_code == $key ){
                                ?><option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option><?php
                            }else{
                                ?><option value="<?php echo $key; ?>"><?php echo $val; ?></option><?php
                            }
                        }
                        
                    ?>
                </select>
		    </label>
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id('item_name'); ?>"><?php _e('Purpose (optional)','cosmotheme') ?>:
		        <input class="widefat" id="<?php echo $this->get_field_id('item_name'); ?>" name="<?php echo $this->get_field_name('item_name'); ?>" type="text" value="<?php echo esc_attr($item_name); ?>" />
		    </label>
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id('amount'); ?>"><?php _e('Amount ','cosmotheme') ?>:
		        <input class="widefat" id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>" type="text" value="<?php echo esc_attr($amount); ?>" />
		        <?php echo '<span class="hint">' . __('The default amount for a donation (Optional).','cosmotheme') . '</span>'; ?>
		    </label>
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id('btn_type'); ?>"><?php _e('Select button ','cosmotheme') ?>:</label>	
		    	<?php  
		    		foreach ($this -> donate_buttons as $key => $btn) {
		    			if( $btn_type == $key ){
		    				$checked = 'checked="checked"';
		    			}else{
		    				$checked = '';
		    			}

		    		?>
		    			<div class="ppl_btn_type">			
			    			<input type="radio" name="<?php echo $this->get_field_name('btn_type'); ?>" <?php echo $checked; ?> value="<?php echo $key; ?>">
			    			<img src="<?php echo $btn; ?>" />
			    		</div>

	    				
	    			<?php
		    		}
		    	?>
		    
		        
		    
		</p>

		<p>
		    <label for="<?php echo $this->get_field_id('country_language'); ?>"><?php _e('Country and language','cosmotheme') ?>:
		        <select class="widefat" id="<?php echo $this->get_field_id('country_language'); ?>" name="<?php echo $this->get_field_name('country_language'); ?>" >
                    <?php
                        foreach( $this -> localized_buttons  as $key => $val ){
                            $file = pathinfo( $icn );
                            if( $country_language == $key ){
                                ?><option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option><?php
                            }else{
                                ?><option value="<?php echo $key; ?>"><?php echo $val; ?></option><?php
                            }
                        }
                    ?>
                </select>
                <?php echo '<span class="hint">'. __('Localize the language and the country for the button','cosmotheme') . '</span>'; ?>
		    </label>
		</p>
		<p>
		    <label for="<?php echo $this->get_field_id('checkout_languages'); ?>"><?php _e('Set Checkout Language','cosmotheme') ?>:
		        <select class="widefat" id="<?php echo $this->get_field_id('checkout_languages'); ?>" name="<?php echo $this->get_field_name('checkout_languages'); ?>" >
                    <?php
                        foreach( $this -> checkoutlanguages  as $key => $val ){
                            $file = pathinfo( $icn );
                            if( $checkout_languages == $key ){
                                ?><option value="<?php echo $key; ?>" selected="selected"><?php echo $val; ?></option><?php
                            }else{
                                ?><option value="<?php echo $key; ?>"><?php echo $val; ?></option><?php
                            }
                        }
                    ?>
                </select>
            </label>
		</p>
<?php 		
		
		
	}	

	var $donate_buttons = array(
		'btn_donate_SM' => 'https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif',
		'btn_donate_LG' => 'https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif',
		'btn_donateCC_LG' => 'https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif'
	);

	var  $currency_codes = array(
		'AUD' => 'Australian Dollars (A $)',
		'CAD' => 'Canadian Dollars (C $)',
		'EUR' => 'Euros (&euro;)',
		'GBP' => 'Pounds Sterling (&pound;)',
		'JPY' => 'Yen (&yen;)',
		'USD' => 'U.S. Dollars ($)',
		'NZD' => 'New Zealand Dollar ($)',
		'CHF' => 'Swiss Franc',
		'HKD' => 'Hong Kong Dollar ($)',
		'SGD' => 'Singapore Dollar ($)',
		'SEK' => 'Swedish Krona',
		'DKK' => 'Danish Krone',
		'PLN' => 'Polish Zloty',
		'NOK' => 'Norwegian Krone',
		'HUF' => 'Hungarian Forint',
		'CZK' => 'Czech Koruna',
		'ILS' => 'Israeli Shekel',
		'MXN' => 'Mexican Peso',
		'BRL' => 'Brazilian Real',
		'TWD' => 'Taiwan New Dollar',
		'PHP' => 'Philippine Peso',
		'TRY' => 'Turkish Lira',
		'THB' => 'Thai Baht'
	);

	var $localized_buttons = array(
		'en_AU' => 'Australia - Australian English',
		'de_DE/AT' => 'Austria - German',
		'nl_NL/BE' => 'Belgium - Dutch',
		'fr_XC' => 'Canada - French',
		'zh_XC' => 'China - Simplified Chinese',
		'fr_FR/FR' => 'France - French',
		'de_DE/DE' => 'Germany - German',
		'it_IT/IT' => 'Italy - Italian',
		'ja_JP/JP' => 'Japan - Japanese',
		'es_XC' => 'Mexico - Spanish',
		'nl_NL/NL' => 'Netherlands - Dutch',
		'pl_PL/PL' => 'Poland - Polish',
		'es_ES/ES' => 'Spain - Spanish',
		'de_DE/CH' => 'Switzerland - German',
		'fr_FR/CH' => 'Switzerland - French',
		'en_US' => 'United States - U.S. English'
	);

	public $checkoutlanguages = array(
		'US' => 'None',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'BR' => 'Brazil',
		'CA' => 'Canada',
		'CN' => 'China',
		'FR' => 'France',
		'DE' => 'Germany',
		'IT' => 'Italy',
		'NL' => 'Netherlands',
		'ES' => 'Spain',
		'SE' => 'Sweden',
		'GB' => 'United Kingdom',
		'US' => 'United States',
	);
}
?>