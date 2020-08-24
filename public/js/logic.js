
$(".edit").on("click", function(){
    const taskId = $(this).attr("data-id")
    var currentValue = document.getElementById(taskId).innerHTML;
    console.log(currentValue);
    $(`#${taskId}`).html
        (
        `<input placeholder="${currentValue}" name="new_task_name"></input>`
        )
})