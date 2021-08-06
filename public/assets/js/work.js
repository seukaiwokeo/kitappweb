const book_row = '<div class="col-md-3"><div class="card book" data-id="{id}"><div class="cover card-img-top" id="e_cover" style="background-image: url({cover})"></div><div class="card-body"><h5 class="card-title" id="e_title">{title}</h5><div class="author" id="e_author">{author}</div><div class="pages" id="e_pages">{page_count} sayfa</div><div class="d-grid gap-1"><button onclick="editBook({id})" class="btn btn-primary" type="button">Düzenle</button></div></div></div></div>';
let lid = 0; // son düzenlenmek istenen kitabın id si global
let editBookM; // global kullanım için

// ön izlemeler
$("#title").on("change keydown paste input", function() {
    $("#preview_title").text($(this).val());
});
$("#author").on("change keydown paste input", function() {
    $("#preview_author").text($(this).val());
});
$("#page_count").on("change keydown paste input", function() {
    $("#preview_pages").text($(this).val() + " sayfa");
});
$("#title_m").on("change keydown paste input", function() {
    $("#preview_title_m").text($(this).val());
});
$("#author_m").on("change keydown paste input", function() {
    $("#preview_author_m").text($(this).val());
});
$("#page_count_m").on("change keydown paste input", function() {
    $("#preview_pages_m").text($(this).val() + " sayfa");
});

function getBooks(q) // kitap listesini çekelim
{
    $.ajax({
        type: "POST", // route dışındaki tüm parametreleri post olarak aldığımız için
        url: "admin/action/book_list", // api url
        data: {
            q: q
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
        .done(function(x) {
            $("#book_list").html("");
            var data = JSON.parse(JSON.stringify(x))["data"]; // gelen json verisinin data dizisini çekiyoruz.
            if (data != null && data.length > 0) // data boş mu kontrolü
            {
                $.each(data, function(i, v) {
                    /*
                        const olarak tanımladığımız html kodunda veritabanımızdaki columnların nereye koyulacağını belirlemek için
                        basitçe bir algoritma oluşturuyorum {sütunadı} şeklinde belirtilen yerleri sütunların değerleri ile değiştirsin.
                    */
                    if (v["id"] != null) {
                        var row_html = book_row;
                        $.each(v, function(j, z) {
                            row_html = row_html.replaceAll('{' + j + '}', v[j]);
                        });
                        $("#book_list").append(row_html); // sonuçta üretilen html kodunu book_list id sine sahip nesnenin içine atsın
                    }
                });
            }
        }).fail(function(data, textStatus, xhr) { // status code 200 dönmezse
        $.notify("Bir hata oluştu.", "error");
    });
}

function editBook(id) {
    lid = id;
    $.ajax({
        type: "POST", // route dışındaki tüm parametreleri post olarak aldığımız için
        url: "admin/action/book", // api url
        data: {
            q: lid
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
        .done(function(x) {
            var data = JSON.parse(JSON.stringify(x))["data"];
            console.log(data);
            if(data != null) {
                $.each(data, function (i, v) {
                    if ($("#" + i + "_m").length) $("#" + i + "_m").val(v);
                });
                $("#preview_cover_m").css("background-image", "url(" + data["cover"] + ")");
                $("#preview_title_m").text(data["title"]);
                $("#preview_author_m").text(data["author"]);
                $("#preview_pages_m").text(data["page_count"] + " sayfa");
                editBookM.show();
            }
        }).fail(function(data, textStatus, xhr) { // status code 200 dönmezse
        $.notify("Bir hata oluştu.", "error");
    });
}

$("#cover").change(function() {
    var fd = new FormData();
    var files = $('#cover')[0].files;
    if (files.length > 0) {
        fd.append("image", files[0]);
        $.ajax({
            url: "admin/action/upload_cover",
            type: "post",
            data: fd,
            contentType: false,
            processData: false,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(x) {
                console.log(x);
                var data = JSON.parse(JSON.stringify(x))["data"];
                if (data == 1) {
                    $.notify("İzin verilmeyen uzantı.", "error");
                } else if (data == 0) {
                    $.notify("Bir hata oluştu.", "error");
                } else {
                    $("#preview_cover").css("background-image", "url(" + data + ")");
                    $("#cover_url").val(data);
                }
            },
        });
    }
});

$("#cover_file_m").change(function() {
    var fd = new FormData();
    var files = $('#cover_file_m')[0].files;
    if (files.length > 0) {
        fd.append("image", files[0]);
        $.ajax({
            url: "admin/action/upload_cover",
            type: "post",
            data: fd,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(x) {
                var data = JSON.parse(JSON.stringify(x))["data"];
                if (data == 1) {
                    $.notify("İzin verilmeyen uzantı.", "error");
                } else if (data == 0) {
                    $.notify("Bir hata oluştu.", "error");
                } else {
                    $("#preview_cover_m").css("background-image", "url(" + data + ")");
                    $("#cover_m").val(data);
                }
            },
        });
    }
});

$("#adding_book").submit(function(event) {
    if (this.checkValidity()) {
        var title = $("#title").val();
        var summary = $("#summary").val();
        var cover = $("#cover_url").val();
        var author = $("#author").val();
        var page_count = $("#page_count").val();
        var publishing_date = $("#publishing_date").val();
        var maket_link = $("#maket_link").val();
        var market_price = $("#market_price").val();
        $.ajax({
            type: "POST", // route dışındaki tüm parametreleri post olarak aldığımız için
            url: "admin/action/book_add", // api url
            data: {
                title: title,
                summary: summary,
                cover: cover,
                author: author,
                page_count: page_count,
                publishing_date: publishing_date,
                maket_link: maket_link,
                market_price: market_price,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
            .done(function(x) {
                var data = JSON.parse(JSON.stringify(x))["data"]; // yeni eklenen kitabın id sini çekiyoruz
                var row_html = book_row;
                row_html = row_html.replaceAll('{id}', data).replaceAll('{title}', title).replaceAll('{cover}', cover).replaceAll('{author}', author).replaceAll("{page_count}", page_count);
                $("#book_list").html(row_html + $("#book_list").html());
                $.notify("Kitap başarıyla eklendi.", "success");
            }).fail(function(data, textStatus, xhr) { // status code 200 dönmezse
            $.notify("Bir hata oluştu.", "error");
        });
    }
    return false;
});

$("#saving_book").submit(function(event) {
    if (this.checkValidity()) {
        var title = $("#title_m").val();
        var summary = $("#summary_m").val();
        var cover = $("#cover_m").val();
        var author = $("#author_m").val();
        var page_count = $("#page_count_m").val();
        var publishing_date = $("#publishing_date_m").val();
        var maket_link = $("#maket_link_m").val();
        var market_price = $("#market_price_m").val();
        $.ajax({
            type: "POST", // route dışındaki tüm parametreleri post olarak aldığımız için
            url: "admin/action/book_edit", // api url
            data: {
                id: lid,
                title: title,
                summary: summary,
                cover: cover,
                author: author,
                page_count: page_count,
                publishing_date: publishing_date,
                maket_link: maket_link,
                market_price: market_price,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
            .done(function(x) {
                var o = $('.book[data-id="' + lid + '"]');
                o.find("#e_title").text(title);
                o.find("#e_author").text(author);
                o.find("#e_pages").text(page_count + " sayfa");
                o.find("#e_cover").css("background-image", "url(" + cover + ")");
                editBookM.hide();
                $.notify("Kitap başarıyla güncellendi.", "success");
            }).fail(function(data, textStatus, xhr) { // status code 200 dönmezse
            $.notify("Bir hata oluştu.", "error");
        });
    }
    return false;
});

function removeBook() {
    $.ajax({
        type: "POST", // route dışındaki tüm parametreleri post olarak aldığımız için
        url: "admin/action/book_remove", // api url
        data: {
            q: lid
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
        .done(function(x) {
            var o = $('.book[data-id="' + lid + '"]');
            o.parent().remove();
            editBookM.hide();
            $.notify("Kitap başarıyla silindi.", "success");
        }).fail(function(data, textStatus, xhr) { // status code 200 dönmezse
        alert("Bir hata oluştu.");
    });
}

$(function() {

    $('.date input').datepicker({
        format: "yyyy-mm-dd", // veritabanında varsayılan olarak yyyy-mm-dd şeklinde kabul ettiği için yapıyoruz
        language: "tr", // türkçe göstersin
        autoclose: true, // tarih seçilince otomatik kapatsın
        todayHighlight: true // bugünü otomatik işaretlesin
    });
    editBookM = new bootstrap.Modal(document.getElementById('editBookM'), {
        keyboard: false
    })
    getBooks(); // kitapları listele
    // form onayı için
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
});
