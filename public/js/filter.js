$(document).ready(function(){
    $('.image-container').mousemove(function(e){
        var x = e.pageX - $(this).offset().left;
        var y = e.pageY - $(this).offset().top;
        $(this).children('img').css({'transform-origin': x + 'px ' + y + 'px'});
        $(this).children('img').css({'transform': 'scale(2)'});
    });
    $('.image-container').mouseleave(function(e){
        $(this).children('img').css({'transform': 'scale(1)'});
    });


    var base = location.protocol + '//' + location.host;
        var route = document.title;

        console.log(route);

        // document.addEventListener('DOMContentLoaded', function() {
        //     var title = route;
        //     console.log(title);
        //     $('#'+title+'_nav').addClass('active');
        //     $('#main_').addClass('h-100');

        // });
        $('.toggle-list-categoria').click(function() {
            var filter = $(this).data('filter'); // Obtiene el valor de data-filter
            var $ul = $('ul.' + filter); // Busca el elemento ul con la clase correspondiente
            // $ul.toggleClass('medidas'); // Alterna la clase d-none del elemento ul}
            var $arrow = $(this).find('.arrow');
            if ($ul.hasClass('medidas')) {
                $ul.removeClass('medidas');
                $arrow.addClass('rotate');
            } else {
                $ul.addClass('medidas');
                $arrow.removeClass('rotate');
            }
            console.log(filter);
        });
        $('.toggle-list-artista').click(function() {
            var filter = $(this).data('filter'); // Obtiene el valor de data-filter
            var $ul = $('ul.' + filter); // Busca el elemento ul con la clase correspondiente
            // $ul.toggleClass('medidas'); // Alterna la clase d-none del elemento ul}
            var $arrow = $(this).find('.arrow');
            if ($ul.hasClass('medidas')) {
                $ul.removeClass('medidas');
                $arrow.addClass('rotate');
            } else {
                $ul.addClass('medidas');
                $arrow.removeClass('rotate');
            }
        });
        $('.toggle-list-tecnica').click(function() {
            var filter = $(this).data('filter'); // Obtiene el valor de data-filter
            var $ul = $('ul.' + filter); // Busca el elemento ul con la clase correspondiente
            // $ul.toggleClass('medidas'); // Alterna la clase d-none del elemento ul}
            var $arrow = $(this).find('.arrow');
            if ($ul.hasClass('medidas')) {
                $ul.removeClass('medidas');
                $arrow.addClass('rotate');
            } else {
                $ul.addClass('medidas');
                $arrow.removeClass('rotate');
            }
        });

});

function filterByYear(year) {
    showall();
    if (year === 'Todos') {
        $('#content-articles .content-articles').show();
    } else {
        $('#content-articles .content-articles').hide();
        $('#content-articles .content-articles[data-year="' + year + '"]').show();
    }
    $('#content-articles .content-articles[data-year="' + year + '"]').show();
}

function filterByCategory(year) {
    showall();
    if (year === 'Todos') {
        $('#content-articles .content-articles').show();
    } else {
        $('#content-articles .content-articles').hide();
        $('#content-articles .content-articles[data-category="' + year + '"]').show();
    }
    $('#content-articles .content-articles[data-category="' + year + '"]').show();
}

function filterByTechnic(year) {
    showall();
    if (year === 'Todos') {
        $('#content-articles .content-articles').show();
    } else {
        $('#content-articles .content-articles').hide();
        $('#content-articles .content-articles[data-technic="' + year + '"]').show();
    }
    $('#content-articles .content-articles[data-technic="' + year + '"]').show();
}

function filterByArtist(year) {
    showall();
    if (year === 'Todos') {
        $('#content-articles .content-articles').show();
    } else {
        $('#content-articles .content-articles').hide();
        $('#content-articles .content-articles[data-artist="' + year + '"]').show();
    }
    $('#content-articles .content-articles[data-artist="' + year + '"]').show();
}

function filterArticlesByPrice() {

    const articles = contentArticles.getElementsByClassName('content-articles');
    const selectedPrice = parseInt(priceRange.value);
    showall();

    console.log(selectedPrice);
    for (let i = 0; i < articles.length; i++) {
        const article = articles[i];
        const articlePricemin = parseInt(article.getAttribute('data-pricemin'));
        const articlePricemax = parseInt(article.getAttribute('data-pricemax'));

        if ( articlePricemin >= selectedPrice || selectedPrice <= articlePricemax   )  {
            article.style.display = 'block';
        } else {
            article.style.display = 'none';
        }
    }
}

function darFormatoPrecio(precio) {
        // Convertir el precio a número y aplicar formato
        return '$' + parseFloat(precio).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

priceRange.addEventListener('input', () => {

    priceValue.textContent = darFormatoPrecio(priceRange.value);
    showall();
    filterArticlesByPrice();
});

function highlightSize(size) {
    showall();
    const articles = document.querySelectorAll('#content-articles .content-articles');
    console.log(articles);

    articles.forEach(article => {
            const width = parseInt(article.getAttribute('data-width'));
            const height = parseInt(article.getAttribute('data-height'));

            if (size === 'pequeño' && (width < 40 || height < 40)) {
                article.classList.add('highlight');

            } else if (size === 'mediano' && (width < 40 && width > 100) && (height < 40 && height > 100)) {
                article.classList.add('highlight');
            } else if (size === 'grande' && (width > 100 || height > 100)) {
                article.classList.add('highlight');
            } else {
                article.classList.remove('highlight');
            }
    });
}
if (screen.width < 800) {
    console.log('oo');
    $('#main_').removeClass("row");
}

function showall(){
    console.log('MuestraTodo');
    $('#content-articles .content-articles[data-show=0]').show();

}

function handleCheckboxChangeTecnic(checkbox, year) {
    if (checkbox.checked) {
        // Checkbox marcado, mostrar solo los elementos asociados al año
        $('#content-articles .content-articles').hide();
        $('#content-articles .content-articles[data-technic="' + year + '"]').show();
        var anyChecked = $('input[name="tecnica_checkbox[]"]:checked').length > 0;
        if (anyChecked) {
            // Mostrar solo los elementos asociados a los checkboxes marcados
            var checkedValues = $('input[name="tecnica_checkbox[]"]:checked').map(function(){
                return this.value;
            }).get();
            $('#content-articles .content-articles').hide();
            checkedValues.forEach(function(value) {
                $('#content-articles .content-articles[data-technic="' + value + '"]').show();
            });
        } else {
            // Si no hay otros checkboxes marcados, mostrar todos los elementos
            $('#content-articles .content-articles').show();
        }
    } else {
        // Checkbox desmarcado
        // Verificar si hay otros checkboxes marcados
        var anyChecked = $('input[name="tecnica_checkbox[]"]:checked').length > 0;
        if (!anyChecked) {
            // Si no hay otros checkboxes marcados, mostrar todos los elementos
            $('#content-articles .content-articles').show();
        } else {
            // Si hay otros checkboxes marcados, mantener solo los elementos asociados a los checkboxes marcados
            var checkedValues = $('input[name="tecnica_checkbox[]"]:checked').map(function(){
                return this.value;
            }).get();
            $('#content-articles .content-articles').hide();
            checkedValues.forEach(function(value) {
                $('#content-articles .content-articles[data-technic="' + value + '"]').show();
            });
        }
    }
}
function handleCheckboxChangeArtist(checkbox, year) {
    if (checkbox.checked) {
        // Checkbox marcado, mostrar solo los elementos asociados al año
        $('#content-articles .content-articles').hide();
        $('#content-articles .content-articles[data-artist="' + year + '"]').show();
        var anyChecked = $('input[name="artista_checkbox[]"]:checked').length > 0;
        if (anyChecked) {
            // Mostrar solo los elementos asociados a los checkboxes marcados
            var checkedValues = $('input[name="artista_checkbox[]"]:checked').map(function(){
                return this.value;
            }).get();
            $('#content-articles .content-articles').hide();
            checkedValues.forEach(function(value) {
                $('#content-articles .content-articles[data-artist="' + value + '"]').show();
            });
        } else {
            // Si no hay otros checkboxes marcados, mostrar todos los elementos
            $('#content-articles .content-articles').show();
        }
    } else {
        // Checkbox desmarcado
        // Verificar si hay otros checkboxes marcados
        var anyChecked = $('input[name="artista_checkbox[]"]:checked').length > 0;
        if (!anyChecked) {
            // Si no hay otros checkboxes marcados, mostrar todos los elementos
            $('#content-articles .content-articles').show();
        } else {
            // Si hay otros checkboxes marcados, mantener solo los elementos asociados a los checkboxes marcados
            var checkedValues = $('input[name="artista_checkbox[]"]:checked').map(function(){
                return this.value;
            }).get();
            $('#content-articles .content-articles').hide();
            checkedValues.forEach(function(value) {
                $('#content-articles .content-articles[data-artist="' + value + '"]').show();
            });
        }
    }
}
function handleCheckboxChangeCategory(checkbox, year) {
    if (checkbox.checked) {
        // Checkbox marcado, mostrar solo los elementos asociados al año
        $('#content-articles .content-articles').hide();
        $('#content-articles .content-articles[data-category="' + year + '"]').show();
        var anyChecked = $('input[name="categoria_checkbox[]"]:checked').length > 0;
        if (anyChecked) {
            // Mostrar solo los elementos asociados a los checkboxes marcados
            var checkedValues = $('input[name="categoria_checkbox[]"]:checked').map(function(){
                return this.value;
            }).get();
            $('#content-articles .content-articles').hide();
            checkedValues.forEach(function(value) {
                $('#content-articles .content-articles[data-category="' + value + '"]').show();
            });
        } else {
            // Si no hay otros checkboxes marcados, mostrar todos los elementos
            $('#content-articles .content-articles').show();
        }
    } else {
        // Checkbox desmarcado
        // Verificar si hay otros checkboxes marcados
        var anyChecked = $('input[name="categoria_checkbox[]"]:checked').length > 0;
        if (!anyChecked) {
            // Si no hay otros checkboxes marcados, mostrar todos los elementos
            $('#content-articles .content-articles').show();
        } else {
            // Si hay otros checkboxes marcados, mantener solo los elementos asociados a los checkboxes marcados
            var checkedValues = $('input[name="categoria_checkbox[]"]:checked').map(function(){
                return this.value;
            }).get();
            $('#content-articles .content-articles').hide();
            checkedValues.forEach(function(value) {
                $('#content-articles .content-articles[data-category="' + value + '"]').show();
            });
        }
    }
}
