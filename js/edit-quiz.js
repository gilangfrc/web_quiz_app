$(function () {
    new ClipboardJS('#quiz-code');

    $('#quiz-code').attr('data-original-title', 'Quiz Code');
    $('[data-toggle="tooltip"]').tooltip();
    
    $('#check-1').change(function () {
        answerSelected('#check-1', '#a-1');
    });
    $('#check-2').change(function () {
        answerSelected('#check-2', '#a-2');
    });
    $('#check-3').change(function () {
        answerSelected('#check-3', '#a-3');
    });
    $('#check-4').change(function () {
        answerSelected('#check-4', '#a-4');
    });

    $('#quiz-code').click(function (e) { 
        e.preventDefault();
        $(this).attr('data-original-title', 'Copied!');
        $(this).tooltip('show');
        $('#quiz-code').attr('data-original-title', 'Quiz Code');
    });

    //Add New Question & Edit Question
    $('.form-question').on('submit',function () {
        // e.preventDefault();
        
        const action = $('.form-question').attr('id');
        if (action === "form-add-question") {
            var url_destination = "/question/create";
        }
        else {
            var url_destination = "/question/update";
        }

        const id = $('#id').val();
        const time = $('#quiz-time').val();
        const question = $('#question').val();

        var selected_answer = [];
        $.each($("input[name='select-answer']:checked"), function(){            
            selected_answer.push($(this).val());
        });

        var answer = [];
        $.each($("input[name='answer']"), function(){            
            answer.push($(this).val());
        });

        $.ajax({
            type: "POST",
            url: url_destination,
            data: {
                    id:id,
                    time:time, 
                    question:question,
                    answer:answer,
                    selected_answer:selected_answer
            },
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    $('.form-question').trigger('reset');
                    window.location.href = data.url;
                    // location.reload();
                }
            }
        });
        // $('#modal-add-question').modal('hide');
    });

    //Change Modal Info For Confirm Delete Question
    $('.delete-question-btn').on('click', function (event) {
        $('#question-id').val($(this).data('question-id'));
        $('#delete-modal-question-title').text("No. "+$(this).data('question-no'));
        $('#modal-delete-question').modal();
    });

    //Delete Question
    // $('#form-delete-question').on('submit', function (e) {
    //     // e.preventDefault();
    //     const id = $('#delete-modal-question-id').val();

    //     $.ajax({
    //         type: "POST",
    //         url: "/question/delete",
    //         data: {id:id},
    //         dataType: "JSON",
    //         success: function (data) {
    //             window.location.href = data.url;
    //         }
    //     });
    // });

    //Change Modal Info onclick #add-question-btn after .edit-question-btn
    $('#add-question-btn').on('click', function () {
        clearModalForm();
        const no = document.querySelectorAll('#no-question').length;
        $('#modal-no').html("No. "+(no+1));
        $('#add-modal-btn').html('Add Question');
        $('#form-edit-question').attr('id', 'form-add-question');
    });

    //Change Modal Info onclick .edit-question-btn And Update Question
    $('.edit-question-btn').on('click', function () {
        clearModalForm();
        $('#modal-no').html("No. "+$(this).data('question-no'));
        $('#add-modal-btn').html('Change Question');
        $('#form-add-question').attr('id', 'form-edit-question');

        const id = $(this).data('question-id');

        $.ajax({
            type: "POST",
            url: "/question/get",
            data: {id:id},
            dataType: "JSON",
            success: function (response) {
                $('#id').val(response.data.id_question);
                $('#quiz-time').val(response.data.time);
                $('#question').val(response.data.question);

                for (let j = 0; j < response.data.answer.length; j++) {
                    if (response.data.answer[j].is_answer == "1") {
                        $('#check-'+(j+1)).prop('checked', true);
                        $('#a-'+(j+1)).attr('style', 'border: 1px solid #00dfab;background: #d4edda;');
                    }
                    $('#a-'+(j+1)).val(response.data.answer[j].choice);
                }
            }
        });
    });

    //Function To Change Border and Input Text onchecked
    function answerSelected(attrCheck, attrInputText) {
        if($(attrCheck).is(':checked')) {
            $(attrInputText).attr('style', 'border: 1px solid #00dfab;background: #d4edda;');
        } else {
            $(attrInputText).removeAttr('style');
        }
    }

    //Function To Clear Modal When Click Button Create Or Edit
    function clearModalForm() {
        $('#quiz-time').val("15");
        $('#question').val("");
        for (let j = 1; j<=4; j++){
            $('#check-'+j).prop('checked', false);
            $('#a-'+j).val("");
            $('#a-'+j).removeAttr('style');
        }
    }
});