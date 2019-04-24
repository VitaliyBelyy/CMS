$(document).ready(function() {

    // ДОБАВИТЬ ЗАПИСЕЙ НА ГЛАВНОЙ

    var addBtn = $(".show-more");
    var hiddenBooks = $(".product-exhibition__product-preview[data-hidden]");
    var HOMEPAGE_NUM_ARTICLES = 10;
    var booksNum = HOMEPAGE_NUM_ARTICLES;

    if( hiddenBooks.length > 0) addBtn.fadeIn();

    addBtn.click(function(event) {
        event.preventDefault();
        console.log(hiddenBooks.length);
        $(this).hide();

        var i = 0
        for(i; i < HOMEPAGE_NUM_ARTICLES; i++) {
            if ( !(i in hiddenBooks) ) break;
            
            $(hiddenBooks[i]).removeAttr("data-hidden");
        }
        booksNum += i;

        hiddenBooks = $(".product-exhibition__product-preview[data-hidden]");
        if( hiddenBooks.length > 0) addBtn.fadeIn();
    });

    //ПАРАМЕТРЫ СЛАЙДЕРА

    $(".main-slider.owl-carousel").owlCarousel({
        margin: 15,
        loop: true,
        nav: true,
        items: 1,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true
    });

    //

    $(".details-panel__navigation-direction").click(function(event) {
    	event.preventDefault();
        $(".details-panel__navigation-direction").removeClass('details-panel__navigation-direction_active');
        $(this).addClass('details-panel__navigation-direction_active');

        var contentType = $(this).attr("data-direction");

        $(".details-panel__info-item").removeClass('details-panel__info-item_visible');
        $("#" + contentType).addClass('details-panel__info-item_visible');  
    });

    //СОРТИРОВКА НА ГЛАВНОЙ СТРАНИЦЕ

    $(".products-section__filter-parameter").click(function(event) {
        event.preventDefault();
        $(".products-section__filter-parameter").removeClass('products-section__filter-parameter_active');
        $(this).addClass('products-section__filter-parameter_active');

        var orderBy = $(this).attr("data-order");

         $.ajax({
            url: `data.php?action=getBooks&orderBy=${orderBy}`,             
            dataType : "json", 
            success: fillShowcase  
        });
    });

    function fillShowcase(data) {
        var showcase = $('.product-exhibition__showcase');
        var content = '';

        $.each(data['books'], function(i, book) {
            var viewAttr = (i >= booksNum) ? "data-hidden" : "";
            var image =  '';

            if(book['imageExtension']) {
                image = `<img class="product-exhibition__product-thumbnail" src="images/books/thumb/${ book['id'] + book['imageExtension'] }" alt="product thumbnail">`
            }

            var discount = '';

            if(book['discount']) {
                discount = 
                    `<div class="product-exhibition__product-discount">
                        <p class="product-exhibition__product-discount-info">-<span class="product-exhibition__product-discount-rate">${ book['discount'] }</span>%</p>
                    </div>`;
            }

            var bookDetails = 
                `<div class="product-exhibition__product-preview" ${viewAttr}>
                    <a href=".?action=viewBook&amp;bookId=${book['id']}" class="product-exhibition__product-permalink">
                        ${image}
                    </a>
                    <p class="product-exhibition__product-name">${ book['name'] }</p>
                    <p class="product-exhibition__product-price">${ book['price'] } грн.</p>
                    ${discount}
                </div>`;

            content += bookDetails;
        });
        
        showcase.html(content);

        hiddenBooks = $(".product-exhibition__product-preview[data-hidden]");
        if( hiddenBooks.length > 0) addBtn.fadeIn();
    }

    //ОБРАБОТКА ФОРМЫ КОНТАКТОВ

    $(".contact-form__submit").click(function(event) {
        event.preventDefault();

        var name = $("#name-input").val().replace(/[<>{}$]/g, "");
        var email = $("#email-input").val().replace(/[<>{}$]/g, "");
        var message = $("#textarea").val().replace(/[<>{}$]/g, "");

        $("#name-input").val("");
        $("#email-input").val("");
        $("#textarea").val("");

        $.post(
          "message.php",
          {
            name: name,
            email: email,
            message: message
          },
          onAjaxSuccess
        );
    });

    function onAjaxSuccess(data) {
        switch(data) {
            case '200':
                alert("Повідомлення надіслано успішно!");
                break;
            case '500':
                alert("Під час відправки повідомлення сталася помилка!");
                break;
        }
    }

    //ОБРАБОТКА ФОРМЫ КОММЕНТАРИЕВ

    $(".comments-form__submit").click(function(event) {
        event.preventDefault();

        var id = $(".product-panel__title").attr("data-id");
        var name = $("#name-input").val().replace(/[<>{}$]/g, "");
        var email = $("#email-input").val().replace(/[<>{}$]/g, "");
        var message = $("#textarea").val().replace(/[<>{}$]/g, "");

        $("#name-input").val("");
        $("#email-input").val("");
        $("#textarea").val("");

        $.post(
          "comment.php",
          {
            book_code: id,
            author_name: name,
            author_email: email,
            message: message
          },
          renderComment
        );
    });

    function renderComment(data) {
        var commentsList = $(".comments-panel__comment-list");
        var comment = 
            `<li class="comments-panel__comment">
                <div class="comments-panel__author-details">
                    <img src="images/comment-author.png" class="comments-panel__author-thumbnail" alt="comment author">
                    <p class="comments-panel__author-name">${ data['author_name'] }</p>
                </div>
                <div class="comments-panel__comment-content">
                    <p class="comments-panel__comment-text">${ data['message'] }</p>
                </div>
            </li>`;

        $(".comments-panel__notice").hide();
        commentsList.append(comment);
    }

});
