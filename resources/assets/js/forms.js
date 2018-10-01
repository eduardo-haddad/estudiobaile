$(document).ready(function(){

    $('#tags_list').select2({
        placeholder: "Select or add tags",
        tags: true,
        multiple: true,
        tokenSeparators: [",", " "],
        createTag: function(newTag) {
            if ($.trim(newTag.term) === '') { return null; }
            return {
                id: 'new:' + newTag.term,
                text: newTag.term + ' (novo)'
            };
        }
    });

});