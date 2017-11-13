<div id="cj_aufp_metabox">
    <div class="cj_aufp_rows">
        <div class="cj_aufp_row">
            <div class="cj_aufp_row__label"><label for="cj_aufp__login"><?php _e('Login', 'cj-aufp'); ?></label></div>
            <div class="cj_aufp_row__value"><input type="text" id="cj_aufp__login" value="" /></div>
        </div>
        <div class="cj_aufp_row">
            <div class="cj_aufp_row__label"><label for="cj_aufp__first_name"><?php _e('First Name', 'cj-aufp'); ?></label></div>
            <div class="cj_aufp_row__value"><input type="text" id="cj_aufp__first_name" value="" /></div>
        </div>
        <div class="cj_aufp_row">
            <div class="cj_aufp_row__label"><label for="cj_aufp__last_name"><?php _e('Last Name', 'cj-aufp'); ?></label></div>
            <div class="cj_aufp_row__value"><input type="text" id="cj_aufp__last_name" value="" /></div>
        </div>
        <div class="cj_aufp_row">
            <div class="cj_aufp_row__label"><label for="cj_aufp__email"><?php _e('Email', 'cj-aufp'); ?></label></div>
            <div class="cj_aufp_row__value"><input type="text" id="cj_aufp__email" value="" /></div>
        </div>
        <div class="cj_aufp_row">
            <div class="cj_aufp_row__label"><label for="cj_aufp__password"><?php _e('Password', 'cj-aufp'); ?></label></div>
            <div class="cj_aufp_row__value"><input type="text" id="cj_aufp__password" value="" /></div>
        </div>
    </div>
    <div class="cj_aufp_metabox__result"></div>
    <div class="cj_aufp_metabox__buttons hide-if-no-js">
        <span id="cj_aufp_metabox_addUserButton" class="button" data-nonce="<?php echo wp_create_nonce('cj_add_user'); ?>"><?php _e('Add User', 'cj-aufp'); ?></span>
        <span class="waiting spinner"></span>
    </div>
</div>
