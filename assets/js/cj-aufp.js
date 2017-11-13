jQuery(document).ready(function($) {
    var cj_aufp_metabox = $('#cj_aufp_metabox');

    $('#cj_aufp_metabox_addUserButton').click(function() {
        var _this = $(this),
            _loader = _this.next(),
            _result = cj_aufp_metabox.find('.cj_aufp_metabox__result');

        cj_loading_start(_this, _loader, _result);

        var sendData = {};
        sendData.action = 'cj_aufp_AddUser';
        sendData.nonce = _this.data('nonce');
        sendData.first_name = cj_aufp_metabox.find('#cj_aufp__first_name').val();
        sendData.last_name = cj_aufp_metabox.find('#cj_aufp__last_name').val();
        sendData.email = cj_aufp_metabox.find('#cj_aufp__email').val();
        sendData.password = cj_aufp_metabox.find('#cj_aufp__password').val();

        $.post(ajaxurl, sendData, function(data) {
            if (data.status == 'success') {
                cj_aufp_metabox.find('.cj_aufp_rows').fadeOut(500, function() {
                    _result.html(data.message);
                    _result.addClass('s');
                    _result.show();
                });
                cj_aufp_metabox.find('.cj_aufp_metabox__buttons').fadeOut(500);
            } else if (data.status == 'error') {
                _result.html(data.message);
                _result.addClass('e');
                _result.stop().slideDown(200);
            } else {
                console.log(data);
            }

            cj_loading_end(_this, _loader);
        }, 'json');
    });

    function cj_loading_start(_button, _loader, _result) {
        _button.prop('disabled', true);
        _button.addClass('beezy');
        _loader.addClass('is-active');
        _result.removeClass('e');
        _result.stop().slideUp(200);
    }

    function cj_loading_end(_button, _loader) {
        _button.prop('disabled', false);
        _button.removeClass('beezy');
        _loader.removeClass('is-active');
    }
});