$(function () {
    'use strict';
    $('.answer').on('click', function(){
        var $selected = $(this);
        if ($selected.hasClass('correct') || $selected.hasClass('wrong')) {
            return;
        }
        $selected.addClass('selected');
        var answer = $selected.text();
        $.post('/_answer.php' , {
            answer : answer,
            token : $('#token').val()
        }).done(function(res){
            $('.answer').each(function () {
                if ($(this).text() === res.correct_answer) {
                    //correct
                    $(this).addClass('correct');
                }else {
                    //wrong
                    $(this).addClass('wrong');
                }
            });
            if (answer === res.correct_answer) {
                //correct
                $selected.text(answer + '...Correct!!');
            }else {
                //wrong
                $(this).addClass('wrong');
                $selected.text(answer + '... Wrong!!');
            }
            $('#btn').removeClass('disabled');
        });
        $('#btn').on('click', function(){
            if (!$(this).hasClass('disabled')) {
                location.reload();
            }
        }).done()
    });
});
