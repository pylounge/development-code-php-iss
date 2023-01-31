$(function(){

    var suggest_items = null;

    $('.who').bind("change keyup input click", function() {
        if(this.value.length == 3)
        {
            $.ajax({
                type: 'post',
                url: "search.php", //Путь к обработчику
                data: {'referal':this.value},
                response: 'json',
                success: function(data){
                    suggest_items = JSON.parse(data);
                    update();
                }
            })
        } else if (this.value.length < 3)
        {
            $(".search_result").fadeOut();
            $(".search_result").empty();
            suggest_items = null;
        }

        if (this.value.length > 3)
        {
            update();
        }
    })

    function update()
    {
        var empty = 0;
        $(".search_result").empty();
        
        if (suggest_items === null)
        {
            $(".search_result").append('<div>Не найдено</div>');
            $(".search_result").fadeIn();
            return;
        }

        for(var row of suggest_items)
        {
            if (row.name.startsWith($('.who').val()))
            {
                $(".search_result").append('<div>' + row.name + '</div>');
                empty += 1;
                if (empty == 5) break;
            }
        }
        if (empty===0)
        {
            $(".search_result").append('<div>Не найдено</div>');
        }
        $(".search_result").fadeIn();
    }

    $(".search_result").hover(function(){
        $(".who").blur(); //Убираем фокус с input
    })
    
    $(".search_result").on("click", "div", function(){
        $(".who").val($(this).text());
        $(".search_result").fadeOut();
    })
})