$('#addSkill').click(function(){
    $('#skillModal').toggle(function(){
        $(this).removeClass('hidden');
    });
})
$('#addSkill2').click(function(){
    $('#skillModal').toggle(function(){
        $(this).removeClass('hidden');
    });
})

$('#cancelModal').click(function(){
    $('#skillModal').toggle(function(){
        $(this).addClass('hidden');
    });
})

$('.deleteModal').on('click', function () {
    console.log("clicking")
    const skillId = $(this).data('id');
    $('#deleteSkillId').val(skillId);

    $('#deleteSkillModal').toggle(()=>{
        $("#deleteSkillModal").addClass('hidden');
    })
});

$('#cancelDeleteModal').click(()=>{
    $("#deleteSkillModal").toggle(()=>{
        $(this).addClass('hidden');
    })
})