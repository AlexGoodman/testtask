var queryArr = {};


function lastImgSize(imgBlock){
    var width = $(imgBlock).last().outerWidth();
    var img = $(imgBlock).last().find('img');
    if (img.outerWidth() < img.outerHeight()) {
        img.css('width', width);
    } else {
        img.css('height', width);
    }
}

function getNews(page, query){
    $('#more-news').hide();

    var queryStr = '';
    if(query){
        queryStr = 'q=' + query + '&';
    }

    var url = 'http://api.nytimes.com/svc/search/v2/articlesearch.json?' +
        queryStr +
        'fq=source:("The New York Times")' +
        '&page='+ page +
        '&api-key=aa5105c5cdb2d525a157aea8b5bf690a:6:72254658';

    $.get(url, '', function (data) {

        var docs = data.response.docs;

        console.log(docs);
        for(var i in docs){
            var string = '';
            string += '<div class="previewBlock">';

            if(
                docs[i].multimedia.length > 1 &&
                1 in docs[i].multimedia &&
                'url' in docs[i].multimedia[1]
            ){
                var img = 'http://nytimes.com/'+ docs[i].multimedia[1]['url'];
                string += '<div class="previewImg"><img src="'+ img +'"></div>';
            } else{
                string +=  '<div class="previewImg">' +
                                '<div class="noImg">NO<br>Image</div></div>';
                var img = false;
            }

            string += '<div class="newsLink" data-url="'+ docs[i].web_url+'"' +
                            'data-img="'+ img +'">' + docs[i].snippet + '</div></div>';
            $('#finish-line').before(string);

            var count = $('.previewBlock').length;

            if(count % 5 == 0 ){
                $('.previewBlock').last().addClass('last5');
            }
            else if((count - 1) % 5 == 0){
                $('.previewBlock').last().addClass('first5');
            }

            if(count % 3 == 0 ){
                $('.previewBlock').last().addClass('last3');
            }
            else if((count - 1) % 3 == 0){
                $('.previewBlock').last().addClass('first3');
            }

            $('.newsLink').last().on('click', function(){
                showPopup();
                $('#popup-title').html($(this).html());
                $('#popup-body-content').html('');

                if(!$('#top-menu').hasClass('mobileHidden')){
                    toggleMobileMenu('#mobile-menu-toggle');
                }
                if(!$('#search-block').hasClass('mobileHidden')){
                    toggleMobileSearch('#mobile-search-toggle');
                }

                var thisObj = $(this);
                $.post('php/page.php', {'url' : thisObj.attr('data-url')}, function(data){
                    if(thisObj.attr('data-img') != 'false') {
                        $('#popup-body-content').append(
                            '<div class="popupImgBlock"><img src="' + thisObj.attr('data-img') + '"></div>'
                        );
                        lastImgSize('.popupImgBlock');
                    }

                    $('#popup-body-content').append(data);
                }, 'json');
            });

            if(img) {
                lastImgSize('.previewBlock');
            }
        }

        queryArr = data.response.meta;
        queryArr.query = query;

        if(queryArr.hits - (queryArr.offset + 10) > 0 ){
            $('#more-news').show();
        }
    }, 'json');
}

function getQuery(){
    $('#search-button').on('click', function(){
        hidePopup();
        $('.previewBlock').remove();
        var query = $('#search-input').val();
        getNews(0, query);
    });
}

function moreNews(){
    $('#more-news').on('click', function(){
        hidePopup();
        getNews(queryArr.offset / 10 + 1, queryArr.query);
    });
}

function toggleMobileSearch(clickObj){
    $('#search-block').toggleClass('mobileHidden');
    $(clickObj).find('.sprite')
        .toggleClass('sprite-search_mobile')
        .toggleClass('sprite-search_mobile_2x');
}

function toggleMobileMenu(clickObj){
    $('#top-menu').toggleClass('mobileHidden');
    $(clickObj).find('.sprite')
        .toggleClass('sprite-burger_menu')
        .toggleClass('sprite-burger_menu_2x');
}

function hideObj(obj){
    $(obj).addClass('hidden');
}

function showObj(obj){
    $(obj).removeClass('hidden');
}

function hidePopup(){
    hideObj('#popup');
    $('body').removeClass('noScroll');
}

function showPopup(){
    showObj('#popup');
    $('body').addClass('noScroll');
}
