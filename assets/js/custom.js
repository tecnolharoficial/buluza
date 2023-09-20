if(window.location.host == 'localhost') {
    var PATH = window.location.protocol + '//' + window.location.host + '/buluza/';
}
else {
    var PATH = window.location.protocol + '//' + window.location.host + '/buluza/';
}

(function($) {
    function applyMasks() {
        $('.date').mask('00/00/0000');
        $('.time').mask('00:00');
        $('.date_time').mask('00/00/0000 00:00:00');
        $('.cep').mask('00000-000');
        $('.phone').mask('0000-0000');
        $('.phone_with_ddd').mask('(00) 0000-0000');
        $('.phone_us').mask('(000) 000-0000');
        $('.mixed').mask('AAA 000-S0S');
        $('.ip_address').mask('099.099.099.099');
        $('.percent').mask('##0,00%', {reverse: true});
        $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
        $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
        $('.fallback').mask("00r00r0000", {
            translation: {
                'r': {
                    pattern: /[\/]/,
                    fallback: '/'
                },
                placeholder: "__/__/____"
            }
        });
        $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
        $('.cep_with_callback').mask('00000-000', {
            onComplete: function(cep) {
                console.log('Mask is done!:', cep);
            },
            onKeyPress: function(cep, event, currentField, options){
                console.log('A key was pressed!:', cep, ' event: ', event, 'currentField: ', currentField.attr('class'), ' options: ', options);
            },
            onInvalid: function(val, e, field, invalid, options){
                var error = invalid[0];
                console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
            }
        });
        $('.crazy_cep').mask('00000-000', {onKeyPress: function(cep, e, field, options){
            var masks = ['00000-000', '0-00-00-00'];
            mask = (cep.length>7) ? masks[1] : masks[0];
            $('.crazy_cep').mask(mask, options);
        }});
        $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
        $('.cpf').mask('000.000.000-00', {reverse: true});
        $('.money').mask('#.##0,00', {reverse: true});
        var SPMaskBehavior = function(val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };
        $('.sp_celphones').mask(SPMaskBehavior, spOptions);
        $('pre').each(function(i, e) {hljs.highlightBlock(e)});
    }
    $(document).ready(function() {
        applyMasks();
    });
    $(document).on('ajaxSuccess', function() {
        applyMasks();
    });
})(jQuery);

$('textarea').on('input', function () {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

$(document).ready(function() {
    var slide = document.querySelector('.slide');
    if(slide != null) {
        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');
        let currentIndex = 0;
        const numSlides = slide.children.length;
        const slideWidth = slide.clientWidth;
        if($(window).width() <= 768) {
            var slidesPerDesktopView = 1;
        }
        else {
            var slidesPerDesktopView = 2;
        }
        function updateSlider() {
            const translateX = -currentIndex * (slideWidth / slidesPerDesktopView);
            slide.style.transform = `translateX(${translateX}px)`;
        }
        nextButton.addEventListener('click', () => {
            currentIndex += slidesPerDesktopView;
            if(currentIndex >= numSlides) {
                currentIndex = 0;
            }
            updateSlider();
        });
        prevButton.addEventListener('click', () => {
            currentIndex -= slidesPerDesktopView;
            if(currentIndex < 0) {
                currentIndex = Math.floor((numSlides - 1) / slidesPerDesktopView) * slidesPerDesktopView;
            }
            updateSlider();
        });
        window.addEventListener('resize', () => {
            const newSlideWidth = slide.clientWidth;
            currentIndex = Math.round(currentIndex * (newSlideWidth / slideWidth));
            slideWidth = newSlideWidth;
            updateSlider();
        });
        window.addEventListener('load', () => {
            updateSlider();
        });
    }
});

if(window.location.pathname.indexOf('editar-anuncio') == -1) {
    $.getJSON(PATH + 'assets/json/estados_cidades.json', (data) => {
        let items = [];
        let options = '<option selected value disabled>Selecione o estado</option>';
        for(val of data) {
            options += '<option value="' + val.nome + '">' + val.nome + '</option>';
        }
        $('select[name="estado"]').html(options);
        $('select[name="estado"]').change( () => {
            let options_cidades = '<option selected value disabled>Selecione a cidade</option>';
            let str = $('select[name="estado"]').val();
            for(val of data) {
                if(val.nome == str) {
                    for(val_city of val.cidades) {
                        options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                    }
                }
            }
            $('select[name="cidade"]').html(options_cidades);
        }).change();
    });
}